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
// Date:     14/03/2018
// Time:     11:09
// Project:  Psr15Middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class HeaderMiddleware
 *
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class HeaderMiddleware implements MiddlewareInterface
{
    /**
     * @var string
     */
    private $headerName;

    /**
     * @var string
     */
    private $headerValue;

    /**
     * @var bool
     */
    private $replace;

    /**
     * AbstractHeaderMiddleware constructor.
     *
     * @param string $headerName
     * @param string $headerValue
     * @param bool $replace
     */
    public function __construct(string $headerName, string $headerValue,
        bool $replace = true)
    {
        $this->headerName = $headerName;
        $this->headerValue = $headerValue;
        $this->replace = $replace;
    }

    /**
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request,
        RequestHandlerInterface $handler):ResponseInterface
    {
        $response = $handler->handle($request);
        if ($this->replace || !$response->hasHeader($this->headerName)) {
            $response = $response->withHeader($this->headerName, $this->headerValue);
        }
        return $response;
    }
}