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
// Time:     01:56
// Project:  Psr15Middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares\HttpHeaders;
use CodeInc\Psr15Middlewares\Tests\HttpHeaders\PoweredByMiddlewareTest;


/**
 * Class PoweredByMiddleware
 *
 * @see PoweredByMiddlewareTest
 * @package CodeInc\Psr15Middlewares\HttpHeaders
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class PoweredByMiddleware extends AbstractHttpHeaderMiddleware
{
    /**
     * @var string|null
     */
    private $poweredBy;


    /**
     * PoweredByMiddleware constructor.
     *
     * @param null|string $poweredBy
     */
	public function __construct(?string $poweredBy = null)
    {
        $this->poweredBy = $poweredBy;
        parent::__construct('X-Powered-By');
    }


    /**
     * @param null|string $poweredBy
     */
    public function setPoweredBy(?string $poweredBy):void
    {
        $this->poweredBy = $poweredBy;
    }


    /**
     * @return null|string
     */
    public function getPoweredBy():?string
    {
        return $this->poweredBy;
    }


    /**
     * @inheritdoc
     * @return null|string
     */
    public function getHeaderValue():?string
    {
        return $this->poweredBy;
    }
}