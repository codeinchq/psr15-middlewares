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
// Date:     02/05/2018
// Time:     18:11
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\CustomResponses\Assets;
use CodeInc\Psr15Middlewares\CustomResponses\SiteMapMiddleware;
use CodeInc\Psr7Responses\XmlResponse;
use Tackk\Cartographer\Sitemap;


/**
 * Class SiteMapResponbse
 *
 * @uses Sitemap
 * @see SiteMapMiddleware
 * @package CodeInc\Psr15Middlewares\CustomResponses\Assets
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class SiteMapResponse extends XmlResponse
{
    /**
     * SiteMapResponse constructor.
     *
     * @param Sitemap $sitemap
     * @param null|string $charset
     * @param int $status
     * @param array $headers
     * @param string $version
     * @param null|string $reason
     */
    public function __construct(Sitemap $sitemap, ?string $charset = null, int $status = 200,
        array $headers = [], string $version = '1.1', ?string $reason = null)
    {
        parent::__construct($sitemap->__toString(), $charset, $status, $headers, $version, $reason);
    }
}