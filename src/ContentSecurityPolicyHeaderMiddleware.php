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
// Time:     02:05
// Project:  Psr15Middlewares
//
declare(strict_types = 1);
namespace CodeInc\Psr15Middlewares;
use CodeInc\Psr15Middlewares\Tests\ContentSecurityPolicyHeaderMiddlewareTest;


/**
 * Class ContentSecurityPolicyHeaderMiddleware
 *
 * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy
 * @see ContentSecurityPolicyHeaderMiddlewareTest
 * @package CodeInc\Psr15Middlewares
 * @author Joan Fabrégat <joan@codeinc.fr>
 */
class ContentSecurityPolicyHeaderMiddleware extends AbstractHeaderMiddleware
{
	public const SRC_SELF  = '\'self\'';
	public const SRC_NONE  = '\'none\'';

	// values for the referer policy
	public const REFERER_POLICY_NONE = 'none';
	public const REFERER_POLICY_NO_REFERRER = 'no-referrer';
	public const REFERER_POLICY_NONE_WHEN_DOWNGRADE = 'none-when-downgrade';
	public const REFERER_POLICY_ORIGIN = 'origin';
	public const REFERER_POLICY_ORIGIN_WHEN_CROSS_ORIGIN = 'origin-when-cross-origin';
	public const REFERER_POLICY_ORIGIN_WHEN_CROSSORIGIN = 'origin-when-crossorigin';
	public const REFERER_POLICY_UNSAFE_URL = 'unsafe-url';
	public const REFERER_POLICY_VALUES = [
        self::REFERER_POLICY_NONE, self::REFERER_POLICY_NO_REFERRER, self::REFERER_POLICY_NONE_WHEN_DOWNGRADE,
        self::REFERER_POLICY_ORIGIN, self::REFERER_POLICY_ORIGIN_WHEN_CROSS_ORIGIN,
        self::REFERER_POLICY_ORIGIN_WHEN_CROSSORIGIN, self::REFERER_POLICY_UNSAFE_URL,
    ];

	// values for the sandbox
    public const SANDBOX_ALLOW_FORMS = 'allow-forms';
    public const SANDBOX_ALLOW_MODALS = 'allow-modals';
    public const SANDBOX_ALLOW_ORIENTATION_LOCK = 'allow-orientation-lock';
    public const SANDBOX_ALLOW_POINTER_LOCK = 'allow-pointer-lock';
    public const SANDBOX_ALLOW_POPUPS = 'allow-popups';
    public const SANDBOX_ALLOW_POPUPS_TO_ESCAPE_SANDBOX = 'allow-popups-to-escape-sandbox';
    public const SANDBOX_ALLOW_PRESENTATION = 'allow-presentation';
    public const SANDBOX_ALLOW_SAME_ORIGIN = 'allow-same-origin';
    public const SANDBOX_ALLOW_SCRIPTS = 'allow-scripts';
    public const SANDBOX_ALLOW_TOP_NAVIGATION = 'allow-top-navigation';
    public const SANDBOX_VALUES = [
        self::SANDBOX_ALLOW_FORMS, self::SANDBOX_ALLOW_MODALS, self::SANDBOX_ALLOW_ORIENTATION_LOCK,
        self::SANDBOX_ALLOW_POINTER_LOCK, self::SANDBOX_ALLOW_POPUPS, self::SANDBOX_ALLOW_POPUPS_TO_ESCAPE_SANDBOX,
        self::SANDBOX_ALLOW_PRESENTATION, self::SANDBOX_ALLOW_SAME_ORIGIN, self::SANDBOX_ALLOW_SCRIPTS,
        self::SANDBOX_ALLOW_TOP_NAVIGATION
    ];

    /**
     * CSP tags.
     *
     * @var string[][]|string[]|bool[]|null[]
     */
	private $tags = [
        'default-src' => [],
	    'base-uri' => [],
	    'child-src' => [],
	    'font-src' => [],
	    'form-action' => [],
	    'frame-ancestors' => [],
	    'frame-src' => [],
	    'img-src' => [],
	    'manifest-src' => [],
	    'media-src' => [],
	    'object-src' => [],
	    'script-src' => [],
	    'style-src' => [],
	    'worker-src' => [],
        'referer' => null,
        'plugin-types' => [],
        'report-uri' => [],
        'require-sri-for' => [],
        'sandbox' => null,
        'upgrade-insecure-requests' => false,
        'block-all-mixed-content' => false
    ];

