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
// Time:     12:33
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests\HttpHeaders\Security;
use CodeInc\Psr15Middlewares\HttpHeaders\Security\StrictTransportSecurityMiddleware;
use CodeInc\Psr15Middlewares\Tests\HttpHeaders\AbstractHttpHeaderMiddlewareTestCase;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class StrictTransportSecurityMiddlewareTest
 *
 * @uses StrictTransportSecurityMiddleware
 * @package CodeInc\Psr15Middlewares\Tests\HttpHeaders\Security
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
final class StrictTransportSecurityMiddlewareTest extends AbstractHttpHeaderMiddlewareTestCase
{
    /**
     * @return ServerRequestInterface
     */
    private function getHttpsRequest():ServerRequestInterface
    {
        $request = ServerRequest::fromGlobals();
        return $request->withUri($request->getUri()->withScheme('https'));
    }


    /**
     * @return ServerRequestInterface
     */
    private function getHttpRequest():ServerRequestInterface
    {
        $request = ServerRequest::fromGlobals();
        return $request->withUri($request->getUri()->withScheme('http'));
    }


    public function testDisabled():void
    {
        $middleware = new StrictTransportSecurityMiddleware();
        self::assertResponseNotHasHeader(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'Strict-Transport-Security'
        );

        $middleware = new StrictTransportSecurityMiddleware(3600);
        $middleware->setMaxAge(null);
        self::assertResponseNotHasHeader(
            $middleware->process(ServerRequest::fromGlobals(), new FakeRequestHandler()),
            'Strict-Transport-Security'
        );
    }


    public function testOnHttpRequest():void
    {
        // the header should only be added to responses for HTTPS requests
        $middleware = new StrictTransportSecurityMiddleware(3600);
        self::assertResponseNotHasHeader(
            $middleware->process($this->getHttpRequest(), new FakeRequestHandler()),
            'Strict-Transport-Security'
        );
    }


    public function testMaxAge():void
    {
        // with max age
        $middleware = new StrictTransportSecurityMiddleware(3600);
        self::assertResponseHasHeaderValue(
            $middleware->process($this->getHttpsRequest(), new FakeRequestHandler()),
            'Strict-Transport-Security',
            ['max-age=3600']
        );

        // with max age change
        $middleware->setMaxAge(7200);
        self::assertResponseHasHeaderValue(
            $middleware->process($this->getHttpsRequest(), new FakeRequestHandler()),
            'Strict-Transport-Security',
            ['max-age=7200']
        );
    }


    public function testIncludeSubDomains():void
    {
        // with max age + include subdomains
        $middleware = new StrictTransportSecurityMiddleware(3600);
        $middleware->includeSubDomains();
        self::assertResponseHasHeaderValue(
            $middleware->process($this->getHttpsRequest(), new FakeRequestHandler()),
            'Strict-Transport-Security',
            ['max-age=3600; includeSubDomains']
        );

        // with max age change + include subdomains
        $middleware->setMaxAge(7200);
        self::assertResponseHasHeaderValue(
            $middleware->process($this->getHttpsRequest(), new FakeRequestHandler()),
            'Strict-Transport-Security',
            ['max-age=7200; includeSubDomains']
        );
    }


    public function testEnablePreload():void
    {
        // with max age + preload
        $middleware = new StrictTransportSecurityMiddleware(3600);
        $middleware->enablePreload();
        self::assertResponseHasHeaderValue(
            $middleware->process($this->getHttpsRequest(), new FakeRequestHandler()),
            'Strict-Transport-Security',
            ['max-age=3600; preload']
        );

        // with max age change + preload
        $middleware->setMaxAge(7200);
        self::assertResponseHasHeaderValue(
            $middleware->process($this->getHttpsRequest(), new FakeRequestHandler()),
            'Strict-Transport-Security',
            ['max-age=7200; preload']
        );
    }


    public function testIncludeSubDomainsAndEnablePreload():void
    {
        // with max age + include subdomaines + preload
        $middleware = new StrictTransportSecurityMiddleware(3600);
        $middleware->enablePreload();
        $middleware->includeSubDomains();
        self::assertResponseHasHeaderValue(
            $middleware->process($this->getHttpsRequest(), new FakeRequestHandler()),
            'Strict-Transport-Security',
            ['max-age=3600; includeSubDomains; preload']
        );

        // with max age change + include subdomaines + preload
        $middleware->setMaxAge(7200);
        self::assertResponseHasHeaderValue(
            $middleware->process($this->getHttpsRequest(), new FakeRequestHandler()),
            'Strict-Transport-Security',
            ['max-age=7200; includeSubDomains; preload']
        );
    }
}