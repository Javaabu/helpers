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
        // declare publishes
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('helpers.php'),
            ], 'helpers-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // merge package config with user defined config
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'forms');

        // Require helpers defined on the package.
        require_once __DIR__ . '/helpers.php';

        // Require user defined helpers where provided
        foreach (config('helpers.custom_paths') as $custom_helpers_path) {
            require_once $custom_helpers_path;;
        }
    }
}
