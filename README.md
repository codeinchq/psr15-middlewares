# PSR-15 middlewares 

This library provides a collection of [PSR-15](https://www.php-fig.org/psr/psr-15/) middlewares. It is currently under active developpment and the collection should grow fast in the upcoming months.

**The current collection includes:** 
* `HttpVersionCheckMiddleware` insure the HTTP version of the response is the same of the version used for the request.
* `PoweredByHeaderMiddleware` adds a `X-Powered-By` HTTP headers to the response
* `RespExtraHttpHeadersMiddleware` add extra HTTP headers to the response


## Installation

This library is available through [Packagist](https://packagist.org/packages/codeinchq/lib-psr15middlewares) and can be installed using [Composer](https://getcomposer.org/): 

```bash
composer require codeinchq/lib-psr15middlewares
```


## Dependencies 

* [PHP 7.2](http://php.net/releases/7_2_0.php)
* [`psr/http-message`](https://packagist.org/packages/psr/http-message) for the standard PSR-7 objects interfaces ;
* [`psr/http-server-middleware`](https://packagist.org/packages/psr/http-server-middleware) for the PSR-15 middleware interface ;
* [`psr/http-server-handler`](https://packagist.org/packages/psr/http-server-handler) for the PSR-15 request handler interface ;

## License 
This library is published under the MIT license (see the [`LICENSE`](https://github.com/codeinchq/lib-gui/blob/master/LICENSE) file).


