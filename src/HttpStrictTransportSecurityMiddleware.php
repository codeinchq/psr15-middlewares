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
 * Class HttpStrictTransportSecurityMiddleware
 *
 * @link https://fr.wikipedia.org/wiki/HTTP_Strict_Transport_Security
 * @link https://developer.mozilla.org/fr/docs/S%C3%A9curit%C3%A9/HTTP_Strict_Transport_Security
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class HttpStrictTransportSecurityMiddleware implements MiddlewareInterface
{
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
	 */
	public function __construct(int $expireTime, ?int $options = null)
	{
		$this->expireTime = $expireTime;
		$this->options = $options ?? 0;
	}

	/**
	 * @inheritdoc
	 */
	public function process(ServerRequestInterface $request,
        RequestHandlerInterface $handler):ResponseInterface
	{
		return $handler->handle($request)
			->withHeader('Strict-Transport-Security', $this->getHstsValue());
	}

	/**
	 * Returns the HSTS header value.
	 *
	 * @return string
	 */
	public function getHstsValue():string
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