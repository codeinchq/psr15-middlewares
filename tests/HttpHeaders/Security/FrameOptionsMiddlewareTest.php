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
// Time:     12:29
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests\HttpHeaders\Security;
use CodeInc\Psr15Middlewares\HttpHeaders\Security\FrameOptionsMiddleware;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeServerRequest;
use CodeInc\Psr15Middlewares\Tests\HttpHeaders\AbstractHttpHeaderMiddlewareTestCase;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;


/**
 * Class FrameOptionsMiddlewareTest
 *
 * @uses FrameOptionsMiddleware
 * @package CodeInc\Psr15Middlewares\Tests\HttpHeaders\Security
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
final class FrameOptionsMiddlewareTest extends AbstractHttpHeaderMiddlewareTestCase
{
    private const TEST_URL = 'https://www.example.org';


    public function testDisabled():void
    {
        $middleware = new FrameOptionsMiddleware();
        self::assertResponseNotHasHeader(
            $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler()),
            'X-Frame-Options'
        );
    }


    public function testDeny():void
    {
        $middleware = new FrameOptionsMiddleware();
        $middleware->denyFrames();
        self::assertResponseHasHeaderValue(
            $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler()),
            'X-Frame-Options',
            ['DENY']
        );
    }


    public function testAllowFromSameOrigin():void
    {
        $middleware = new FrameOptionsMiddleware();
        $middleware->allowFromSameOrigin();
        self::assertResponseHasHeaderValue(
            $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler()),
            'X-Frame-Options',
            ['SAMEORIGIN']
        );
    }


    public function testAllowFrom():void
    {
        $middleware = new FrameOptionsMiddleware();
        $middleware->allowFrom(self::TEST_URL);
        self::assertResponseHasHeaderValue(
            $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler()),
            'X-Frame-Options',
            ['ALLOW-FROM '.self::TEST_URL]
        );
    }


    public function testValueChange():void
    {
        $middleware = new FrameOptionsMiddleware();
        $middleware->denyFrames();
        $middleware->allowFromSameOrigin();
        self::assertResponseHasHeaderValue(
            $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler()),
            'X-Frame-Options',
            ['SAMEORIGIN']
        );
    }
}