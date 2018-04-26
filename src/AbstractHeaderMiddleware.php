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
// Date:     26/04/2018
// Time:     12:58
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class AbstractHeaderMiddleware
 *
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
abstract class AbstractHeaderMiddleware implements MiddlewareInterface
{
    /**
     * @var string
     */
    private $headerName;

    /**
     * AbstractHeaderMiddleware constructor.
     *
     * @param string $headerName
     * @param bool|null $replace
     */
    public function __construct(string $headerName, ?bool $replace = null)
    {
        $this->headerName = $headerName;
    }

    /**
     * Retuns the header value(s) in an array or NULL if no value is set.
     *
     * @return array|null
     */
    abstract protected function getHeaderValues():?array;

    /**
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
    {
        // processes the request
        $response = $handler->handle($request);

        // adds the headers value(s)
        if ($values = $this->getHeaderValues()) {
            foreach ($values as $value) {
                $response = $response->withHeader($this->headerName, $value);
            }
        }

        return $response;
    }
}
