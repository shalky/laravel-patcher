<?php

namespace DanieleMontecchi\LaravelDataPatcher\Commands;

use DanieleMontecchi\LaravelDataPatcher\DatabasePatcher;
use Illuminate\Console\Command;
use Illuminate\Console\Concerns\InteractsWithIO;

/**
 * Class PatchCommand
 *
 * Artisan command to run pending database patches.
 */
class PatchCommand extends Command
{
    use InteractsWithIO;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'patch {--pretend : Show patches without running}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all pending database patches';

    /**
     * Execute the console command.
     *
     * @param DatabasePatcher $patcher
     */
    public function handle(DatabasePatcher $patcher): void
    {
        $patcher->setCommand($this);
        $patcher->run($this->option('pretend'));
    }

}
