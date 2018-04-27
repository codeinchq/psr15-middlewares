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
class ReferrerPolicyMiddleware extends AbstractHeaderMiddleware
{
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
     * @var null|string
     */
    private $referrerPolicy;


    /**
     * ReferrerPolicyMiddleware constructor.
     *
     * @param null|string $referrerPolicy
     */
    public function __construct(?string $referrerPolicy = null)
    {
        $this->referrerPolicy = $referrerPolicy;
        parent::__construct('Referrer-Policy');
    }


    /**
     * Sets the policy value to 'no-referrer'.
     */
    public function setNoReferer():void
    {
        $this->referrerPolicy = self::VALUE_NO_REFERRER;
    }


    /**
     * Sets the policy value to 'no-referrer-when-downgrade'
     */
    public function setNoRefererWhenDowngrade():void
    {
        $this->referrerPolicy = self::VALUE_NO_REFERRER_WHEN_DOWNGRADE;
    }


    /**
     * Sets the policy value to 'origin'.
     */
    public function setOrigin():void
    {
        $this->referrerPolicy = self::VALUE_ORIGIN;
    }


    /**
     * Sets the policy value to 'origin-when-cross-origin'.
     */
    public function setOriginWhenCrossOrigin():void
    {
        $this->referrerPolicy = self::VALUE_ORIGIN_WHEN_CROSS_ORIGIN;
    }


    /**
     * Sets the policy value to 'same-origin'.
     */
    public function setSameOrigin():void
    {
        $this->referrerPolicy = self::VALUE_SAME_ORIGIN;
    }


    /**
     * Sets the policy value to 'strict-origin'.
     */
    public function setStrictOrigin():void
    {
        $this->referrerPolicy = self::VALUE_STRICT_ORIGIN;
    }


    /**
     * Sets the policy value to 'strict-origin-when-cross-origin'.
     */
    public function setStrictOriginWhenCrossOrigin():void
    {
        $this->referrerPolicy = self::VALUE_STRICT_ORIGIN_WHEN_CROSS_ORIGIN;
    }


    /**
     * Sets the policy value to 'unsafe-url'.
     */
    public function setUnsafeUrl():void
    {
        $this->referrerPolicy = self::VALUE_UNSAFE_URL;
    }


    /**
     * Returns the referer policy.
     *
     * @return null|string
     */
    public function getReferrerPolicy():?string
    {
        return $this->referrerPolicy;
    }


    /**
     * @inheritdoc
     * @return array|null
     */
    protected function getHeaderValues():?array
    {
        return $this->referrerPolicy ? [$this->referrerPolicy] : null;
    }
}