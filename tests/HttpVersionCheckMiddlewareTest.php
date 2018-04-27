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
// Time:     13:43
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests;
use CodeInc\Psr15Middlewares\HttpVersionCheckMiddleware;
use CodeInc\Psr15Middlewares\Tests\Assets\BlankResponse;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;


/**
 * Class HttpVersionCheckMiddlewareTest
 *
 * @uses HttpVersionCheckMiddleware
 * @package CodeInc\Psr15Middlewares\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class HttpVersionCheckMiddlewareTest extends TestCase
{
    public function testMiddleware():void
    {
        $testResponse = (new BlankResponse())->withProtocolVersion('1.1');

        $middleware = new HttpVersionCheckMiddleware();
        $response = $middleware->process(
            ServerRequest::fromGlobals()->withProtocolVersion('2.0'),
            new FakeRequestHandler($testResponse)
        );

        self::assertEquals($testResponse->getProtocolVersion(), '1.1');
        self::assertEquals($response->getProtocolVersion(), '2.0');
    }
}