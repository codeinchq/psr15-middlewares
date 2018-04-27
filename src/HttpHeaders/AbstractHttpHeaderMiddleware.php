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
// Time:     12:05
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\HttpHeaders;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class AbstractSingleValueHttpHeaderMiddleware
 *
 * @package CodeInc\Psr15Middlewares\HttpHeaders
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
abstract class AbstractHttpHeaderMiddleware implements MiddlewareInterface
{
    /**
     * @var string
     */
    private $headerName;

    /**
     * AbstractHeaderMiddleware constructor.
     *
     * @param string $headerName
     */
    public function __construct(string $headerName)
    {
        $this->headerName = $headerName;
    }


    /**
     * Returns the header name.
     *
     * @return string
     */
    public function getHeaderName():string
    {
        return $this->headerName;
    }


    /**
     * Returns the header value of null is no value is set.
     *
     * @return null|string
     */
    abstract public function getHeaderValue():?string;


    /**
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
    {
        // processes the request
        $response = $handler->handle($request);

        // adds the headers value(s)
        if (($value = $this->getHeaderValue()) !== null) {
            $response = $response->withHeader($this->headerName, $value);
        }

        return $response;
    }
}