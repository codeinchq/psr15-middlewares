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
// Date:     23/02/2018
// Time:     18:59
// Project:  Psr15Middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares\HttpHeaders;
use CodeInc\Psr15Middlewares\Tests\HttpHeaders\AddHttpHeadersMiddlewareTest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class AddHttpHeadersMiddleware
 *
 * @see AddHttpHeadersMiddlewareTest
 * @package CodeInc\Psr15Middlewares\HttpHeaders
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class AddHttpHeadersMiddleware implements MiddlewareInterface
{
	/**
	 * @var string[]
	 */
	private $headers = [];

    /**
     * @param string $header
     * @param string|array|iterable $value
     * @param bool $replace
     */
	public function addHeader(string $header, $value, bool $replace = true):void
	{
	    if (is_iterable($value) || is_array($value)) {
	        $iterable = $value;
	        $value = [];
	        foreach ($iterable as $key => $entry) {
                $value[$key] = (string)$entry;
            }
        }
        else {
	        $value = (string)$value;
        }

		$this->headers[] = [$header, $value, $replace];
	}

	/**
	 * @inheritdoc
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
	{
		$response = $handler->handle($request);

		// adding HTTP headers
		foreach ($this->headers as [$header, $value, $replace]) {
		    if ($replace || !$response->hasHeader($header)) {
                $response = $response->withHeader($header, $value);
            }
		}

		return $response;
	}
}