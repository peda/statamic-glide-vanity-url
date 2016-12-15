# GlideVantiyUrl by [Peter Rainer](http://peterrainer.at)
## A Glide Vanity URL addon for Statamic CMS V2.x

Glide by default does generate URLs like `/img/id/2dce8a2e-0442-4ac2-8b0c-19797c38fa35?w=140&h=140&fit=crop&s=ed1663629ceb59715b52cbb6975a4eb1` 

The route is defined as `/img/id/{id}/{filename?}` which means a filename can optionally be supplied after the ID

As image file names are an important aspect of SEO (search engine optimization) you want to be preserved even when manipulating the image. Therefore we are injecting the filename after the ID to look something like `/img/id/2dce8a2e-0442-4ac2-8b0c-19797c38fa35/jedi-set.jpg?w=140&h=140&fit=crop&s=ed1663629ceb59715b52cbb6975a4eb1`

### MIT License

Copyright (c) 2016 Peter Rainer

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.