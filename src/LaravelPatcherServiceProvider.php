<?php

namespace DanieleMontecchi\LaravelPatcher;

use DanieleMontecchi\LaravelPatcher\Commands\MakePatchCommand;
use DanieleMontecchi\LaravelPatcher\Commands\PatcherRunCommand;
use DanieleMontecchi\LaravelPatcher\Commands\PatcherInstallCommand;
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
            $this->commands([
                MakePatchCommand::class,
                PatcherRunCommand::class,
                PatcherRollbackCommand::class,
                PatcherInstallCommand::class,
            ]);

            $this->publishes([
                __DIR__ . '/../database/migrations/' => database_path('migrations'),
                __DIR__ . '/../stubs/' => base_path('stubs'),
            ], 'laravel-patcher');
        }
    }
}
