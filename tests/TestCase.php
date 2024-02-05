<?php

namespace Javaabu\Helpers\Tests;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Javaabu\Helpers\HelpersServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->app['config']->set('app.key', 'base64:yWa/ByhLC/GUvfToOuaPD7zDwB64qkc/QkaQOrT5IpE=');

        $this->app['config']->set('session.serialization', 'php');

        View::addLocation(__DIR__ . '/Feature/views');
    }

    protected function getPackageProviders($app): array
    {
        return [HelpersServiceProvider::class];
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

    /**
     * Clear directory
     */
    protected function deleteDirectory(string $path)
    {
        /** @var Filesystem $files */
        $files = $this->app->make(Filesystem::class);
        $files->deleteDirectory($path);
    }

    /**
     * Delete files
     */
    protected function deleteFile(string $path)
    {
        /** @var Filesystem $files */
        $files = $this->app->make(Filesystem::class);
        $files->delete($path);
    }

    /**
     * Clear directory
     */
    protected function copyFile(string $from, string $to)
    {
        if (! is_dir(dirname($to))) {
            @mkdir(dirname($to), 0777, true);
        }

        copy($from, $to);
    }

    protected function getTestStubPath(string $name): string
    {
        return __DIR__ . '/stubs/' . $name;
    }
}
