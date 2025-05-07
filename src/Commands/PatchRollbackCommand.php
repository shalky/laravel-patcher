<?php

namespace DanieleMontecchi\LaravelDataPatcher\Commands;

use DanieleMontecchi\LaravelDataPatcher\DatabasePatcher;
use Illuminate\Console\Command;

/**
 * Class PatchRollbackCommand
 *
 * Artisan command to rollback the last applied database patch.
 */
class PatchRollbackCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'patch:rollback {--pretend : Show rollback without running}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback the last applied database patch';

    /**
     * Execute the console command.
     *
     * @param DatabasePatcher $patcher
     */
    public function handle(DatabasePatcher $patcher): void
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