    /**
     * ContentSecurityPolicyMiddleware constructor.
     */
	public function __construct()
	{
        parent::__construct('Content-Security-Policy');
	}

    /**
     * Enable the 'upgrade-insecure-requests' flag or the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/upgrade-insecure-requests
     */
	public function upgradeInsecureRequests():void
    {
        $this->tags['upgrade-insecure-requests'] = true;
    }

    /**
     * Enable the 'block-all-mixed-content' flag of the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/block-all-mixed-content
     */
    public function blockAllMixedContent():void
    {
        $this->tags['block-all-mixed-content'] = true;
    }

    /**
     * Sets the 'sandbox' value of the CSP. See the SANDBOX_XYZ class constants for the possible values.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/sandbox
     * @param string $sandbox
     * @throws MiddlewareException
     */
    public function setSandbox(string $sandbox):void
    {
        if (!in_array($sandbox, self::SANDBOX_VALUES)) {
            throw new MiddlewareException(
                $this,
                sprintf(
                    "%s is not a correct value for the CSP sandbox, correct values are: %s (see %s)",
                    $sandbox, implode(', ', self::SANDBOX_VALUES),
                    'https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/sandbox'
                )
            );
        }
        $this->tags['sandbox'] = $sandbox;
    }

    /**
     * Sets the 'referrer' value of the CSP. See the REFERER_POLICY_XYZ class constants for the possible values.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/referrer
     * @param string $refererPolicy
     * @throws MiddlewareException
     */
    public function setRefererPolicy(string $refererPolicy):void
    {
        if (!in_array($refererPolicy, self::REFERER_POLICY_VALUES)) {
            throw new MiddlewareException(
                $this,
                sprintf(
                    "%s is not a valid CSP referer policy, correct values are: %s (see %s)",
                    $refererPolicy, implode(', ', self::REFERER_POLICY_VALUES),
                    'https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/referrer'
                )
            );
        }
        $this->tags['referer'] = $refererPolicy;
    }

    /**
     * Sets the 'require-sri-for' value of the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/require-sri-for
     * @param bool $script
     * @param bool $style
     */
    public function requireSriFor(bool $script, bool $style):void
    {
        if ($script && $style) {
            $this->tags['require-sri-for'] = ['script', 'style'];
        }
        else if ($script) {
            $this->tags['require-sri-for'] = ['script'];
        }
        else if ($style) {
            $this->tags['require-sri-for'] = ['style'];
        }
    }

    /**
     * Sets the CSP's report URI.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/report-uri
     * @param string $reportUri
     * @throws MiddlewareException
     * @return bool
     */
    public function addReportUri(string $reportUri):bool
    {
        if (!filter_var($reportUri, FILTER_VALIDATE_URL)) {
            throw new MiddlewareException(
                $this,
                sprintf(
                    "'%s' is not a valid URI and can not be set as the CSP report URI",
                    $reportUri
                )
            );
        }
        if (!in_array($reportUri, $this->tags['report-uri'])) {
            $this->tags['report-uri'][] = $reportUri;
            return true;
        }
        return false;
    }

    /**
     * Add a new plugin media type ot the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/plugin-types
     * @param string $mediaType
     * @throws MiddlewareException
     * @return bool
     */
    public function addPluginType(string $mediaType):bool
    {
        if (!preg_match('#^[-\w]+/[-\w]+$#ui', $mediaType)) {
            throw new MiddlewareException(
                $this,
                sprintf(
                    "'%s' is not a valid media type and can not be used as a CSP plugin type",
                    $mediaType
                )
            );
        }
        if (!in_array($mediaType, $this->tags['plugin-types'])) {
            $this->tags['plugin-types'][] = $mediaType;
            return true;
        }
        return false;
    }

    /**
     * Adds a 'default-src' source to the CSP.
     *
     * @param string $source
     * @return bool
     */
    public function addDefaultSrc(string $source):bool
    {
        if (!in_array($source, $this->tags['default-src'])) {
            $this->tags['default-src'][] = $source;
            return true;
        }
        return false;
    }

    /**
     * Adds a 'base-uri' to the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/base-uri
     * @param string $source
     * @return bool
     */
    public function addBaseUri(string $source):bool
    {
        if (!in_array($source, $this->tags['base-uri'])) {
            $this->tags['base-uri'][] = $source;
            return true;
        }
        return false;
    }

    /**
     * Adds a 'child-src' source to the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy
     * @param string $source
     * @return bool
     */
    public function addChildSrc(string $source):bool
    {
        if (!in_array($source, $this->tags['child-src'])) {
            $this->tags['child-src'][] = $source;
            return true;
        }
        return false;
    }

