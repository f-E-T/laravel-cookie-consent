<?php

namespace Dmr\CookieConsent;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Dmr\CookieConsent\Events\ConfigLoaded;
use Dmr\PhpToJs\PhpToJsFacade;
use stdClass;

class CookieConsentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $enabled = config('cookieconsent.enable', false);

        if (!$enabled || !$response->getContent() || !$this->isHtml($response->getContent())) {
            return $response;
        }

        $config = config('cookieconsent.config', []);

        $configClass = new stdClass();
        $configClass->config = $config;

        ConfigLoaded::dispatch($configClass);

        PhpToJsFacade::add(['laravelCookieConsent' => [
            'enabled' => $enabled,
            'routes' => [
                'post' => $this->getPostRoute(),
                'redirect' => $this->getRedirectRoute(),
            ],
            'config' => $configClass->config,
        ]]);

        $javaScript = '<script type="text/javascript" src="' . cookieconsent_assets('cookie-consent.js') . '" defer></script>';
        $this->addAsset($javaScript, '</body>', $response);

        $css = '<link rel="stylesheet" href="' . cookieconsent_assets('cookie-consent.css') . '">';
        $this->addAsset($css, '</head>', $response);

        return $response;
    }

    protected function getPostRoute(): string
    {
        $postRouteName = config('cookieconsent.routes.post', '');
        $postRoute = is_string($postRouteName) && $postRouteName !== '' ? route($postRouteName) : '';

        return $postRoute;
    }

    protected function getRedirectRoute(): string
    {
        $redirectRouteName = config('cookieconsent.routes.redirect', '');
        $redirectRoute = is_string($redirectRouteName) && $redirectRouteName !== '' ? route($redirectRouteName) : '';

        return $redirectRoute;
    }

    protected function addAsset(string $script, string $search, Response $response): void
    {
        $content = (string) $response->getContent();
        $position = strripos($content, $search);

        if ($position !== false) {
            $start = substr($content, 0, $position);
            $end = substr($content, $position);
            $content = $start . $script . $end;
        }

        $response->setContent($content);
    }

    protected function isHtml(string $content): bool
    {
        return $content !== strip_tags($content);
    }
}
