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
// Time:     14:10
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class PhpGpcVarsMiddleware
 *
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class PhpGpcVarsMiddleware implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
    {
        // saving previous global variables value
        $prevPOST = $_POST;
        $prevCOOKIE = $_COOKIE;
        $prevGET = $_GET;
        $prevSERVER = $_SERVER;

        // extracting to global variables
        $_POST = $request->getParsedBody();
        $_COOKIE = $request->getCookieParams();
        $_GET = $request->getQueryParams();
        $_SERVER = $request->getServerParams();

        // processing
        $response = $handler->handle($request);

        // restoring global variables value
        $_POST =& $prevPOST;
        $_COOKIE =& $prevCOOKIE;
        $_GET =& $prevGET;
        $_SERVER =& $prevSERVER;

        return $response;
    }
}