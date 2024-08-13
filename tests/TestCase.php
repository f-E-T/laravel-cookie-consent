<?php

namespace Fet\CookieConsent\Tests;

use Fet\CookieConsent\CookieConsentServiceProvider;
use Fet\PhpToJs\PhpToJsServiceProvider;

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