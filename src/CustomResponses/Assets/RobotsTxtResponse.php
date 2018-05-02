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
// Time:     17:48
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\CustomResponses\Assets;
use Arcanedev\Robots\Robots;
use CodeInc\Psr15Middlewares\CustomResponses\RobotsTxtMiddleware;
use CodeInc\Psr7Responses\TextResponse;


/**
 * Class RobotsTxtResponse
 *
 * @uses Robots
 * @see RobotsTxtMiddleware
 * @package CodeInc\Psr15Middlewares\CustomResponses\Assets
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class RobotsTxtResponse extends TextResponse
{
    /**
     * RobotsTxtResponse constructor.
     *
     * @param Robots $robots
     * @param null|string $charset
     * @param int $status
     * @param array $headers
     * @param string $version
     * @param null|string $reason
     */
    public function __construct(Robots $robots, ?string $charset = null, int $status = 200,
        array $headers = [], string $version = '1.1', ?string $reason = null)
    {
        parent::__construct($robots->generate(), $charset, $status, $headers, $version, $reason);
    }
}