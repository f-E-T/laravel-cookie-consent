# Introduction

The `fet/laravel-cookie-consent` package is a simple Laravel wrapper around the [orestbida/cookieconsent](https://github.com/orestbida/cookieconsent) package.

# Installation

1. `composer require fet/laravel-cookie-consent`
2. `php artisan vendor:publish --provider="Dmr\CookieConsent\CookieConsentServiceProvider" --tag="config"`

# Configuration

```php
// config/cookieconsent.php

return [
    'enable' => true,
    'routes' => [
        'post' => '',
        'redirect' => '',
    ],
    'config' => [],
];
```

The configuration consists of three keys: `enable`, `routes` and `config`. The `config` value is an array representation of the [Configuration](https://cookieconsent.orestbida.com/reference/configuration-reference.html) object and is passed to the [CookieConsent](https://github.com/orestbida/cookieconsent) package as JSON. Feel free to configure the package as you like.

## POST Route
The [Callback/Events](https://cookieconsent.orestbida.com/advanced/callbacks-events.html) are not directly configurable. Instead you can define a `routes.post` which corresponds to an existing route name which is then called via POST request when the events `onFirstConsent` or `onChange` are triggered.

> If the `routes.post` is empty, no POST request is sent.

The data received by the controller looks like this:

```json
{
    "consentId": "xxx",
    "acceptType": "all",
    "acceptedCategories": [
        "necessary",
        "analytics"
    ],
    "rejectedCategories": []
}
```

## Redirect Route
If you want to perform a page redirect after the user has made the cookie consent choice, you can provide a route name to `routes.redirect`.

> If the `routes.redirect` is empty, no redirect is made.

# Events

Sometimes you may need to change the configuration, after the application is booted. You can do so by listening to the `\Dmr\CookieConsent\Events\ConfigLoaded` event.

```php
use Dmr\CookieConsent\Events\ConfigLoaded;

Event::listen(function (ConfigLoaded $event) {
    $config = $event->cookieConsent->config;

    // make changes to the $config array

    $event->cookieConsent->config = $config;
});
```

# Tests
Run the tests with:

```bash
composer test
```
