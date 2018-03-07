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
// Time:     01:58
// Project:  lib-psr15middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class HSTSMiddleware
 *
 * @link https://developer.mozilla.org/fr/docs/S%C3%A9curit%C3%A9/HTTP_Strict_Transport_Security
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class HSTSMiddleware extends AbstractRecursiveMiddleware {
	const OPT_INCLUDE_SUBDOMAINS = 2;
	const OPT_PRELOAD = 4;
	const OPT_ALL = self::OPT_INCLUDE_SUBDOMAINS|self::OPT_PRELOAD;

	/**
	 * @var int
	 */
	private $expireTime;

	/**
	 * @var int
	 */
	private $options;

	/**
	 * HSTSMiddleware constructor.
	 *
	 * @param int $expireTime
	 * @param int|null $options
	 * @param null|MiddlewareInterface $nextMiddleware
	 */
	public function __construct(int $expireTime, ?int $options = null, ?MiddlewareInterface $nextMiddleware = null)
	{
		$this->expireTime = $expireTime;
		$this->options = $options ?? 0;
		parent::__construct($nextMiddleware);
	}

	/**
	 * @inheritdoc
	 */
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
	{
		return parent::process($request, $handler)
			->withHeader('Strict-Transport-Security', $this->getHSTSValue());
	}

	/**
	 * Returns the HSTS header value.
	 *
	 * @return string
	 */
	public function getHSTSValue():string
	{
		$value = 'max-age='.$this->expireTime;
		if ($this->options & self::OPT_INCLUDE_SUBDOMAINS) {
			$value .= '; includeSubDomains';
		}
		if ($this->options & self::OPT_PRELOAD) {
			$value .= '; preload';
		}
		return $value;
	}
}