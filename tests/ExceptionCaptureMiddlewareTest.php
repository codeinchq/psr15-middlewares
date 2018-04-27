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
// Time:     13:48
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests;
use CodeInc\Psr15Middlewares\ExceptionCaptureMiddleware;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeBuggyRequestHandler;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;
use CodeInc\Psr7Responses\ErrorResponse;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;


/**
 * Class ExceptionCaptureMiddlewareTest
 *
 * @uses ExceptionCaptureMiddleware
 * @package CodeInc\Psr15Middlewares\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
final class ExceptionCaptureMiddlewareTest extends TestCase
{
    public function testWithoutException():void
    {
        $middleware = new ExceptionCaptureMiddleware();
        $response = $middleware->process(
            ServerRequest::fromGlobals(),
            new FakeRequestHandler()
        );
        self::assertNotInstanceOf(ErrorResponse::class, $response);
    }

    public function testWithException():void
    {
        $middleware = new ExceptionCaptureMiddleware();
        $response = $middleware->process(
            ServerRequest::fromGlobals(),
            new FakeBuggyRequestHandler()
        );
        /** @var ErrorResponse $response */
        self::assertInstanceOf(ErrorResponse::class, $response);
        self::assertEquals($response->getThrowable()->getMessage(), FakeBuggyRequestHandler::EXCEPTION_MSG);
        self::assertEquals($response->getThrowable()->getCode(), FakeBuggyRequestHandler::EXCEPTION_CODE);
    }
}
