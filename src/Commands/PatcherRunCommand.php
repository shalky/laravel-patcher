<?php

namespace DanieleMontecchi\LaravelPatcher\Commands;

use DanieleMontecchi\LaravelPatcher\Managers\PatcherManager;
use Illuminate\Console\Command;
use Illuminate\Console\Concerns\InteractsWithIO;

/**
 * Class PatcherRunCommand
 *
 * Artisan command to run pending database patches.
 */
class PatcherRunCommand extends Command
{
    use InteractsWithIO;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'patcher:run {--pretend : Show patches without running}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all pending database patches';

    /**
     * Execute the console command.
     *
     * @param \DanieleMontecchi\LaravelPatcher\Managers\PatcherManager $patcher
     */
    public function handle(PatcherManager $patcher): void
    {
        $patcher->setCommand($this);
        $patcher->run($this->option('pretend'));
    }

}
