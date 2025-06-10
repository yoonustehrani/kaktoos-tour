<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            // $this->app->register(TelescopeServiceProvider::class);
        }
        if ($this->app->environment('production')) {
            Livewire::setUpdateRoute(function ($handle) {
                $path = config('app.path').'/livewire/update';
                return Route::post($path, $handle)->middleware('web');
            });
            Livewire::setScriptRoute(function ($handle) {
                $path = config('app.path').'/livewire/livewire.js';
                return Route::get($path, $handle)->middleware('web');
            });
            URL::forceRootUrl(config('app.url'));
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
    }
}
