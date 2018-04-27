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
// Time:     17:57
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests;
use CodeInc\Psr15Middlewares\BlockUnsecureRequestsMiddleware;
use CodeInc\Psr15Middlewares\Tests\Assets\BlankResponse;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeServerRequest;
use CodeInc\Psr7Responses\ForbiddenResponse;
use PHPUnit\Framework\TestCase;


/**
 * Class BlockUnsecureRequestsMiddlewareTest
 *
 * @uses BlockUnsecureRequestsMiddleware
 * @package CodeInc\Psr15Middlewares\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class BlockUnsecureRequestsMiddlewareTest extends TestCase
{
    public function testSecureRequest():void
    {
        $middleware = new BlockUnsecureRequestsMiddleware(new ForbiddenResponse());
        $response = $middleware->process(
            FakeServerRequest::getSecureServerRequest(),
            new FakeRequestHandler(new BlankResponse())
        );

        $this->assertInstanceOf(BlankResponse::class, $response);
    }


    public function testUnsecureRequest():void
    {
        $middleware = new BlockUnsecureRequestsMiddleware(new ForbiddenResponse());
        $response = $middleware->process(
            FakeServerRequest::getUnsecureServerRequest(),
            new FakeRequestHandler(new BlankResponse())
        );

        $this->assertInstanceOf(ForbiddenResponse::class, $response);
    }
}