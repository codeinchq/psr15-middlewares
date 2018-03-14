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
 * Class XFrameOptionsMiddleware
 *
 * @link https://developer.mozilla.org/fr/docs/HTTP/Headers/X-Frame-Options
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class XFrameOptionsMiddleware extends HeaderMiddleware
{
	public const VALUE_DENY = 'DENY';
	public const VALUE_SAMEORIGIN = 'SAMEORIGIN';

    /**
     * XFrameOptionsMiddleware constructor.
     *
     * @param string $frameOptions
     * @param bool $replace
     */
	public function __construct(string $frameOptions, bool $replace = true)
    {
        parent::__construct(
            'X-Frame-Options',
            $frameOptions,
            $replace
        );
    }
}