<?php

Route::group(['middleware' => \Illuminate\Routing\Middleware\SubstituteBindings::class], function () {
    Route::get(
        '/cookie-consent',
        [\Fet\CookieConsent\Http\Controllers\AssetsController::class, 'index']
    )->name('cookie-consent.assets');
});

