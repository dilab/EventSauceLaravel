<?php

namespace Dilab\EventSauceLaravel;

use Illuminate\Support\ServiceProvider;
use Spatie\Backup\Commands\ListCommand;
use Spatie\Backup\Helpers\ConsoleOutput;
use Spatie\Backup\Commands\BackupCommand;
use Spatie\Backup\Commands\CleanupCommand;
use Spatie\Backup\Commands\MonitorCommand;
use Spatie\Backup\Notifications\EventHandler;

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

//        $this->app['events']->subscribe(EventHandler::class);
//
//        $this->app->bind('command.backup:run', BackupCommand::class);
//        $this->app->bind('command.backup:clean', CleanupCommand::class);
//        $this->app->bind('command.backup:list', ListCommand::class);
//        $this->app->bind('command.backup:monitor', MonitorCommand::class);
//
//        $this->commands([
//            'command.backup:run',
//            'command.backup:clean',
//            'command.backup:list',
//            'command.backup:monitor',
//        ]);

        $this->app->singleton(ConsoleOutput::class);
    }
}
