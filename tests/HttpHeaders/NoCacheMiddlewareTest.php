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
// Date:     27/04/2018
// Time:     13:24
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests\HttpHeaders;
use CodeInc\Psr15Middlewares\HttpHeaders\NoCacheMiddleware;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;
use GuzzleHttp\Psr7\ServerRequest;


/**
 * Class NoCacheMiddlewareTest
 *
 * @uses NoCacheMiddleware
 * @package CodeInc\Psr15Middlewares\Tests\HttpHeaders
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class NoCacheMiddlewareTest extends AbstractHttpHeaderMiddlewareTestCase
{
    public function testMiddleware():void
    {
        $middleware = new NoCacheMiddleware();
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'Cache-Control',
            ['no-cache, no-store, must-revalidate']
        );
    }
}