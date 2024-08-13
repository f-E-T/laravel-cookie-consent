<?php

namespace Fet\CookieConsent\Tests;

use Illuminate\Http\Request;
use Fet\PhpToJs\PhpToJsFacade;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;
use Fet\CookieConsent\CookieConsentMiddleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Event;
use Fet\CookieConsent\Events\ConfigLoaded;
use Illuminate\Contracts\Http\Kernel;

class CookieConsentMiddlewareTest extends TestCase
{
    #[Test]
    public function it_loads_the_cookie_consent_config()
    {
        Route::get('/test', function () {})->name('test');
        Route::get('/redirect', function () {})->name('redirect');

        $this->app->config->set('cookieconsent', array_merge(
            $this->app->config->get('cookieconsent'),
            [
                'enable' => true,
                'routes' => [
                    'post' => 'test',
                    'redirect' => 'redirect',
                ],
                'config' => ['foo' => 'bar'],
            ]
        ));

        PhpToJsFacade::shouldReceive('add')
            ->once()
            ->with(['laravelCookieConsent' => [
                'enabled' => true,
                'routes' => [
                    'post' => 'http://localhost/test',
                    'redirect' => 'http://localhost/redirect',
                ],
                'config' => ['foo' => 'bar'],
            ]]);

        Event::fake();

        $request = new Request();
        $middleware = new CookieConsentMiddleware();
        $middleware->handle($request, function ($request) {
            $response = new Response();
            $response->setContent('<html><head></head><body></body></html>');

            return $response;
        });

        Event::assertDispatched(function (ConfigLoaded $event) {
            return $event->cookieConsent->config === ['foo' => 'bar'];
        });

        $kernel = $this->app[Kernel::class];
        $middlewareGroups = $kernel->getMiddlewareGroups();

        $this->assertContains(CookieConsentMiddleware::class, $middlewareGroups['web']);
    }

    #[Test]
    public function it_adds_assets_to_the_response()
    {
        $request = new Request();
        $middleware = new CookieConsentMiddleware();
        $response = $middleware->handle($request, function ($request) {
            $response = new Response();
            $response->setContent('<html><head></head><body></body></html>');

            return $response;
        });

        $this->assertStringContainsString('<link rel="stylesheet" href="http://localhost/cookie-consent?path=cookie-consent.css&v=', $response);
        $this->assertStringContainsString('<script type="text/javascript" src="http://localhost/cookie-consent?path=cookie-consent.js&v=', $response);
        $this->assertStringContainsString('defer></script>', $response);
    }

    #[Test]
    public function it_does_not_add_assets_to_response_if_disabled()
    {
        $this->app->config->set('cookieconsent', [
            'enable' => false,
        ]);

        $request = new Request();
        $middleware = new CookieConsentMiddleware();
        $response = $middleware->handle($request, function ($request) {
            $response = new Response();
            $response->setContent('<html><head></head><body></body></html>');

            return $response;
        });

        $this->assertEquals('<html><head></head><body></body></html>', $response->getContent());
    }

    #[Test]
    public function it_does_not_add_assets_to_non_html_response()
    {
        Event::fake();

        $request = new Request();
        $middleware = new CookieConsentMiddleware();
        $response = $middleware->handle($request, function ($request) {
            $response = new Response();
            $response->setContent('{"foo": "bar"}');

            return $response;
        });

        Event::assertNotDispatched(ConfigLoaded::class);

        $this->assertEquals('{"foo": "bar"}', $response->getContent());
    }
}
