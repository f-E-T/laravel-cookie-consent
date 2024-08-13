<?php

namespace Dmr\CookieConsent;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use Dmr\CookieConsent\CookieConsentMiddleware;

class CookieConsentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        
        $this->mergeConfigFrom(__DIR__ . '/../config/cookieconsent.php', 'cookieconsent');
        $this->mergeConfigFrom(__DIR__ . '/../config/cookieconsent.internal.php', 'cookieconsent');

        $this->publishes([
            __DIR__ . '/../config/cookieconsent.php' => config_path('cookieconsent.php'),
        ], 'config');

        $this->appendMiddleware(CookieConsentMiddleware::class);
    }

    public function register(): void
    {
        //
    }

    protected function appendMiddleware(string $middleware): void
    {
        // @phpstan-ignore-next-line
        $kernel = $this->app[Kernel::class];
        $kernel->appendMiddlewareToGroup('web', $middleware);
    }
}
