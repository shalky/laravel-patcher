<?php

namespace DanieleMontecchi\LaravelPatcher\Commands;

use DanieleMontecchi\LaravelPatcher\Managers\PatcherManager;
use Illuminate\Console\Command;

/**
 * Class PatcherRollbackCommand
 *
 * Artisan command to rollback the last applied database patch.
 */
class PatcherRollbackCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'patcher:rollback {--pretend : Show rollback without running}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback the last applied database patch';

    /**
     * Execute the console command.
     *
     * @param \DanieleMontecchi\LaravelPatcher\Managers\PatcherManager $patcher
     */
    public function handle(PatcherManager $patcher): void
    {
        $pretend = $this->option('pretend');

        $patcher->rollback($pretend);

        if ($pretend) {
            $this->info('Patch rollback command executed in pretend mode. No rollback performed.');
        } else {
            $this->info('Last patch rollback executed successfully.');
        }
    }
}
