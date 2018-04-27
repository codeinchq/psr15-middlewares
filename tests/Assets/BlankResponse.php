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
// Time:     11:06
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests\Assets;
use CodeInc\Psr7Responses\HtmlResponse;


/**
 * Class BlankResponse
 *
 * @package CodeInc\Psr15Middlewares\Tests\Assets
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class BlankResponse extends HtmlResponse
{
    /**
     * BlankResponse constructor.
     */
    public function __construct()
    {
        parent::__construct('<i>This is a blank PSR-7 response</i>');
    }
}