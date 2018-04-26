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
    private $blockMode;

    /**
     * XXssProtectionMiddleware constructor.
     *
     * @param bool $enableProtection
     * @param bool|null $blockMode
     */
    public function __construct(bool $enableProtection, ?bool $blockMode = null)
    {
        $this->enableProtection = $enableProtection;
        $this->blockMode = $blockMode ?? false;
        parent::__construct('X-Xss-Protection');
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
        return [$value];
    }
}