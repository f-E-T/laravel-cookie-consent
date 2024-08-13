<?php

namespace Dmr\CookieConsent\Tests;

use Dmr\CookieConsent\CookieConsentServiceProvider;
use Dmr\PhpToJs\PhpToJsServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            CookieConsentServiceProvider::class,
            PhpToJsServiceProvider::class,
        ];
    }
}