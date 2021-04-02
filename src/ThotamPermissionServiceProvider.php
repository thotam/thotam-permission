<?php

namespace Thotam\ThotamPermission;

use Illuminate\Support\ServiceProvider;

class ThotamPermissionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'thotam-permission');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'thotam-permission');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('thotam-permission.php'),
                __DIR__.'/../config/permission.php' => config_path('permission.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../database/migrations/create_permission_tables.php.stu' => database_path('migrations/2015_04_02_133443_create_permission_tables.php'),
            ], 'migrations');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/thotam-permission'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/thotam-permission'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/thotam-permission'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }

        /*
        |--------------------------------------------------------------------------
        | Seed Service Provider need on boot() method
        |--------------------------------------------------------------------------
        */
        $this->app->register(SeedServiceProvider::class);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'thotam-permission');

        // Register the main class to use with the facade
        $this->app->singleton('thotam-permission', function () {
            return new ThotamPermission;
        });
    }

}
