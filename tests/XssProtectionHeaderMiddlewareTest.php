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
// Time:     11:43
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests;
use CodeInc\Psr15Middlewares\MiddlewareException;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;
use CodeInc\Psr15Middlewares\XssProtectionHeaderMiddleware;
use GuzzleHttp\Psr7\ServerRequest;


/**
 * Class XssProtectionHeaderMiddlewareTest
 *
 * @see XssProtectionHeaderMiddleware
 * @package CodeInc\Psr15Middlewares\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class XssProtectionHeaderMiddlewareTest extends AbstractHttpHeaderMiddlewareTestCase
{
    private const FAKE_REPORT_URI = 'https://example.com/report-uri';


    public function testMiddleware():void
    {
        // enabled
        $middleware = new XssProtectionHeaderMiddleware(true);
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'X-Xss-Protection',
            [1]
        );

        // disabled
        $middleware = new XssProtectionHeaderMiddleware(false);
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'X-Xss-Protection',
            [0]
        );
    }


    /**
     * @throws MiddlewareException
     */
    public function testBlockMode():void
    {
        $middleware = new XssProtectionHeaderMiddleware(true);
        $middleware->enableBlockMode();
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'X-Xss-Protection',
            ['1; mode=block']
        );
    }


    /**
     * @throws MiddlewareException
     */
    public function testReportUri():void
    {
        $middleware = new XssProtectionHeaderMiddleware(true);
        $middleware->setReportUri(self::FAKE_REPORT_URI);
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'X-Xss-Protection',
            ['1; report='.self::FAKE_REPORT_URI]
        );
    }


    /**
     * @expectedException \Exception
     */
    public function testExceptions():void
    {
        $middleware = new XssProtectionHeaderMiddleware(true);
        $middleware->enableBlockMode();
        $middleware->setReportUri(self::FAKE_REPORT_URI);
    }
}