    /**
     * Adds a 'font-src' source to the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/font-src
     * @param string $source
     * @return bool
     */
    public function addFontSrc(string $source):bool
    {
        if (!in_array($source, $this->tags['font-src'])) {
            $this->tags['font-src'][] = $source;
            return true;
        }
        return false;
    }

    /**
     * Adds a 'form-action' to the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/form-action
     * @param string $source
     * @return bool
     */
    public function addFormAction(string $source):bool
    {
        if (!in_array($source, $this->tags['form-action'])) {
            $this->tags['form-action'][] = $source;
            return true;
        }
        return false;
    }

    /**
     * Adds a 'frame-ancestors' to the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/frame-ancestors
     * @param string $source
     * @return bool
     */
    public function addFrameAncestors(string $source):bool
    {
        if (!in_array($source, $this->tags['frame-ancestors'])) {
            $this->tags['frame-ancestors'][] = $source;
            return true;
        }
        return false;
    }

    /**
     * Adds a 'frame-src' source to the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/frame-src
     * @param string $source
     * @return bool
     */
    public function addFrameSrc(string $source):bool
    {
        if (!in_array($source, $this->tags['frame-src'])) {
            $this->tags['frame-src'][] = $source;
            return true;
        }
        return false;
    }

    /**
     * Adds a 'img-src' source to the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/img-src
     * @param string $source
     * @return bool
     */
    public function addImgSrc(string $source):bool
    {
        if (!in_array($source, $this->tags['img-src'])) {
            $this->tags['img-src'][] = $source;
            return true;
        }
        return false;
    }

    /**
     * Adds a 'manifest-src' source to the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/manifest-src
     * @param string $source
     * @return bool
     */
    public function addManifestSrc(string $source):bool
    {
        if (!in_array($source, $this->tags['manifest-src'])) {
            $this->tags['manifest-src'][] = $source;
            return true;
        }
        return false;
    }

    /**
     * Adds a 'media-src' source to the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/media-src
     * @param string $source
     * @return bool
     */
    public function addMediaSrc(string $source):bool
    {
        if (!in_array($source, $this->tags['media-src'])) {
            $this->tags['media-src'][] = $source;
            return true;
        }
        return false;
    }

    /**
     * Adds a 'object-src' source to the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/object-src
     * @param string $source
     * @return bool
     */
    public function addObjectSrc(string $source):bool
    {
        if (!in_array($source, $this->tags['object-src'])) {
            $this->tags['object-src'][] = $source;
            return true;
        }
        return false;
    }

    /**
     * Adds a 'script-src' source to the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/script-src
     * @param string $source
     * @return bool
     */
    public function addScriptSrc(string $source):bool
    {
        if (!in_array($source, $this->tags['script-src'])) {
            $this->tags['script-src'][] = $source;
            return true;
        }
        return false;
    }

    /**
     * Adds a 'style-src' source to the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/style-src
     * @param string $source
     * @return bool
     */
    public function addStyleSrc(string $source):bool
    {
        if (!in_array($source, $this->tags['style-src'])) {
            $this->tags['style-src'][] = $source;
            return true;
        }
        return false;
    }

    /**
     * Adds a 'worker-src' source to the CSP.
     *
     * @link https://developer.mozilla.org/docs/Web/HTTP/Headers/Content-Security-Policy/worker-src
     * @param string $source
     * @return bool
     */
    public function addWorkerSrc(string $source):bool
    {
        if (!in_array($source, $this->tags['worker-src'])) {
            $this->tags['worker-src'][] = $source;
            return true;
        }
        return false;
    }

    /**
     * Returns the CSP header value.
     *
     * @return string|null
     */
    public function getHeaderValue():?string
    {
        $headerValue = [];
        foreach ($this->tags as $name => $tagValue) {
            if (is_array($tagValue) && !empty($tagValue)) {
                $headerValue[] = $name.' '.implode(' ', $tagValue).';';
            }
            elseif (is_string($tagValue) && !empty($tagValue)) {
                $headerValue[] = $name.' '.$tagValue.';';
            }
            elseif (is_bool($tagValue) && $tagValue) {
                $headerValue[] = $name.';';
            }
        }
        return $headerValue ? implode(' ', $headerValue) : null;
    }

    /**
     * @inheritdoc
     * @return array|null
     */
   protected function getHeaderValues():?array
   {
       if ($headerValue = $this->getHeaderValue()) {
           return [$headerValue];
       }
       return null;
   }
}