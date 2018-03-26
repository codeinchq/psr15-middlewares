<?php
//
// +---------------------------------------------------------------------+
// | CODE INC. SOURCE CODE                                               |
// +---------------------------------------------------------------------+
// | Copyright (c) 2017 - Code Inc. SAS - All Rights Reserved.           |
// | Visit https://www.codeinc.fr for more information about licensing.  |
// +---------------------------------------------------------------------+
// | NOTICE:  All information contained herein is, and remains the       |
// | property of Code Inc. SAS. The intellectual and technical concepts  |
// | contained herein are proprietary to Code Inc. SAS are protected by  |
// | trade secret or copyright law. Dissemination of this information or |
// | reproduction of this material  is strictly forbidden unless prior   |
// | written permission is obtained from Code Inc. SAS.                  |
// +---------------------------------------------------------------------+
//
// Author:   Joan Fabrégat <joan@codeinc.fr>
// Date:     26/03/2018
// Time:     13:36
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares;
use HansOtt\PSR7Cookies\SetCookie;
use Micheh\Cache\CacheUtil;
use Micheh\Cache\Header\ResponseCacheControl;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class PhpSessionMiddleware
 *
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class PhpSessionMiddleware implements MiddlewareInterface
{
    /**
     * @inheritdoc
     * @throws \HansOtt\PSR7Cookies\InvalidArgumentException
     */
    public function process(ServerRequestInterface $request,
                            RequestHandlerInterface $handler):ResponseInterface
    {
        // reads the session id from the request and starts the session
        if (session_status() != PHP_SESSION_ACTIVE) {
            if (isset($request->getCookieParams()[session_name()])) {
                session_id($request->getCookieParams()[session_name()]);
            }
            session_start();
        }

        // processes the request
        $response = $handler->handle($request);

        // if the response is HTML, adding cache limiter and session cookie
        if (preg_match("#^text/html#ui", $response->getHeaderLine("Content-Type"))) {
            $response = $this->addSessionCookie($response);
            $response = $this->addCacheLimiterHeaders($response);
        }

        return $response;
    }

    /**
     * Adds the cache limiter cookie
     *
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws \HansOtt\PSR7Cookies\InvalidArgumentException
     */
    private function addSessionCookie(ResponseInterface $response):ResponseInterface
    {
        $params = session_get_cookie_params();
        $cookie = new SetCookie(
            session_name(),
            session_id(),
            time() + $params["lifetime"],
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
        return $cookie->addToResponse($response);
    }

    /**
     * Adds cache limiter headers.
     *
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    private function addCacheLimiterHeaders(ResponseInterface $response):ResponseInterface
    {
        $cache = new CacheUtil();
        switch (session_cache_limiter()) {
            case 'public':
                $response = $cache->withExpires($response, time() + session_cache_limiter() * 60);
                $response = $cache->withCacheControl($response,
                    (new ResponseCacheControl())
                        ->withPublic()
                        ->withMaxAge(session_cache_limiter() * 60)
                );
                break;

            case 'private_no_expire':
                $response = $cache->withCacheControl($response,
                    (new ResponseCacheControl())
                        ->withPrivate()
                        ->withMaxAge(session_cache_limiter() * 60)
                );
                break;

            case 'private':
                $response = $cache->withExpires($response, 'Thu, 19 Nov 1981 08:52:00 GMT');
                $response = $cache->withCacheControl($response,
                    (new ResponseCacheControl())
                        ->withPrivate()
                        ->withMaxAge(session_cache_limiter() * 60)
                );
                break;

            case 'nocache':
                $response = $cache->withExpires($response, 'Thu, 19 Nov 1981 08:52:00 GMT');
                $response = $cache->withCacheControl($response,
                    (new ResponseCacheControl())
                        ->withPrivate()
                        ->withCachePrevention()
                );
                $response = $response->withHeader("Program", "no-cache");
                break;
        }
        return $response;
    }
}