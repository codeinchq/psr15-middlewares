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
// Time:     12:59
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests\HttpHeaders;
use CodeInc\Psr15Middlewares\HttpHeaders\PoweredByMiddleware;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;
use GuzzleHttp\Psr7\ServerRequest;


/**
 * Class PoweredByMiddlewareTest
 *
 * @uses PoweredByMiddleware
 * @package CodeInc\Psr15Middlewares\Tests\HttpHeaders
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class PoweredByMiddlewareTest extends AbstractHttpHeaderMiddlewareTestCase
{
    public function testDisabled():void
    {
        $middleware = new PoweredByMiddleware();
        self::assertResponseNotHasHeader(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'X-Powered-By'
        );
    }

    public function testDisabling():void
    {
        $middleware = new PoweredByMiddleware('Test');
        $middleware->setPoweredBy(null);
        self::assertResponseNotHasHeader(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'X-Powered-By'
        );
    }

    public function testEnabled():void
    {
        $middleware = new PoweredByMiddleware();
        $middleware->setPoweredBy('Test');
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'X-Powered-By',
            ['Test']
        );

        $middleware = new PoweredByMiddleware('Test');
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'X-Powered-By',
            ['Test']
        );
    }

    public function testValueChange():void
    {
        $middleware = new PoweredByMiddleware('Test');
        $middleware->setPoweredBy('Test2');
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'X-Powered-By',
            ['Test2']
        );
    }
}