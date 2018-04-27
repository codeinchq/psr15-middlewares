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
// Date:     16/03/2018
// Time:     19:47
// Project:  Psr15Middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares;
use CodeInc\Psr15Middlewares\Tests\CallableMiddlewareTest;
use CodeInc\Psr7Responses\HtmlResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class CallableMiddleware
 *
 * @see CallableMiddlewareTest
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class CallableMiddleware implements MiddlewareInterface
{
    /**
     * @var callable
     */
    private $callable;

    /**
     * CallableMiddleware constructor.
     *
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }


    /**
     * @param callable $callable
     */
    public function setCallable(callable $callable):void
    {
        $this->callable = $callable;
    }


    /**
     * @return callable
     */
    public function getCallable():callable
    {
        return $this->callable;
    }


    /**
     * @inheritdoc
     * @throws MiddlewareException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
    {
        // executes the callable
        try {
            $response = call_user_func($this->callable, $request);
        }
        catch (\Throwable $exception) {
            throw new MiddlewareException($this,
                "Error while executing the callable");
        }

        // processes the response
        if (!$response instanceof ResponseInterface) {
            return new HtmlResponse((string)$response);
        }
        else {
            return $response;
        }
    }
}