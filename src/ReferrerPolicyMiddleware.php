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
// Date:     14/03/2018
// Time:     11:22
// Project:  Psr15Middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares;


/**
 * Class ReferrerPolicyMiddleware
 *
 * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Referrer-Policy
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class ReferrerPolicyMiddleware extends HttpHeaderMiddleware
{
    const VALUE_NO_REFERRER = 'no-referrer'; 
    const VALUE_NO_REFERRER_WHEN_DOWNGRADE = 'no-referrer-when-downgrade'; 
    const VALUE_ORIGIN = 'origin'; 
    const VALUE_ORIGIN_WHEN_CROSS_ORIGIN = 'origin-when-cross-origin'; 
    const VALUE_SAME_ORIGIN = 'same-origin'; 
    const VALUE_STRICT_ORIGIN = 'strict-origin'; 
    const VALUE_STRICT_ORIGIN_WHEN_CROSS_ORIGIN = 'strict-origin-when-cross-origin'; 
    const VALUE_UNSAFE_URL = 'unsafe-url'; 
    
    /**
     * ReferrerPolicyMiddleware constructor.
     *
     * @param string $referrerPolicy
     */
    public function __construct(string $referrerPolicy)
    {
        parent::__construct('Referrer-Policy', $referrerPolicy);
    }
}