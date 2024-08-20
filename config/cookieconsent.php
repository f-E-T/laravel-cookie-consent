<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable Cookie Consent
    |--------------------------------------------------------------------------
    |
    | This option controls whether the cookie consent is enabled or disabled.
    |
    */
    'enable' => true,

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    | Here you may define the routes for handling the cookie consent actions.
    |
    | - 'post': The route name that handles POST requests when the user makes a consent choice.
    | - 'redirect': The route name to redirect to after the user makes a consent choice.
    | 
    | If these are left empty, no actions will be taken for these events.
    |
    */
    'routes' => [
        'post' => '', // Example: 'cookie-consent.post'
        'redirect' => '', // Example: 'cookie-consent.redirect'
    ],

    /*
    |--------------------------------------------------------------------------
    | Path Exclude
    |--------------------------------------------------------------------------
    |
    | Define paths where the cookie consent should NOT be shown.
    | Use valid regex patterns to exclude specific paths.
    | Example: To exclude all paths under /admin/*, add 'admin(\/.*)?'.
    |
    */
    'paths' => [
        'exclude' => []
    ],

    /*
    |--------------------------------------------------------------------------
    | Cookie Consent Configuration
    |--------------------------------------------------------------------------
    |
    | This array should contain the full configuration for the cookie consent
    | library. It directly maps to the configuration options provided by the
    | CookieConsent JavaScript library. Customize this array to fit your needs.
    | Refer to the documentation for available options.
    |
    */
    'config' => [
        'categories' => [
            'necessary' => [
                'enabled' => true,
                'readOnly' => true
            ],
            'analytics' => []
        ],
        'language' => [
            'default' => 'en',
            'translations' => [
                'en' => [
                    'consentModal' => [
                        'title' => 'We use cookies',
                        'description' => 'Cookie modal description',
                        'acceptAllBtn' => 'Accept all',
                        'acceptNecessaryBtn' => 'Reject all',
                        'showPreferencesBtn' => 'Manage Individual preferences'
                    ],
                    'preferencesModal' => [
                        'title' => 'Manage cookie preferences',
                        'acceptAllBtn' => 'Accept all',
                        'acceptNecessaryBtn' => 'Reject all',
                        'savePreferencesBtn' => 'Accept current selection',
                        'closeIconLabel' => 'Close modal',
                        'sections' => [
                            [
                                'title' => 'Somebody said ... cookies?',
                                'description' => 'I want one!'
                            ],
                            [
                                'title' => 'Strictly Necessary cookies',
                                'description' => 'These cookies are essential for the proper functioning of the website and cannot be disabled.',
                                'linkedCategory' => 'necessary'
                            ],
                            [
                                'title' => 'Performance and Analytics',
                                'description' => 'These cookies collect information about how you use our website. All of the data is anonymized and cannot be used to identify you.',
                                'linkedCategory' => 'analytics'
                            ],
                            [
                                'title' => 'More information',
                                'description' => 'For any queries in relation to my policy on cookies and your choices, please <a href="#contact-page">contact us</a>'
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]

];
