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
// Time:     16:58
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests\HttpHeaders\Security;
use CodeInc\Psr15Middlewares\HttpHeaders\Security\ExpectCtMiddleware;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;
use CodeInc\Psr15Middlewares\Tests\HttpHeaders\AbstractHttpHeaderMiddlewareTestCase;
use GuzzleHttp\Psr7\ServerRequest;


/**
 * Class ExpectCtMiddlewareTest
 *
 * @uses ExpectCtMiddleware
 * @package CodeInc\Psr15Middlewares\Tests\HttpHeaders\Security
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
final class ExpectCtMiddlewareTest extends AbstractHttpHeaderMiddlewareTestCase
{
    private const TEST_MAX_AGE = 3600;
    private const TEST_REPORT_URI = 'https://example.org/enfcore/ct';


    public function testDisabled():void
    {
        $middleware = new ExpectCtMiddleware();
        self::assertResponseNotHasHeader(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'Expect-CT'
        );
    }


    public function testEnforce():void
    {
        $middleware = new ExpectCtMiddleware();
        $middleware->setEnforce(true);
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'Expect-CT',
            ['enforce']
        );

        $middleware = new ExpectCtMiddleware(null, true);
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'Expect-CT',
            ['enforce']
        );
    }


    public function testMaxAge():void
    {
        $middleware = new ExpectCtMiddleware();
        $middleware->setMaxAge(self::TEST_MAX_AGE);
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'Expect-CT',
            ['max-age='.self::TEST_MAX_AGE]
        );

        $middleware = new ExpectCtMiddleware(self::TEST_MAX_AGE);
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'Expect-CT',
            ['max-age='.self::TEST_MAX_AGE]
        );
    }


    public function testReportUri():void
    {
        $middleware = new ExpectCtMiddleware();
        $middleware->setReportUri(self::TEST_REPORT_URI);
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'Expect-CT',
            ['report-uri="'.self::TEST_REPORT_URI.'"']
        );

        $middleware = new ExpectCtMiddleware(null, null, self::TEST_REPORT_URI);
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'Expect-CT',
            ['report-uri="'.self::TEST_REPORT_URI.'"']
        );
    }


    public function testAll():void
    {
        $middleware = new ExpectCtMiddleware();
        $middleware->setReportUri(self::TEST_REPORT_URI);
        $middleware->setMaxAge(self::TEST_MAX_AGE);
        $middleware->setEnforce(true);
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'Expect-CT',
            ['report-uri="'.self::TEST_REPORT_URI.'", enforce, max-age='.self::TEST_MAX_AGE]
        );

        $middleware = new ExpectCtMiddleware(self::TEST_MAX_AGE, true, self::TEST_REPORT_URI);
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'Expect-CT',
            ['report-uri="'.self::TEST_REPORT_URI.'", enforce, max-age='.self::TEST_MAX_AGE]
        );
    }


    public function testValueChange():void
    {
        $middleware = new ExpectCtMiddleware(self::TEST_MAX_AGE, true, self::TEST_REPORT_URI);
        $middleware->setReportUri(null);
        $middleware->setMaxAge(null);
        $middleware->setEnforce(false);
        self::assertResponseNotHasHeader(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'Expect-CT'
        );

        $middleware = new ExpectCtMiddleware(self::TEST_MAX_AGE, true, self::TEST_REPORT_URI);
        $middleware->setMaxAge(null);
        self::assertResponseHasHeaderValue(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'Expect-CT',
            ['report-uri="'.self::TEST_REPORT_URI.'", enforce']
        );
    }
}