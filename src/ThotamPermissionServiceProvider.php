<?php

namespace Thotam\ThotamPermission;

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Thotam\ThotamPermission\Http\Livewire\RoleLivewire;
use Thotam\ThotamPermission\Http\Livewire\PermissionLivewire;

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
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'thotam-permission');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        Route::domain('beta.' . env('APP_DOMAIN', 'cpc1hn.com.vn'))->group(function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('thotam-permission.php'),
                __DIR__.'/../config/permission.php' => config_path('permission.php'),
            ], 'config');

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

        if (class_exists(Livewire::class)) {
            Livewire::component('thotam-permission::permission-livewire', PermissionLivewire::class);
            Livewire::component('thotam-permission::role-livewire', RoleLivewire::class);
        }
    }

}
