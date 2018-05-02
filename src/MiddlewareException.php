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
// Time:     09:15
// Project:  Psr15Middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares;
use Psr\Http\Server\MiddlewareInterface;
use Throwable;


/**
 * Class MiddlewareException
 *
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/Psr15Middlewares/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/Psr15Middlewares
 */
class MiddlewareException extends \Exception
{
	/**
	 * @var  MiddlewareInterface
	 */
	private $middleware;

	/**
	 * MiddlewareException constructor.
	 *
	 * @param MiddlewareInterface $middleware
	 * @param string $message
	 * @param int $code
	 * @param Throwable|null $previous
	 */
	public function __construct(MiddlewareInterface $middleware,
        string $message = '', int $code = 0, Throwable $previous = null)
	{
		$this->middleware = $middleware;
		parent::__construct($message, $code, $previous);
	}

	/**
	 * @return MiddlewareInterface
	 */
	public function getMiddleware():MiddlewareInterface
	{
		return $this->middleware;
	}
}