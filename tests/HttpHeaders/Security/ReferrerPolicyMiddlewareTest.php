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
// Time:     11:01
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests\HttpHeaders\Security;
use CodeInc\Psr15Middlewares\HttpHeaders\Security\ReferrerPolicyMiddleware;
use CodeInc\Psr15Middlewares\Tests\Assets\FakeRequestHandler;
use CodeInc\Psr15Middlewares\Tests\HttpHeaders\AbstractHttpHeaderMiddlewareTestCase;
use GuzzleHttp\Psr7\ServerRequest;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class ReferrerPolicyMiddlewareTest
 *
 * @uses ReferrerPolicyMiddleware
 * @package CodeInc\Psr15Middlewares\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class ReferrerPolicyMiddlewareTest extends AbstractHttpHeaderMiddlewareTestCase
{
    private const MIDDLEWARE_VALUES = ReferrerPolicyMiddleware::ALL_VALUES;
    private const MIDDLEWARE_METHODS = [
        'setNoReferer' => ReferrerPolicyMiddleware::VALUE_NO_REFERRER,
        'setNoRefererWhenDowngrade' => ReferrerPolicyMiddleware::VALUE_NO_REFERRER_WHEN_DOWNGRADE,
        'setOrigin' => ReferrerPolicyMiddleware::VALUE_ORIGIN,
        'setOriginWhenCrossOrigin' => ReferrerPolicyMiddleware::VALUE_ORIGIN_WHEN_CROSS_ORIGIN,
        'setSameOrigin' => ReferrerPolicyMiddleware::VALUE_SAME_ORIGIN,
        'setStrictOrigin' => ReferrerPolicyMiddleware::VALUE_STRICT_ORIGIN,
        'setStrictOriginWhenCrossOrigin' => ReferrerPolicyMiddleware::VALUE_STRICT_ORIGIN_WHEN_CROSS_ORIGIN,
        'setUnsafeUrl' => ReferrerPolicyMiddleware::VALUE_UNSAFE_URL,
    ];

    /**
     * @var RequestHandlerInterface
     */
    private $fakeRequestHandler;

    /**
     * @var ServerRequestInterface
     */
    private $serverRequest;


    /**
     * ReferrerPolicyMiddlewareTest constructor.
     *
     * @param null|string $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->fakeRequestHandler = new FakeRequestHandler();
        $this->serverRequest = ServerRequest::fromGlobals();
    }


    public function testMiddlewareConsructor():void
    {
        foreach (self::MIDDLEWARE_VALUES as $value) {
            $middleware = new ReferrerPolicyMiddleware($value);
            $response = $middleware->process($this->serverRequest, $this->fakeRequestHandler);
            self::assertResponseHasHeaderValue($response, 'Referrer-Policy', [$value]);
        }
    }


    public function testMiddlewareMethods():void
    {
        foreach (self::MIDDLEWARE_METHODS as $method => $value) {
            $middleware = new ReferrerPolicyMiddleware();
            call_user_func([$middleware, $method]);
            $response = $middleware->process($this->serverRequest, $this->fakeRequestHandler);
            self::assertResponseHasHeaderValue($response, 'Referrer-Policy', [$value]);
        }
    }
}