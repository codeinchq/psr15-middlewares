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
// Time:     14:12
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests;
use CodeInc\Psr15Middlewares\PhpGpcVarsMiddleware;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeServerRequest;
use CodeInc\Psr7Responses\TextResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class PhpGpcVarsMiddlewareTest
 *
 * @uses PhpGpcVarsMiddleware
 * @package CodeInc\Psr15Middlewares\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
final class PhpGpcVarsMiddlewareTest extends TestCase
{
    public function testMiddleware():void
    {
        $middleware = new PhpGpcVarsMiddleware();
        $response = $middleware->process(
            FakeServerRequest::getSecureServerRequest()->withQueryParams(['foo' => 'bar']),
            new PhpGpcVarsMiddlewareTestRequestHandler()
        );
        self::assertEquals($response->getBody()->__toString(), 'bar');
    }
}


final class PhpGpcVarsMiddlewareTestRequestHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request):ResponseInterface
    {
        return new TextResponse((string)@$_GET['foo']);
    }
}