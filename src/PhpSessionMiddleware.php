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

        // adds the session cookie to the response
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

        // returns the response
        return $cookie->addToResponse($response);
    }
}