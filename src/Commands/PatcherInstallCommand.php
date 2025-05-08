<?php

namespace DanieleMontecchi\LaravelPatcher\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class PatcherInstallCommand
 *
 * Artisan command to create the patches table if it doesn't exist.
 */
class PatcherInstallCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'patcher:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the patches table if it does not exist';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (Schema::hasTable('patches')) {
            $this->info('Patches table already exists.');
            return;
        }

        Schema::create('patches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamp('applied_at')->nullable();
        });

        $this->info('Patches table created successfully.');
    }
}
