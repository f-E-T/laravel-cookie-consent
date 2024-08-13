<?php

Route::group(['middleware' => \Illuminate\Routing\Middleware\SubstituteBindings::class], function () {
    Route::get(
        '/cookie-consent',
        [\Dmr\CookieConsent\Http\Controllers\AssetsController::class, 'index']
    )->name('cookie-consent.assets');
});

