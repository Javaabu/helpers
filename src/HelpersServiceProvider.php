<?php

namespace Javaabu\Helpers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Require helpers defined on the package.
        require_once __DIR__ . '/helpers.php';
    }
}
