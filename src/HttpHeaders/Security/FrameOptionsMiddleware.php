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
// Project:  Psr15Middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares\HttpHeaders\Security;
use CodeInc\Psr15Middlewares\HttpHeaders\AbstractHttpHeaderMiddleware;
use CodeInc\Psr15Middlewares\MiddlewareException;
use CodeInc\Psr15Middlewares\Tests\HttpHeaders\Security\FrameOptionsMiddlewareTest;


/**
 * Class FrameOptionsMiddleware
 *
 * @see FrameOptionsMiddlewareTest
 * @package CodeInc\Psr15Middlewares\HttpHeaders\Security
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/Psr15Middlewares/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/Psr15Middlewares
 * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/X-Frame-Options
 */
class FrameOptionsMiddleware extends AbstractHttpHeaderMiddleware
{
    public const VALUE_DENY = 'DENY';
    public const VALUE_SAMEORIGIN = 'SAMEORIGIN';
    public const VALUE_ALLOW_FROM= 'ALLOW-FROM %s';

    /**
     * @var string
     */
	private $value;


    /**
     * FrameOptionsMiddleware constructor.
     *
     * @param string $value
     */
	public function __construct(string $value)
    {
        parent::__construct('X-Frame-Options');
        $this->value = $value;
    }


    /**
     * @return string
     */
    public function getValue():string
    {
        return $this->value;
    }


    /**
     * @param string $value
     */
    public function setValue(string $value):void
    {
        $this->value = $value;
    }


    /**
     * Deny frames.
     *
     * @return self
     */
    public static function denyFrames():self
    {
        return new self(self::VALUE_DENY);
    }


    /**
     * Allow frames from the same origin.
     *
     * @return self
     */
    public static function allowFromSameOrigin():self
    {
        return new self(self::VALUE_SAMEORIGIN);
    }


    /**
     * Allow frame from a given URL.
     *
     * @param string $allowFromUrl
     * @return self
     * @throws MiddlewareException
     */
    public static function allowFrom(string $allowFromUrl):self
    {
        $middleware = new self(sprintf(self::VALUE_ALLOW_FROM, $allowFromUrl));

        if (!filter_var($allowFromUrl, FILTER_VALIDATE_URL)) {
            throw new MiddlewareException(
                $middleware,
                sprintf("'%s' is not a valid URL", $allowFromUrl)
            );
        }

        return $middleware;
    }


    /**
     * @inheritdoc
     * @return string
     */
    public function getHeaderValue():string
    {
        return $this->value;
    }
}