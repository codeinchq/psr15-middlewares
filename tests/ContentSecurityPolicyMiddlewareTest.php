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
// Time:     14:03
// Project:  Psr15Middlewares
//
declare(strict_types=1);
namespace CodeInc\Psr15Middlewares\Tests;
use CodeInc\Psr15Middlewares\ContentSecurityPolicyMiddleware;
use PHPUnit\Framework\TestCase;


/**
 * Class ContentSecurityPolicyMiddlewareTest
 *
 * @package CodeInc\Psr15Middlewares\Tests
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class ContentSecurityPolicyMiddlewareTest extends TestCase
{
    private const URI_1 = 'https://example.com';
    private const URI_2 = 'https://example.org';

    private const MEDIA_TYPE_1 = 'application/x-shockwave-flash';
    private const MEDIA_TYPE_2 = 'application/x-java-applet';


    public function testEmptyCSP():void
    {
        $csp = new ContentSecurityPolicyMiddleware();
        self::assertNull($csp->getHeaderValue());
    }


    public function testUpgradeInsecureRequests():void
    {
        $csp = new ContentSecurityPolicyMiddleware();
        $csp->upgradeInsecureRequests();
        self::assertEquals($csp->getHeaderValue(), 'upgrade-insecure-requests;');
    }


    public function testBlockAllMixedContent():void
    {
        $csp = new ContentSecurityPolicyMiddleware();
        $csp->blockAllMixedContent();
        self::assertEquals($csp->getHeaderValue(), 'block-all-mixed-content;');
    }


    /**
     * @throws \CodeInc\Psr15Middlewares\MiddlewareException
     */
    public function testSandbox():void
    {
        $csp = new ContentSecurityPolicyMiddleware();
        foreach ($csp::SANDBOX_VALUES as $value) {
            $csp->setSandbox($value);;
            self::assertEquals($csp->getHeaderValue(), 'sandbox '.$value.';');
        }
    }


    /**
     * @throws \CodeInc\Psr15Middlewares\MiddlewareException
     */
    public function testRefererPolicy():void
    {
        $csp = new ContentSecurityPolicyMiddleware();
        foreach ($csp::REFERER_POLICY_VALUES as $value) {
            $csp->setRefererPolicy($value);;
            self::assertEquals($csp->getHeaderValue(), 'referer '.$value.';');
        }
    }


    public function testRequireSriFor():void
    {
        $csp = new ContentSecurityPolicyMiddleware();
        $csp->requireSriFor(true, true);
        self::assertEquals($csp->getHeaderValue(), 'require-sri-for script style;');

        $csp = new ContentSecurityPolicyMiddleware();
        $csp->requireSriFor(false, true);
        self::assertEquals($csp->getHeaderValue(), 'require-sri-for style;');

        $csp = new ContentSecurityPolicyMiddleware();
        $csp->requireSriFor(true, false);
        self::assertEquals($csp->getHeaderValue(), 'require-sri-for script;');
    }


    /**
     * @throws \CodeInc\Psr15Middlewares\MiddlewareException
     */
    public function testPluginType():void
    {
        $csp = new ContentSecurityPolicyMiddleware();
        self::assertTrue($csp->addPluginType(self::MEDIA_TYPE_1));
        self::assertEquals($csp->getHeaderValue(), 'plugin-types '.self::MEDIA_TYPE_1.';');

        $csp = new ContentSecurityPolicyMiddleware();
        self::assertTrue($csp->addPluginType(self::MEDIA_TYPE_1));
        self::assertTrue($csp->addPluginType(self::MEDIA_TYPE_2));
        self::assertEquals($csp->getHeaderValue(), 'plugin-types '.self::MEDIA_TYPE_1.' '.self::MEDIA_TYPE_2.';');

        // duplicate
        $csp = new ContentSecurityPolicyMiddleware();
        self::assertTrue($csp->addPluginType(self::MEDIA_TYPE_1));
        self::assertFalse($csp->addPluginType(self::MEDIA_TYPE_1));
        self::assertEquals($csp->getHeaderValue(), 'plugin-types '.self::MEDIA_TYPE_1.';');
    }


    /**
     * @throws \ReflectionException
     */
    public function testSrc():void
    {
        $sources = [
            'default-src' => 'addDefaultSrc',
            'base-uri' => 'addBaseUri',
            'child-src' => 'addChildSrc',
            'font-src' => 'addFontSrc',
            'form-action' => 'addFormAction',
            'frame-ancestors' => 'addFrameAncestors',
            'frame-src' => 'addFrameSrc',
            'img-src' => 'addImgSrc',
            'manifest-src' => 'addManifestSrc',
            'media-src' => 'addMediaSrc',
            'object-src' => 'addObjectSrc',
            'script-src' => 'addScriptSrc',
            'style-src' => 'addStyleSrc',
            'worker-src' => 'addWorkerSrc',
            'report-uri' => 'addReportUri',
        ];
        $reflexionClass = new \ReflectionClass(ContentSecurityPolicyMiddleware::class);
        foreach ($sources as $tag => $method) {
            // on entry
            $csp = new ContentSecurityPolicyMiddleware();
            self::assertTrue($reflexionClass->getMethod($method)->invoke($csp, self::URI_1));
            self::assertEquals($csp->getHeaderValue(), $tag.' '.self::URI_1.';');

            // two entries
            $csp = new ContentSecurityPolicyMiddleware();
            self::assertTrue($reflexionClass->getMethod($method)->invoke($csp, self::URI_1));
            self::assertTrue($reflexionClass->getMethod($method)->invoke($csp, self::URI_2));
            self::assertEquals($csp->getHeaderValue(), $tag.' '.self::URI_1.' '.self::URI_2.';');

            // duplicate
            $csp = new ContentSecurityPolicyMiddleware();
            self::assertTrue($reflexionClass->getMethod($method)->invoke($csp, self::URI_1));
            self::assertFalse($reflexionClass->getMethod($method)->invoke($csp, self::URI_1));
            self::assertEquals($csp->getHeaderValue(), $tag.' '.self::URI_1.';');
        }
    }
}