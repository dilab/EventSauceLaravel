<?php

namespace Dilab\EventSauceLaravel;

use Illuminate\Support\ServiceProvider;

class EventSauceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/event_sauce.php' => config_path('event_sauce.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/event_sauce.php', 'event_sauce');
    }
}
