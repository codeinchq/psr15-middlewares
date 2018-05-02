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
// Time:     17:30
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\CustomResponses;
use Arcanedev\Robots\Robots;
use CodeInc\Psr15Middlewares\CustomResponses\Assets\RobotsTxtResponse;
use CodeInc\Psr7Responses\TextResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;


/**
 * Class RobotsTxtMiddleware
 *
 * @uses Robots <https://github.com/ARCANEDEV/Robots>
 * @package CodeInc\Psr15Middlewares\CustomResponses
 * @author Joan Fabrégat <joan@codeinc.fr>
 * @license MIT <https://github.com/CodeIncHQ/Psr15Middlewares/blob/master/LICENSE>
 * @link https://github.com/CodeIncHQ/Psr15Middlewares
 */
class RobotsTxtMiddleware extends Robots implements MiddlewareInterface
{
    /**
     * @var array
     */
    private $robotsTxtUriPaths = ['/robots.txt'];

    /**
     * @param string $path
     * @return bool
     */
    public function addRobotsTxtUriPath(string $path):bool
    {
        if (!in_array($path, $this->robotsTxtUriPaths)) {
            $this->robotsTxtUriPaths[] = $path;
            return true;
        }
        return false;
    }

    /**
     * Returns the lists of URI paths for which the robots.txt file is returned.
     *
     * @return array
     */
    public function getRobotsTxtUriPaths():array
    {
        return $this->robotsTxtUriPaths;
    }

    /**
     * @inheritdoc
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler):ResponseInterface
    {
        if ($this->isRobotsTxtRequest($request)) {
            return new RobotsTxtResponse($this);
        }
        else {
            return $handler->handle($request);
        }
    }

    /**
     * Verifies if the requests points toward the robots.txt file.
     *
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isRobotsTxtRequest(ServerRequestInterface $request):bool
    {
        return in_array($request->getUri()->getPath(), $this->robotsTxtUriPaths);
    }
}