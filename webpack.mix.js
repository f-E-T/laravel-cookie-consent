let mix = require('laravel-mix');

mix.setPublicPath('dist')
    .js('resources/assets/js/app.js', 'dist/cookie-consent.js')
    .css('resources/assets/css/cookie-consent.css', 'dist');