<?php

namespace the42coders\Workflows;

use Illuminate\Support\ServiceProvider;

class WorkflowsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
         $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'workflows');
         $this->loadViewsFrom(__DIR__.'/../resources/views', 'workflows');
         $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
         $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('workflows.php'),
            ], 'config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/workflows'),
            ], 'views');

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../public/css' => public_path('vendor/workflows/css'),
                __DIR__.'/../public/js' => public_path('vendor/workflows/js'),
                __DIR__.'/../resources/img' => public_path('vendor/workflows/img'),
            ], 'assets');

            // Publishing the translation files.
            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/workflows'),
            ], 'lang');

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'workflows');

        // Register the main class to use with the facade
        $this->app->singleton('workflows', function () {
            return new Workflows;
        });
    }
}
