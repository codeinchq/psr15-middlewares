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
// Time:     01:56
// Project:  lib-psr15middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class XPoweredByMiddleware
 *
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class XPoweredByMiddleware extends AbstractRecursiveMiddleware {
	/**
	 * @var string
	 */
	private $poweredBy;

	/**
	 * XPoweredByMiddleware constructor.
	 *
	 * @param string $poweredBy
	 * @param null|MiddlewareInterface $nextMiddleware
	 */
	public function __construct(string $poweredBy, ?MiddlewareInterface $nextMiddleware = null)
	{
		$this->poweredBy = $poweredBy;
		parent::__construct($nextMiddleware);
	}

	/**
	 * @inheritdoc
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
	{
		return parent::process($request, $handler)
			->withHeader('X-Powered-By', $this->poweredBy);
	}
}