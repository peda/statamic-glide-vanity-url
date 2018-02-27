<?php

namespace Statamic\Addons\GlideVanityUrl;

use Statamic\Extend\ServiceProvider;
use Statamic\API\File;
use League\Glide\Server;
use Statamic\API\Config;
use League\Glide\ServerFactory;
use Statamic\Imaging\ImageGenerator;
use Statamic\Imaging\GlideUrlBuilder;
use Statamic\Imaging\StaticUrlBuilder;
use Statamic\Imaging\GlideImageManipulator;
use Statamic\Contracts\Imaging\ImageManipulator;
use League\Glide\Responses\LaravelResponseFactory;
use Barryvdh\Debugbar\Controllers\AssetController;
use Statamic\API\AssetContainer;
use Statamic\API\Asset as AssetAPI;
use Statamic\Contracts\Assets\Asset;
use Exception;
use Statamic\API\Str;
use Statamic\API\URL;
use League\Glide\Urls\UrlBuilderFactory;
use Statamic\Imaging\ImageUrlBuilder;
use Statamic\Providers\GlideServiceProvider;
use Statamic\Http\Controllers\GlideController;
use Illuminate\Routing\Route;
use Illuminate\Routing\RouteCollection;

class GlideVanityUrlServiceProvider extends GlideServiceProvider
{
    public $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Here we get all the current routes, then add our sitemap route right before the catch-all segment route
        $old_routes = app('router')->getRoutes();
        $new_routes = new RouteCollection();

        foreach ($old_routes as $i => $route) {
            if ($route->getUri() == '{segments?}') {

                $imgRoute = new Route(
                    ['GET'],
                    Config::get('assets.image_manipulation_route').'/asset/{container}/{path}/{filename?}',
                    ['uses' => 'GlideController@generateByAsset']
                );

                $new_routes->add($imgRoute);
            }

            $new_routes->add($route);
        }

        app('router')->setRoutes($new_routes);
    }

    public function register()
    {
        parent::register();

        $this->app->bind(ImageManipulator::class, function () {
            return new GlideImageManipulator($this->getBuilder());
        });
    }

    private function getBuilder()
    {
        $route = Config::get('assets.image_manipulation_route');

        if (Config::get('assets.image_manipulation_cached')) {
            return new StaticUrlBuilder($this->app->make(ImageGenerator::class), [
                'route' => $route
            ]);
        }

        return new GlideVanityUrlBuilder([
            'key' => (Config::get('assets.image_manipulation_secure')) ? Config::getAppKey() : null,
            'route' => $route
        ]);
    }
}

class GlideVanityUrlBuilder extends GlideUrlBuilder
{
    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * Build the URL
     *
     * @param \Statamic\Contracts\Assets\Asset|string $item
     * @param array                                   $params
     * @param string|null                             $filename
     * @return string
     * @throws \Exception
     */
    public function build($item, $params, $filename = null)
    {
        if(!array_has($params, 'q')) {
            $params['q'] = '85';
        }

        $this->item = $item;

        switch ($this->itemType()) {
            case 'url':
                $path = 'http/' . base64_encode($item);
                break;
            case 'asset':
                $path = 'asset/' . base64_encode($this->item->containerId() . '/' . $this->item->path()) . '/' . $this->item->basename();
                break;
            case 'id':
                $path = 'asset/' . base64_encode(str_replace('::', '/', $this->item));
                break;
            case 'path':
                $path = URL::encode($this->item);
                break;
            default:
                throw new Exception("Cannot build a Glide URL without a URL, path, or asset.");
        }

        $builder = UrlBuilderFactory::create($this->options['route'], $this->options['key']);

        if ($filename) {
            $path .= Str::ensureLeft(URL::encode($filename), '/');
        }

        return URL::prependSiteRoot($builder->getUrl($path, $params));
    }
}
