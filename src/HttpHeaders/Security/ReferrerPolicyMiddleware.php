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
namespace CodeInc\Psr15Middlewares\HttpHeaders\Security;
use CodeInc\Psr15Middlewares\HttpHeaders\AbstractHttpHeaderMiddleware;
use CodeInc\Psr15Middlewares\Tests\HttpHeaders\Security\ReferrerPolicyMiddlewareTest;


/**
 * Class ReferrerPolicyMiddleware
 *
 * @see ReferrerPolicyMiddlewareTest
 * @package CodeInc\Psr15Middlewares\HttpHeaders\Security
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/Psr15Middlewares/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/Psr15Middlewares
 * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Referrer-Policy
 */
class ReferrerPolicyMiddleware extends AbstractHttpHeaderMiddleware
{
    // possible values
    public const VALUE_NO_REFERRER = 'no-referrer';
    public const VALUE_NO_REFERRER_WHEN_DOWNGRADE = 'no-referrer-when-downgrade';
    public const VALUE_ORIGIN = 'origin';
    public const VALUE_ORIGIN_WHEN_CROSS_ORIGIN = 'origin-when-cross-origin';
    public const VALUE_SAME_ORIGIN = 'same-origin';
    public const VALUE_STRICT_ORIGIN = 'strict-origin';
    public const VALUE_STRICT_ORIGIN_WHEN_CROSS_ORIGIN = 'strict-origin-when-cross-origin';
    public const VALUE_UNSAFE_URL = 'unsafe-url';
    public const ALL_VALUES = [
        self::VALUE_NO_REFERRER, self::VALUE_NO_REFERRER_WHEN_DOWNGRADE, self::VALUE_ORIGIN,
        self::VALUE_ORIGIN_WHEN_CROSS_ORIGIN, self::VALUE_SAME_ORIGIN, self::VALUE_STRICT_ORIGIN,
        self::VALUE_STRICT_ORIGIN_WHEN_CROSS_ORIGIN, self::VALUE_UNSAFE_URL,
    ];

    /**
     * @var string
     */
    private $referrerPolicy;


    /**
     * ReferrerPolicyMiddleware constructor.
     *
     * @param string $referrerPolicy
     */
    public function __construct(string $referrerPolicy)
    {
        parent::__construct('Referrer-Policy');
        $this->referrerPolicy = $referrerPolicy;
    }


    /**
     * Sets the referer police. See the VALUE_XYZ class constants for possible values.
     *
     * @param null|string $referrerPolicy
     */
    public function setReferrerPolicy(?string $referrerPolicy):void
    {
        $this->referrerPolicy = $referrerPolicy;
    }


    /**
     * Returns the referer policy.
     *
     * @return string
     */
    public function getReferrerPolicy():string
    {
        return $this->referrerPolicy;
    }


    /**
     * Sets the policy value to 'no-referrer'.
     *
     * @return self
     */
    public static function noReferer():self
    {
        return new self(self::VALUE_NO_REFERRER);
    }


    /**
     * Sets the policy value to 'no-referrer-when-downgrade'
     *
     * @return self
     */
    public static function noRefererWhenDowngrade():self
    {
        return new self(self::VALUE_NO_REFERRER_WHEN_DOWNGRADE);
    }


    /**
     * Sets the policy value to 'origin'.
     *
     * @return self
     */
    public static function origin():self
    {
        return new self(self::VALUE_ORIGIN);
    }


    /**
     * Sets the policy value to 'origin-when-cross-origin'.
     *
     * @return self
     */
    public static function originWhenCrossOrigin():self
    {
        return new self(self::VALUE_ORIGIN_WHEN_CROSS_ORIGIN);
    }


    /**
     * Sets the policy value to 'same-origin'.
     *
     * @return self
     */
    public static function sameOrigin():self
    {
        return new self(self::VALUE_SAME_ORIGIN);
    }


    /**
     * Sets the policy value to 'strict-origin'.
     *
     * @return self
     */
    public static function strictOrigin():self
    {
        return new self(self::VALUE_STRICT_ORIGIN);
    }


    /**
     * Sets the policy value to 'strict-origin-when-cross-origin'.
     *
     * @return self
     */
    public static function strictOriginWhenCrossOrigin():self
    {
        return new self(self::VALUE_STRICT_ORIGIN_WHEN_CROSS_ORIGIN);
    }


    /**
     * Sets the policy value to 'unsafe-url'.
     *
     * @return self
     */
    public static function unsafeUrl():self
    {
        return new self(self::VALUE_UNSAFE_URL);
    }


    /**
     * @inheritdoc
     * @return string
     */
    public function getHeaderValue():string
    {
        return $this->referrerPolicy;
    }
}