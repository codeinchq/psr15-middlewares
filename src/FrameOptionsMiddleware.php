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
namespace CodeInc\Psr15Middlewares;


/**
 * Class FrameOptionsMiddleware
 *
 * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/X-Frame-Options
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class FrameOptionsMiddleware extends AbstractHeaderMiddleware
{
    /**
     * @var string|null
     */
	private $value;

    /**
     * XFrameOptionsMiddleware constructor.
     */
	public function __construct()
    {
        parent::__construct('X-Frame-Options');
    }

    /**
     * Deny frames.
     */
    public function denyFrames():void
    {
        $this->value = 'DENY';
    }

    /**
     * Allow frames from the same origin.
     */
    public function allowFromSameOrigin():void
    {
        $this->value = 'SAMEORIGIN';
    }

    /**
     * Allow frame from a given URL.
     *
     * @param string $url
     */
    public function allowFrom(string $url):void
    {
        $this->value = 'ALLOW-FROM '.$url;
    }

    /**
     * @inheritdoc
     * @return null|string
     */
    public function getHeaderValues():?array
    {
        return $this->value ? [$this->value] : null;
    }
}