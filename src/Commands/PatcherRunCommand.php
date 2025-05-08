<?php

namespace DanieleMontecchi\LaravelPatcher\Commands;

use DanieleMontecchi\LaravelPatcher\Managers\PatcherManager;
use Illuminate\Console\Command;

/**
 * Execute all unapplied patches, grouped in a new batch.
 */
class PatcherRunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patcher:run {--pretend : Show patches without executing them}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute all unapplied patches, grouped by batch.';

    /**
     * Execute the console command.
     *
     * @param PatcherManager $manager
     * @return int
     */
    public function handle(PatcherManager $manager): int
    {
        $pretend = $this->option('pretend');

        $manager->setCommand($this);
        $manager->runAll($pretend);

        return self::SUCCESS;
    }
}
