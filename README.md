# GlideVantiyUrl by [Peter Rainer](http://peterrainer.at)
## A Glide Vanity URL addon for Statamic CMS V2.5+

Glide by default does generate URLs like `/img/asset/bWFpbi9pbWcvYWJ1LWRoYWJpLWVsZWN0cm8tbWVjaGFuaWNhbC1jb21wYW55LWFyYWJlbC1oYWJ0b29yLmpwZw==?w=800&h=800&fit=crop&q=85` 

The route is defined as `/img/asset/{container}/{path}/{filename?}` which means a filename can optionally be supplied after the path element

As image file names are an important aspect of SEO (search engine optimization) you want to be preserved even when manipulating the image. Therefore we are injecting the filename after the ID to look something like `/img/asset/bWFpbi9pbWcvYWJ1LWRoYWJpLWVsZWN0cm8tbWVjaGFuaWNhbC1jb21wYW55LWFyYWJlbC1oYWJ0b29yLmpwZw==/abu-dhabi-electro-mechanical-company-arabel-habtoor.jpg?w=800&h=800&fit=crop&q=85`

### MIT License

Copyright (c) 2016 Peter Rainer

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
