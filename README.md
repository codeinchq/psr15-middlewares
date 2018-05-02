# PSR-15 middlewares 

This library provides a collection of [PSR-15](https://www.php-fig.org/psr/psr-15/) middlewares. 



## The current collection includes

### HTTP headers
* [`AddHttpHeadersMiddleware`](src/HttpHeaders/AddHttpHeadersMiddleware.php) Adds HTTP headers to the response
* [`CacheMiddleware`](src/HttpHeaders/CacheMiddleware.php) Adds cache headers to the response (using [micheh/psr7-cache](https://packagist.org/packages/micheh/psr7-cache))
* [`NoCacheMiddleware`](src/HttpHeaders/NoCacheMiddleware.php) Adds cache prevention headers to the response (using [micheh/psr7-cache](https://packagist.org/packages/micheh/psr7-cache))
* [`PoweredByMiddleware`](src/HttpHeaders/PoweredByMiddleware.php) Adds a `X-Powered-By` HTTP headers to the response
* [`HttpVersionCheckMiddleware`](src/HttpHeaders/HttpVersionCheckMiddleware.php) Insure that the HTTP version of the response is the same of the version used for the request.

### Security HTTP headers
* [`ContentSecurityPolicyMiddleware`](src/HttpHeaders/Security/ContentSecurityPolicyMiddleware.php) Adds a [`Content-Security-Policy`](https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy) HTTP headers to the response
* [`ContentTypeOptionsMiddleware`](src/HttpHeaders/Security/ContentTypeOptionsMiddleware.php) Adds a [`X-Content-Type-Options`](https://developer.mozilla.org/docs/Web/HTTP/Headers/X-Content-Type-Options) HTTP headers to the response
* [`ExpectCtMiddleware`](src/HttpHeaders/Security/ExpectCtMiddleware.php) Adds a [`Expect-CT`](https://developer.mozilla.org/docs/Web/HTTP/Headers/Expect-CT) HTTP headers to the response
* [`FrameOptionsMiddleware`](src/HttpHeaders/Security/FrameOptionsMiddleware.php) Adds a [`X-Frame-Options`](https://developer.mozilla.org/docs/Web/HTTP/Headers/X-Frame-Options) HTTP headers to the response
* [`ReferrerPolicyMiddleware`](src/HttpHeaders/Security/ReferrerPolicyMiddleware.php) Adds a [`Referrer-Policy`](https://developer.mozilla.org/docs/Web/HTTP/Headers/Referrer-Policy) HTTP headers to the response
* [`StrictTransportSecurityMiddleware`](src/HttpHeaders/Security/StrictTransportSecurityMiddleware.php) Adds a [`Strict-Transport-Security`](https://developer.mozilla.org/docs/Web/HTTP/Headers/Strict-Transport-Security) HTTP headers to the response
* [`XssProtectionMiddleware`](src/HttpHeaders/Security/XssProtectionMiddleware.php) Adds a [`X-Xss-Protection`](https://developer.mozilla.org/docs/Web/HTTP/Headers/X-XSS-Protection) HTTP headers to the response

## Custom responses
* [`RobotsTxtMiddleware`](src/CustomResponses/RobotsTxtMiddleware.php) Sends a response to `/robots.txt` requests using [arcanedev/robots](https://github.com/ARCANEDEV/Robots) to generate the response in the [`robots.txt` format](https://developers.google.com/search/reference/robots_txt)
* [`SiteMapMiddleware`](src/CustomResponses/SiteMapMiddleware.php) Send a response to `/sitemap.xml` requests using [tackk/cartographer](https://github.com/tackk/cartographer) to generate the response in the [`sitemap.xml` format](https://www.sitemaps.org/protocol.html)

### Other middleware
* [`BlockUnsecureRequestsMiddleware`](src/BlockUnsecureRequestsMiddleware.php) Blocks unsecure (other than `HTTPS`) requests responses
* [`CallableMiddleware`](src/CallableMiddleware.php) Uses a callable as a middleware 
* [`ExceptionCaptureMiddleware`](src/ExceptionCaptureMiddleware.php) Captures exceptions thrown during the handling of the request 
* [`PhpGpcVarsMiddleware`](src/PhpGpcVarsMiddleware.php) Extract PSR-7 request data to PHP GPC variables `$_GET`, `$_POST`, `$_COOKIE` and `$_SERVER`
* [`PhpSessionMiddleware`](src/PhpSessionMiddleware.php) Read sesion cookie from PSR-7 requests and add session cookie to PSR-7 responses


## Installation

This library is available through [Packagist](https://packagist.org/packages/codeinc/psr15-middlewares) and can be installed using [Composer](https://getcomposer.org/): 

```bash
composer require codeinc/psr15-middlewares
```

## License

The library is published under the MIT license (see [`LICENSE`](LICENSE) file).