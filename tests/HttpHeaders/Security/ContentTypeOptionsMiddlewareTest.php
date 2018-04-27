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
// Time:     12:26
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests\HttpHeaders\Security;
use CodeInc\Psr15Middlewares\HttpHeaders\Security\ContentTypeOptionsMiddleware;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeServerRequest;
use CodeInc\Psr15Middlewares\Tests\HttpHeaders\AbstractHttpHeaderMiddlewareTestCase;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;


/**
 * Class ContentTypeOptionsMiddlewareTest
 *
 * @uses ContentTypeOptionsMiddleware
 * @package CodeInc\Psr15Middlewares\Tests\HttpHeaders\Security
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
final class ContentTypeOptionsMiddlewareTest extends AbstractHttpHeaderMiddlewareTestCase
{
    public function testEnabled():void
    {
        $middleware = new ContentTypeOptionsMiddleware(true);
        self::assertResponseHasHeaderValue(
            $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler()),
            'X-Content-Type-Options',
            ['nosniff']
        );
    }

    public function testDisabled():void
    {
        $middleware = new ContentTypeOptionsMiddleware(false);
        self::assertResponseNotHasHeader(
            $middleware->process(FakeServerRequest::getSecureServerRequest(), new FakeRequestHandler()),
            'X-Content-Type-Options'
        );
    }
}