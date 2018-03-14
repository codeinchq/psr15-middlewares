# PSR-15 middlewares 

This library provides a collection of [PSR-15](https://www.php-fig.org/psr/psr-15/) middlewares. It is currently under active developpment and the collection should grow fast in the upcoming months.

**The current collection includes:** 
* [`CacheMiddleware`](src/CacheMiddleware.php) Add cache headers to the response (via [micheh/psr7-cache](https://packagist.org/packages/micheh/psr7-cache))
* [`ContentSecurityPolicyMiddleware`](src/ContentSecurityPolicyMiddleware.php) Add a [`Content-Security-Policy`](https://developer.mozilla.org/fr/docs/HTTP/Headers/Content-Security-Policy) header to the response
* [`ExceptionCaptureMiddleware`](src/ExceptionCaptureMiddleware.php) Capture exceptions during the `handle()` call
* [`HeaderMiddleware`](src/HeaderMiddleware.php) Add a HTTP header to the response
* [`HttpVersionCheckMiddleware`](src/HttpVersionCheckMiddleware.php) Insure that the HTTP version of the response is the same of the version used for the request.
* [`ReferrerPolicyMiddleware`](src/ReferrerPolicyMiddleware.php) Add a [`Referrer-Policy`](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Referrer-Policy) HTTP headers to the response
* [`RespExtraHttpHeadersMiddleware`](src/RespExtraHttpHeadersMiddleware.php) Add multiple HTTP headers to the response
* [`StrictTransportSecurityMiddleware`](src/StrictTransportSecurityMiddleware.php) Add a [`Strict-Transport-Security`](https://developer.mozilla.org/fr/docs/S%C3%A9curit%C3%A9/HTTP_Strict_Transport_Security) HTTP headers to the response
* [`XContentTypeOptionsMiddleware`](src/XFrameOptionsMiddleware.php) Add a [`X-Content-Type-Options`](https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options) HTTP headers to the response
* [`XFrameOptionMiddleware`](src/XFrameOptionsMiddleware.php) Add a [`X-Frame-Options`](https://developer.mozilla.org/fr/docs/HTTP/Headers/X-Frame-Options) HTTP headers to the response
* [`XPoweredByMiddleware`](src/XPoweredByMiddleware.php) Add a `X-Powered-By` HTTP headers to the response


## Installation

This library is available through [Packagist](https://packagist.org/packages/codeinc/psr15-middlewares) and can be installed using [Composer](https://getcomposer.org/): 

```bash
composer require codeinc/psr15-middlewares
```

## License

The library is published under the MIT license (see [`LICENSE`](LICENSE) file).