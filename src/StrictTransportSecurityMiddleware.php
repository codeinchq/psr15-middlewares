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
// Project:  Psr15Middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares;


/**
 * Class StrictTransportSecurityMiddleware
 *
 * @link https://fr.wikipedia.org/wiki/HTTP_Strict_Transport_Security
 * @link https://developer.mozilla.org/fr/docs/S%C3%A9curit%C3%A9/HTTP_Strict_Transport_Security
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class StrictTransportSecurityMiddleware extends HeaderMiddleware
{
	const OPT_INCLUDE_SUBDOMAINS = 2;
	const OPT_PRELOAD = 4;
	const OPT_ALL = self::OPT_INCLUDE_SUBDOMAINS|self::OPT_PRELOAD;

    /**
     * StrictTransportSecurityMiddleware constructor.
     *
     * @param int $expireTime
     * @param int|null $options
     * @param bool $replace
     */
	public function __construct(int $expireTime, ?int $options = null,
        bool $replace = true)
	{
	    // preparing the value
        $value = 'max-age='.$expireTime;
        if ($options & self::OPT_INCLUDE_SUBDOMAINS) {
            $value .= '; includeSubDomains';
        }
        if ($options & self::OPT_PRELOAD) {
            $value .= '; preload';
        }

        parent::__construct(
            'Strict-Transport-Security',
            $value,
            $replace
        );
	}
}