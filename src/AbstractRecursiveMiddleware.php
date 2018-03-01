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
// Time:     18:50
// Project:  lib-psr15middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class AbstractMiddleware
 *
 * @package CodeInc\Psr7ResponseSender\Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
abstract class AbstractRecursiveMiddleware implements MiddlewareInterface {
	/**
	 * @var null|MiddlewareInterface
	 */
	private $nextMiddleware;

	/**
	 * HttpVersionCheckMiddleware constructor.
	 *
	 * @param null|MiddlewareInterface $nextMiddleware
	 */
	public function __construct(?MiddlewareInterface $nextMiddleware = null)
	{
		$this->nextMiddleware = $nextMiddleware;
	}

	/**
	 * @return null|MiddlewareInterface
	 */
	public function getNextMiddleware():?MiddlewareInterface
	{
		return $this->nextMiddleware;
	}

	/**
	 * @inheritdoc
	 * @return ResponseInterface
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
	{
		if ($nextMiddleware = $this->getNextMiddleware()) {
			return $nextMiddleware->process($request, $handler);
		}
		else {
			return $handler->handle($request);
		}
	}
}