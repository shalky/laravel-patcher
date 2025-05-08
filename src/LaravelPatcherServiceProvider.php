<?php

namespace DanieleMontecchi\LaravelPatcher;

use DanieleMontecchi\LaravelPatcher\Commands\MakePatchCommand;
use DanieleMontecchi\LaravelPatcher\Commands\PatcherRunCommand;
use DanieleMontecchi\LaravelPatcher\Commands\PatcherRollbackCommand;
use DanieleMontecchi\LaravelPatcher\Managers\PatcherManager;
use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelPatcherServiceProvider
 *
 * Service provider to register the data patcher commands and bindings.
 */
class LaravelPatcherServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PatcherManager::class, function () {
            return new PatcherManager();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->commands([
                MakePatchCommand::class,
                PatcherRunCommand::class,
                PatcherRollbackCommand::class,
            ]);
        }
    }
}
