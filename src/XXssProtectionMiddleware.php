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
// Date:     26/04/2018
// Time:     17:23
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares;

/**
 * Class XXssProtectionMiddleware
 *
 * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/X-XSS-Protection
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class XXssProtectionMiddleware extends AbstractHeaderMiddleware
{
    /**
     * @var bool
     */
    private $enableProtection;

    /**
     * @var bool
     */
    private $blockMode = false;

    /**
     * @var string|null
     */
    private $reportUri;

    /**
     * XXssProtectionMiddleware constructor.
     *
     * @param bool $enableProtection
     */
    public function __construct(bool $enableProtection)
    {
        $this->enableProtection = $enableProtection;
        parent::__construct('X-Xss-Protection');
    }

    /**
     * Enables the report mode.
     *
     * @throws MiddlewareException
     */
    public function enableBlockMode():void
    {
        if ($this->reportUri) {
            throw new MiddlewareException(
                $this,
                sprintf(
                    "You can't enable the block mode because the report mode is already enabled (see %s)",
                    'https://developer.mozilla.org/docs/Web/HTTP/Headers/X-XSS-Protection'
                )
            );
        }
        $this->blockMode = true;
    }

    /**
     * Enables the report mode and sets the report URI.
     *
     * @param string $reportUri
     * @throws MiddlewareException
     */
    public function setReportUri(string $reportUri):void
    {
        if ($this->blockMode) {
            throw new MiddlewareException(
                $this,
                sprintf(
                    "You can't enable the report mode because the block mode is already enabled (see %s)",
                    'https://developer.mozilla.org/docs/Web/HTTP/Headers/X-XSS-Protection'
                )
            );
        }
        $this->reportUri = $reportUri;
    }

    /**
     * @inheritdoc
     * @return array|null
     */
    protected function getHeaderValues():?array
    {
        $value = $this->enableProtection ? '1' : '0';
        if ($this->blockMode) {
            $value .= '; mode=block';
        }
        if ($this->reportUri) {
            $value .= '; report='.$this->reportUri;
        }
        return [$value];
    }
}