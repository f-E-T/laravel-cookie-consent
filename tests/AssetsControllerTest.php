<?php

namespace Dmr\CookieConsent\Tests;

use Dmr\CookieConsent\Tests\TestCase;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;

class AssetsControllerTest extends TestCase
{
    protected string $expires = '';

    #[Test]
    #[DataProvider('files')]
    public function it_returns_the_content_of_a_file($file, $mimeType, $content): void
    {
        $this->app->config->set('cookieconsent.assets', $path = '/tmp');

        file_put_contents("$path/$file", $content);

        $response = $this->get("/cookie-consent?path=$file");
        $expires = $this->expires ?: gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT';

        $this->assertEquals($content, $response->content());
        $response->assertHeader('Content-Type', $mimeType);
        $response->assertHeader('Cache-Control', 'max-age=31536000, public');
        $response->assertHeader('Expires', $expires);
    }

    public static function files(): array
    {
        return [
            ['app.txt', 'text/plain; charset=UTF-8', 'foo'],
            ['app.csv', 'text/plain; charset=UTF-8', 'foo,bar,bat,baz'],
            ['app.css', 'text/css; charset=UTF-8', 'body {color: red;}'],
            ['app.js', 'text/javascript; charset=UTF-8', "let foo = 'bar';"],
        ];
    }

    #[Test]
    public function it_returns_the_path_of_a_file()
    {
        $this->app->config->set('cookieconsent.assets', $path = '/tmp');

        $file = 'test.css';
        $content = 'body{color: black;}';
        $hash = md5($content);

        file_put_contents("$path/$file", $content);

        $this->assertEquals(
            sprintf('http://localhost/cookie-consent?path=%s&v=%s', $file, $hash),
            cookieconsent_assets('test.css')
        );
    }
}
