<?php

namespace Fet\CookieConsent\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssetsController extends Controller
{
    const CACHE_MAX_AGE = 31536000;

    public function index(): ResponseFactory|Response
    {
        $disk = Storage::build([
            'driver' => 'local',
            'root' => config('cookieconsent.assets'),
        ]);

        $path = request()->query('path');
        $path = is_string($path) ? $path : '';

        if (Str::endsWith($path, '.js')) {
            $mimeType = 'text/javascript';
        } elseif (Str::endsWith($path, '.css')) {
            $mimeType = 'text/css';
        } else {
            $mimeType = 'text/plain';
        }

        $content = $disk->get($path);

        return response($content, 200, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=' . self::CACHE_MAX_AGE,
            'Expires' => gmdate('D, d M Y H:i:s', time() + self::CACHE_MAX_AGE) . ' GMT',
        ]);
    }
}
