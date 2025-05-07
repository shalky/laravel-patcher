<?php

namespace DanieleMontecchi\LaravelDataPatcher;

use DanieleMontecchi\LaravelDataPatcher\Commands\MakePatchCommand;
use DanieleMontecchi\LaravelDataPatcher\Commands\PatchCommand;
use DanieleMontecchi\LaravelDataPatcher\Commands\PatchInstallCommand;
use DanieleMontecchi\LaravelDataPatcher\Commands\PatchRollbackCommand;
use Illuminate\Support\ServiceProvider;

/**
 * Class DataPatcherServiceProvider
 *
 * Service provider to register the data patcher commands and bindings.
 */
class DataPatcherServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DatabasePatcher::class, function () {
            return new DatabasePatcher();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakePatchCommand::class,
                PatchCommand::class,
                PatchRollbackCommand::class,
                PatchInstallCommand::class,
            ]);

            $this->publishes([
                __DIR__ . '/../database/migrations/' => database_path('migrations'),
                __DIR__ . '/../stubs/' => base_path('stubs'),
            ], 'laravel-data-patcher');
        }
    }
}
