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
// Date:     04/03/2018
// Time:     08:38
// Project:  Psr15Middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares\HttpHeaders;
use GuzzleHttp\Psr7\Response;
use Micheh\Cache\CacheUtil;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class CacheMiddleware
 *
 * @uses CacheUtil
 * @package CodeInc\Psr15Middlewares\HttpHeaders
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class CacheMiddleware implements MiddlewareInterface
{
	/**
	 * @var \DateTime|null
	 */
	private $lastModified;

	/**
	 * @var string|null
	 */
	private $etag;

	/**
	 * @param \DateTime|null $lastModified
	 */
	public function setLastModified(?\DateTime $lastModified):void
	{
		$this->lastModified = $lastModified;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getLastModified():?\DateTime
	{
		return $this->lastModified;
	}

	/**
	 * @param null|string $etag
	 */
	public function setEtag(?string $etag):void
	{
		$this->etag = $etag;
	}

	/**
	 * @return null|string
	 */
	public function getEtag():?string
	{
		return $this->etag;
	}

	/**
	 * @inheritdoc
	 * @param ServerRequestInterface $request
	 * @param RequestHandlerInterface $handler
	 * @return ResponseInterface
	 */
	public function process(ServerRequestInterface $request,
        RequestHandlerInterface $handler):ResponseInterface
	{
	    // processing
		$response = $handler->handle($request);

		// adding cache headers
		$cacheUtils = new CacheUtil();
		$response = $cacheUtils->withCache($response);

		// adding eTag
		if ($this->etag) {
			$response = $cacheUtils->withETag($response, $this->etag);
		}

		// adding last modified
		if ($this->lastModified) {
			$response = $cacheUtils->withLastModified($response, $this->lastModified);
			if ($cacheUtils->isNotModified($request, $response)) {
				return new Response(304);
			}
		}

		return $response;
	}
}