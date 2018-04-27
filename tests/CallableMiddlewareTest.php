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
// Time:     13:27
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests;
use CodeInc\Psr15Middlewares\CallableMiddleware;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeServerRequest;
use CodeInc\Psr15Middlewares\Tests\HttpHeaders\AbstractHttpHeaderMiddlewareTestCase;
use CodeInc\Psr7Responses\HtmlResponse;
use CodeInc\Psr7Responses\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class CallableMiddlewareTest
 *
 * @uses CallableMiddleware
 * @package CodeInc\Psr15Middlewares\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
final class CallableMiddlewareTest extends AbstractHttpHeaderMiddlewareTestCase
{
    private const TEST_BODY_1 = 'It\'s a test!';
    private const TEST_BODY_2 = 'It\'s another test!';

    /**
     * @throws \CodeInc\Psr15Middlewares\MiddlewareException
     */
    public function testWithPsr7Response():void
    {
        $middleware = new CallableMiddleware(function(ServerRequestInterface $request):ResponseInterface {
            return new TextResponse(self::TEST_BODY_1);
        });

        $response = $middleware->process(
            FakeServerRequest::getSecureServerRequest(),
            new FakeRequestHandler()
        );
        self::assertEquals($response->getBody()->__toString(), self::TEST_BODY_1);
        self::assertInstanceOf(TextResponse::class, $response);
    }


    /**
     * @throws \CodeInc\Psr15Middlewares\MiddlewareException
     */
    public function testWithCallableReplacement():void
    {
        $middleware = new CallableMiddleware(function(ServerRequestInterface $request):ResponseInterface {
            return new TextResponse(self::TEST_BODY_1);
        });
        $middleware->setCallable(function(ServerRequestInterface $request):ResponseInterface {
            return new HtmlResponse(self::TEST_BODY_2);
        });

        $response = $middleware->process(
            FakeServerRequest::getSecureServerRequest(),
            new FakeRequestHandler()
        );
        self::assertEquals($response->getBody()->__toString(), self::TEST_BODY_2);
        self::assertInstanceOf(HtmlResponse::class, $response);
    }


    /**
     * @throws \CodeInc\Psr15Middlewares\MiddlewareException
     */
    public function testWithRawResponse():void
    {
        $middleware = new CallableMiddleware(function(ServerRequestInterface $request):string {
            return self::TEST_BODY_1;
        });

        $response = $middleware->process(
            FakeServerRequest::getSecureServerRequest(),
            new FakeRequestHandler()
        );
        self::assertEquals($response->getBody()->__toString(), self::TEST_BODY_1);
        self::assertInstanceOf(HtmlResponse::class, $response);
    }


    /**
     * @throws \CodeInc\Psr15Middlewares\MiddlewareException
     */
    public function testWithRequestAttributeResponse():void
    {
        $middleware = new CallableMiddleware(function(ServerRequestInterface $request):string {
            return $request->getAttribute('foo');
        });
        $response = $middleware->process(
            FakeServerRequest::getSecureServerRequest()->withAttribute('foo', 'bar'),
            new FakeRequestHandler()
        );
        self::assertEquals($response->getBody()->__toString(), 'bar');
    }


    /**
     * @throws \CodeInc\Psr15Middlewares\MiddlewareException
     */
    public function testWithResponseHeader():void
    {
        $middleware = new CallableMiddleware(function(ServerRequestInterface $request):ResponseInterface {
            $response = new TextResponse($request->getAttribute('foo'));
            return $response->withHeader('X-Test', 'Test');
        });
        $response = $middleware->process(
            FakeServerRequest::getSecureServerRequest()->withAttribute('foo', 'bar'),
            new FakeRequestHandler()
        );
        self::assertEquals($response->getBody()->__toString(), 'bar');
        self::assertInstanceOf(TextResponse::class, $response);
        self::assertResponseHasHeaderValue($response, 'X-Test', ['Test']);
    }

    /**
     * @expectedException \Exception
     * @throws \CodeInc\Psr15Middlewares\MiddlewareException
     */
    public function testCallableException():void
    {
        $middleware = new CallableMiddleware(function(ServerRequestInterface $request):ResponseInterface {
            throw new \Exception();
        });
        $middleware->process(
            FakeServerRequest::getSecureServerRequest()->withAttribute('foo', 'bar'),
            new FakeRequestHandler()
        );
    }
}