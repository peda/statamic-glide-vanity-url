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

class GlideVanityUrlServiceProvider extends GlideServiceProvider
{
    public $defer = true;

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
     * @var array
     */
    protected $options;

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
        $this->item = $item;

        switch ($this->itemType()) {
            case 'asset':
                $path = 'id/' . $this->item->id() . '/' . $this->item->basename();
                break;
            case 'id':
                $asset = ($this->item instanceof Asset)
                    ? $this->item
                    : AssetAPI::find($this->item);
                $path = 'id/' . $this->item . '/' . $asset->basename();
                break;
            case 'url':
                $path = 'http/' . base64_encode($item);
                break;
            case 'path':
                $path = $this->item;
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