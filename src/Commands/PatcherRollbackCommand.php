<?php

namespace DanieleMontecchi\LaravelPatcher\Commands;

use DanieleMontecchi\LaravelPatcher\Managers\PatcherManager;
use Illuminate\Console\Command;

/**
 * Rollback the last executed patch batches.
 */
class PatcherRollbackCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patcher:rollback {--step=1 : Number of batches to roll back}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback the last executed patch batches.';

    /**
     * Execute the console command.
     *
     * @param PatcherManager $manager
     * @return int
     */
    public function handle(PatcherManager $manager): int
    {
        $steps = (int)$this->option('step');

        $manager->setCommand($this);
        $manager->rollback($steps);

        return self::SUCCESS;
    }
}
