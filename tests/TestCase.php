<?php

namespace Javaabu\Helpers\Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Javaabu\Helpers\HelpersServiceProvider;
use Orchestra\Testbench\BrowserKit\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $baseUrl = 'http://localhost';

    public static function isLaravel10(): bool
    {
        return version_compare(app()->version(), '10.0', '>=');
    }

    public function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('app.key', 'base64:yWa/ByhLC/GUvfToOuaPD7zDwB64qkc/QkaQOrT5IpE=');

        $this->app['config']->set('session.serialization', 'php');

        //$this->app['config']->set('form-components.framework', env('FORM_COMPONENTS_FRAMEWORK', 'tailwind'));

        View::addLocation(__DIR__ . '/Feature/views');
    }

    protected function getPackageProviders($app): array
    {
        return [HelpersServiceProvider::class];
    }

    protected function setFramework(string $framework): self
    {
        Config::set('forms.framework', $framework);

        return $this;
    }

    protected function registerTestRoute($uri, callable $post = null): self
    {
        Route::middleware('web')->group(function () use ($uri, $post) {
            Route::view($uri, $uri);

            if ($post) {
                Route::post($uri, $post);
            }
        });

        return $this;
    }
}
