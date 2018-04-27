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
// Time:     14:23
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests;
use CodeInc\Psr15Middlewares\PhpSessionMiddleware;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


session_start();
if (!isset($_SESSION)) {
    $_SESSION = [];
}

/**
 * Class PhpSessionMiddlewareTest
 *
 * @uses PhpSessionMiddleware
 * @package CodeInc\Psr15Middlewares\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
final class PhpSessionMiddlewareTest extends TestCase
{
    /**
     * @throws \HansOtt\PSR7Cookies\InvalidArgumentException
     */
    public function testSessionHeaders():void
    {
        $middleware = new PhpSessionMiddleware();
        $response = $middleware->process(
            FakeServerRequest::getSecureServerRequest(),
            new FakeRequestHandler()
        );

        self::assertEquals(
            $response->getHeaderLine('Cache-Control'),
            'private, no-cache, no-store, must-revalidate'
        );
        self::assertStringStartsWith(
            session_name().'='.session_id(),
            $response->getHeaderLine('Set-Cookie')
        );
        self::assertNotEmpty($response->getHeaderLine('Expires'));
    }

    /**
     * @throws \HansOtt\PSR7Cookies\InvalidArgumentException
     */
    public function testSessionValues():void
    {
        $_SESSION['count'] = 0;

        $middleware = new PhpSessionMiddleware();
        $middleware->process(
            FakeServerRequest::getSecureServerRequest(),
            new PhpSessionMiddlewareTestRequestHandler()
        );
        self::assertEquals($_SESSION['count'], 1);

        $middleware->process(
            FakeServerRequest::getSecureServerRequest(),
            new PhpSessionMiddlewareTestRequestHandler()
        );
        self::assertEquals($_SESSION['count'], 2);
    }


}


final class PhpSessionMiddlewareTestRequestHandler extends FakeRequestHandler
{
    public function handle(ServerRequestInterface $request):ResponseInterface
    {
        $_SESSION['count']++;
        return parent::handle($request);
    }
}