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
// Date:     27/04/2018
// Time:     16:48
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\HttpHeaders\Security;
use CodeInc\Psr15Middlewares\HttpHeaders\AbstractSingleValueHttpHeaderMiddleware;
use CodeInc\Psr15Middlewares\Tests\HttpHeaders\Security\ExpectCtMiddlewareTest;


/**
 * Class ExpectCtMiddleware
 *
 * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Expect-CT
 * @see ExpectCtMiddlewareTest
 * @package CodeInc\Psr15Middlewares\HttpHeaders\Security
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class ExpectCtMiddleware extends AbstractSingleValueHttpHeaderMiddleware
{
    /**
     * @var null|string
     */
    private $reportUri;

    /**
     * @var bool
     */
    private $enforce;

    /**
     * @var int|null
     */
    private $maxAge;


    /**
     * ExpectCtMiddleware constructor.
     *
     * @param int|null $maxAge
     * @param bool|null $enforce
     * @param null|string $reportUri
     */
    public function __construct(?int $maxAge = null, ?bool $enforce = null, ?string $reportUri = null)
    {
        parent::__construct('Expect-CT');
        $this->maxAge = $maxAge;
        $this->enforce = $enforce ?? false;
        $this->reportUri = $reportUri;
    }


    /**
     * @param int|null $maxAge
     */
    public function setMaxAge(?int $maxAge):void
    {
        $this->maxAge = $maxAge;
    }


    /**
     * @return int|null
     */
    public function getMaxAge():?int
    {
        return $this->maxAge;
    }


    /**
     * @param bool $enforce
     */
    public function setEnforce(bool $enforce):void
    {
        $this->enforce = $enforce;
    }


    /**
     * @return bool
     */
    public function getEnforce():bool
    {
        return $this->enforce;
    }


    /**
     * @param null|string $reportUri
     */
    public function setReportUri(?string $reportUri):void
    {
        $this->reportUri = $reportUri;
    }


    /**
     * @return null|string
     */
    public function getReportUri():?string
    {
        return $this->reportUri;
    }


    /**
     * @inheritdoc
     * @return null|string
     */
    public function getHeaderValue():?string
    {
        $value = '';
        if ($this->reportUri) {
            $value .= 'report-uri="'.$this->reportUri.'"';
        }
        if ($this->enforce) {
            $value .= (!empty($value) ? ', ' : '').'enforce';
        }
        if ($this->maxAge) {
            $value .= (!empty($value) ? ', ' : '').'max-age='.$this->maxAge;
        }
        return !empty($value) ? $value : null;
    }
}