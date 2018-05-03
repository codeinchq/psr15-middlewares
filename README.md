# PSR-15 middleware 

**:warning: This library is deprecated and should not be used.** 

It is replaced by the following packages offering the same fonctonnalities in a more portable way:

## [codeinc/http-headers-middleware](https://packagist.org/packages/codeinc/http-headers-middleware)

Provides the folowing middleware:
* `AddHttpHeadersMiddleware` Adds HTTP headers to the response
* `CacheMiddleware` Adds cache headers to the response
* `NoCacheMiddleware` Adds cache prevention headers to the response
* `PoweredByMiddleware` Adds a `X-Powered-By` HTTP headers to the response
* `HttpVersionCheckMiddleware` Insure that the HTTP version of the response is the same of the version used for the request.


## [codeinc/robots-txt-middleware](https://packagist.org/packages/codeinc/robots-txt-middleware)

Provides the folowing middleware:
* `RobotsTxtMiddleware` Sends a response to `/robots.txt` requests using [arcanedev/robots](https://github.com/ARCANEDEV/Robots) to generate the response in the [`robots.txt` format](https://developers.google.com/search/reference/robots_txt)


## [codeinc/sitemap-middlware](https://packagist.org/packages/codeinc/sitemap-middlware)

Provides the folowing middleware:
* `SiteMapMiddleware` Send a response to `/sitemap.xml` requests using [tackk/cartographer](https://github.com/tackk/cartographer) to generate the response in the [`sitemap.xml` format](https://www.sitemaps.org/protocol.html)

## [codeinc/compatibility-middleware](https://packagist.org/packages/codeinc/compatibility-middleware)

Provides the folowing middleware:
* `PhpGpcVarsMiddleware` Extract PSR-7 request data to PHP GPC variables `$_GET`, `$_POST`, `$_COOKIE` and `$_SERVER`
* `PhpSessionMiddleware` Read sesion cookie from PSR-7 requests and add session cookie to PSR-7 responses

## [codeinc/security-middleware](https://packagist.org/packages/codeinc/security-middleware)

Provides the folowing middleware:
* `ContentSecurityPolicyMiddleware` Adds a [`Content-Security-Policy`](https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy) HTTP headers to the response
* `ContentTypeOptionsMiddleware` Adds a [`X-Content-Type-Options`](https://developer.mozilla.org/docs/Web/HTTP/Headers/X-Content-Type-Options) HTTP headers to the response
* `ExpectCtMiddleware` Adds a [`Expect-CT`](https://developer.mozilla.org/docs/Web/HTTP/Headers/Expect-CT) HTTP headers to the response
* `FrameOptionsMiddleware` Adds a [`X-Frame-Options`](https://developer.mozilla.org/docs/Web/HTTP/Headers/X-Frame-Options) HTTP headers to the response
* `ReferrerPolicyMiddleware` Adds a [`Referrer-Policy`](https://developer.mozilla.org/docs/Web/HTTP/Headers/Referrer-Policy) HTTP headers to the response
* `StrictTransportSecurityMiddleware` Adds a [`Strict-Transport-Security`](https://developer.mozilla.org/docs/Web/HTTP/Headers/Strict-Transport-Security) HTTP headers to the response
* `XssProtectionMiddleware` Adds a [`X-Xss-Protection`](https://developer.mozilla.org/docs/Web/HTTP/Headers/X-XSS-Protection) HTTP headers to the response
* `BlockUnsecureRequestsMiddleware` Blocks unsecure (other than `HTTPS`) requests responses


## Abandoned middleware

The following middleware are abandoned:
* `CallableMiddleware` Uses a callable as a middleware 
* `ExceptionCaptureMiddleware` Captures exceptions thrown during the handling of the request 


## License

The library is published under the MIT license (see [`LICENSE`](LICENSE) file).