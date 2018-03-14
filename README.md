# PSR-15 middlewares 

This library provides a collection of [PSR-15](https://www.php-fig.org/psr/psr-15/) middlewares. It is currently under active developpment and the collection should grow fast in the upcoming months.

**The current collection includes:** 
* [`CacheMiddleware`](src/CacheMiddleware.php)
* [`ContentSecurityPolicyMiddleware`](src/ContentSecurityPolicyMiddleware.php)
* [`ExceptionCaptureMiddleware`](src/ExceptionCaptureMiddleware.php)
* [`HttpStrictTransportSecurityMiddleware`](src/HttpStrictTransportSecurityMiddleware.php)
* [`HttpVersionCheckMiddleware`](src/HttpVersionCheckMiddleware.php) insure the HTTP version of the response is the same of the version used for the request.
* [`PoweredByHeaderMiddleware`](src/PoweredByHeaderMiddleware.php) adds a `X-Powered-By` HTTP headers to the response
* [`RespExtraHttpHeadersMiddleware`](src/RespExtraHttpHeadersMiddleware.php) add extra HTTP headers to the response
* [`XFrameOptionMiddleware`](src/XFrameOptionsMiddleware.php)
* [`XPoweredByMiddleware`](src/XPoweredByMiddleware.php)


## Installation

This library is available through [Packagist](https://packagist.org/packages/codeinc/psr15-middlewares) and can be installed using [Composer](https://getcomposer.org/): 

```bash
composer require codeinc/psr15-middlewares
```


## Dependencies 

* [PHP 7.2](http://php.net/releases/7_2_0.php)
* [psr/http-message](https://packagist.org/packages/psr/http-message) -> PSR-7 objects interfaces ;
* [psr/http-server-middleware](https://packagist.org/packages/psr/http-server-middleware) -> the PSR-15 middleware interface ;
* [psr/http-server-handler](https://packagist.org/packages/psr/http-server-handler) -> the PSR-15 request handler interface ;

## Recomended libraries

* [relay/relay](https://github.com/relayphp/Relay.Relay) -> A PSR-15 request handler.

## License

The library is published under the MIT license (see [`LICENSE`](LICENSE) file).