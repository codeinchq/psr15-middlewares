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
// Time:     17:35
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests\CustomResponses;
use CodeInc\Psr15Middlewares\CustomResponses\Assets\RobotsTxtResponse;
use CodeInc\Psr15Middlewares\CustomResponses\RobotsTxtMiddleware;
use CodeInc\Psr15Middlewares\Tests\Assets\BlankResponse;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;


/**
 * Class RobotsTxtMiddlewareTest
 *
 * @package CodeInc\Psr15Middlewares\Tests\CustomResponses
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class RobotsTxtMiddlewareTest extends TestCase
{
    public function testRegularRequest():void
    {
        $middleware = new RobotsTxtMiddleware();
        $request = FakeServerRequest::getUnsecureServerRequestWithPath('/test');
        self::assertFalse($middleware->isRobotsTxtRequest($request));
        $response = $middleware->process(
            $request,
            new FakeRequestHandler()
        );
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertInstanceOf(BlankResponse::class, $response);
    }


    public function testRobotsTxt():void
    {
        $middleware = new RobotsTxtMiddleware();
        $middleware->addAllow('/test.html');
        $middleware->addDisallow('/private');
        $middleware->addSitemap('/sitemap.xml');
        $request = FakeServerRequest::getUnsecureServerRequestWithPath('/robots.txt');
        self::assertTrue($middleware->isRobotsTxtRequest($request));
        $response = $middleware->process(
            $request,
            new FakeRequestHandler()
        );
        self::assertInstanceOf(ResponseInterface::class, $response);
        self::assertInstanceOf(RobotsTxtResponse::class, $response);
        $responseBody = $response->getBody()->__toString();
        self::assertRegExp('#Sitemap:\\s+/sitemap.xml#ui', $responseBody);
        self::assertRegExp('#Disallow:\\s+/private#ui', $responseBody);
        self::assertRegExp('#Allow:\\s+/test.html#ui', $responseBody);
    }
}