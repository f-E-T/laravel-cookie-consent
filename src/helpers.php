<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('cookieconsent_assets')) {
    function cookieconsent_assets(string $path): string
    {
        $disk = Storage::build([
            'driver' => 'local',
            'root' => config('cookieconsent.assets'),
        ]);

        $hash = md5((string) $disk->get($path));

        return route('cookie-consent.assets') . '?path=' . urlencode($path) . '&v=' . $hash;
    }
}
