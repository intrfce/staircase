<?php

namespace Intrfce\Staircase\Providers;

use Illuminate\Support\ServiceProvider;
use Intrfce\Staircase\Console\InitCommand;
use Intrfce\Staircase\Console\ReleaseCommand;
use Intrfce\Staircase\Staircase;

class StaircaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/staircase.php', 'staircase'
        );

        $this->app->singleton('staircase', function ($app) {
            return new Staircase;
        });
    }

    public function boot()
    {
        $this->offerPublishing();
        $this->registerCommands();
    }

    /**
     * Setup the resource publishing groups for Horizon.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/staircase.php' => config_path('staircase.php'),
            ], 'staircase-config');
        }
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InitCommand::class,
                ReleaseCommand::class,
            ]);
        }
    }
}
