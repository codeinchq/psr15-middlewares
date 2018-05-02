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
// Date:     02/05/2018
// Time:     18:13
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests\CustomResponses;
use CodeInc\Psr15Middlewares\CustomResponses\Assets\SiteMapResponse;
use CodeInc\Psr15Middlewares\CustomResponses\SiteMapMiddleware;
use CodeInc\Psr15Middlewares\Tests\Assets\BlankResponse;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tackk\Cartographer\ChangeFrequency;


/**
 * Class SiteMapMiddlewareTest
 *
 * @uses SiteMapMiddleware
 * @package CodeInc\Psr15Middlewares\Tests\CustomResponses
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class SiteMapMiddlewareTest extends TestCase
{
    public function testRegularRequest():void
    {
        $middleware = $this->getMiddleware();
        $request = FakeServerRequest::getSecureServerRequestWithPath('/test');
        self::assertFalse($middleware->isSiteMapRequest($request));
        $response = $middleware->process(
            $request,
            new FakeRequestHandler()
        );
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertInstanceOf(BlankResponse::class, $response);
    }

    public function testSiteMapRequest():void
    {
        $middleware = $this->getMiddleware();
        $request = FakeServerRequest::getSecureServerRequestWithPath('/sitemap.xml');
        self::assertTrue($middleware->isSiteMapRequest($request));
        $response = $middleware->process(
            $request,
            new FakeRequestHandler()
        );
        $this->assertSiteMapResponse($response);
    }

    public function testSiteMapCustomRequest():void
    {
        $middleware = $this->getMiddleware();
        $middleware->addSiteMapUriPath('/test/sitemap.xml');
        $request = FakeServerRequest::getSecureServerRequestWithPath('/test/sitemap.xml');
        self::assertTrue($middleware->isSiteMapRequest($request));
        $response = $middleware->process(
            $request,
            new FakeRequestHandler()
        );
        $this->assertSiteMapResponse($response);
    }

    /**
     * @param ResponseInterface $response
     */
    private function assertSiteMapResponse(ResponseInterface $response):void
    {
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertInstanceOf(SiteMapResponse::class, $response);

        $responseBody = $response->getBody()->__toString();
        self::assertRegExp('#<loc>http://foo\\.com</loc>#ui', $responseBody);
        self::assertRegExp('#<loc>http://foo.com/about</loc>#ui', $responseBody);
    }

    /**
     * @return SiteMapMiddleware
     */
    private function getMiddleware():SiteMapMiddleware
    {
        $middleware = new SiteMapMiddleware();
        $middleware->add('http://foo.com', '2005-01-02', ChangeFrequency::WEEKLY, 1.0);
        $middleware->add('http://foo.com/about', '2005-01-01');
        return $middleware;
    }
}