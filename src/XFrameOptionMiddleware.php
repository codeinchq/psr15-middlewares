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
// Date:     07/03/2018
// Time:     01:47
// Project:  lib-psr15middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class XFrameOptionMiddleware
 *
 * @link https://developer.mozilla.org/fr/docs/HTTP/Headers/X-Frame-Options
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class XFrameOptionMiddleware extends AbstractRecursiveMiddleware {
	public const VALUE_DENY = 'DENY';
	public const VALUE_SAMEORIGIN = 'SAMEORIGIN';

	/**
	 * @var string
	 */
	private $value;

	/**
	 * XFrameOptionMiddleware constructor.
	 *
	 * @param string $value
	 * @param null|MiddlewareInterface $nextMiddleware
	 */
	public function __construct(string $value = self::VALUE_DENY, ?MiddlewareInterface $nextMiddleware = null)
	{
		$this->value = $value;
		parent::__construct($nextMiddleware);
	}

	/**
	 * @param ServerRequestInterface $request
	 * @param RequestHandlerInterface $handler
	 * @return ResponseInterface
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
	{
		$response = parent::process($request, $handler);
		return $response->withHeader("X-Frame-Options", $this->value);
	}
}