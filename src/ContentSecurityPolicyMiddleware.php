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
// Time:     02:05
// Project:  lib-psr15middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class ContentSecurityPolicyMiddleware
 *
 * @link https://developer.mozilla.org/fr/docs/HTTP/Headers/Content-Security-Policy
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class ContentSecurityPolicyMiddleware implements MiddlewareInterface
{
	public const SRC_SELF  = "'self'";

	/**
	 * @var array
	 */
	private $sources;

	/**
	 * ContentSecurityPolicyMiddleware constructor.
	 *
	 * @param array $sources
	 */
	public function __construct(array $sources)
	{
		$this->sources = $sources;
	}

	/**
	 * @inheritdoc
	 */
	public function process(ServerRequestInterface $request,
        RequestHandlerInterface $handler):ResponseInterface
	{
	    return $handler->handle($request)
            ->withHeader('Content-Security-Policy', $this->getHeaderValue());
	}

	/**
	 * Returns the Content-Security-Policy header value
	 *
	 * @return string
	 */
	public function getHeaderValue():string
	{
		$sources = [];
		foreach ($this->sources as $source) {
			$sources[] = implode(": ", $source);
		}
		return implode("; ", $sources);
	}
}