<?php

namespace Fet\CookieConsent\Tests;

use PHPUnit\Framework\Attributes\Test;

class ConfigTest extends TestCase
{
    protected $defaultConfig = [
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
    ];

    #[Test]
    public function it_defines_a_valid_config()
    {
        $config = include __DIR__ . '/../config/cookieconsent.php';

        $this->assertArrayHasKey('enable', $config);
        $this->assertIsBool($config['enable']);

        $this->assertArrayHasKey('routes', $config);
        $this->assertArrayHasKey('post', $config['routes']);
        $this->assertIsString($config['routes']['post']);
        $this->assertIsString($config['routes']['redirect']);

        $this->assertArrayHasKey('config', $config);
        $this->assertIsArray($config['config']);
        $this->assertEquals($this->defaultConfig, $config['config']);

        $this->assertArrayHasKey('paths', $config);
        $this->assertArrayHasKey('exclude', $config['paths']);
        $this->assertIsArray($config['paths']['exclude']);
    }

    #[Test]
    public function it_defines_a_valid_internal_config()
    {
        $config = include __DIR__ . '/../config/cookieconsent.internal.php';

        $this->assertArrayHasKey('assets', $config);
        $this->assertIsString($config['assets']);
    }

    #[Test]
    public function it_merges_the_config()
    {
        $config = config('cookieconsent');

        $this->assertArrayHasKey('enable', $config);
        $this->assertArrayHasKey('assets', $config);
    }
}
