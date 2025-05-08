<?php

namespace DanieleMontecchi\LaravelPatcher\Managers;

use DanieleMontecchi\LaravelPatcher\Contracts\Patch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Class PatcherManager
 *
 * Manages the execution and rollback of database patches.
 */
class PatcherManager
{
    /**
     * Path to the patches directory.
     *
     * @var string
     */
    protected string $patchPath;

    /**
     * The calling command instance.
     */
    protected ?Command $command = null;

    public function __construct(string $patchPath = null)
    {
        $this->patchPath = $patchPath ?? database_path('patches');
    }

    /**
     * Assign the command context for output rendering.
     */
    public function setCommand(Command $command): void
    {
        $this->command = $command;
    }

    /**
     * Get all available patch files.
     *
     * @return array
     */
    public function getPatchFiles(): array
    {
        if (!File::exists($this->patchPath)) {
            return [];
        }

        return collect(File::files($this->patchPath))
            ->map(fn($file) => pathinfo($file, PATHINFO_FILENAME))
            ->sort()
            ->values()
            ->all();
    }

    /**
     * Execute all pending patches.
     *
     * @param bool $pretend
     */
    public function run(bool $pretend = false): void
    {
        $executedPatches = DB::table('patches')->pluck('name')->toArray();

        $pending = collect($this->getPatchFiles())
            ->filter(fn($patch) => !in_array($patch, $executedPatches))
            ->values();

        if ($pending->isEmpty()) {
            $this->command?->info('All pending patches executed successfully.');
            return;
        }

        $this->command?->info('Running patches:');
        $this->command?->newLine();

        foreach ($pending as $patchName) {
            $patchInstance = $this->resolvePatch($patchName);

            $this->command?->getOutput()->write("  {$patchName}  ");

            try {
                if (!$patchInstance->shouldRun()) {
                    $this->command?->getOutput()->writeln('<fg=gray>SKIPPED</>');
                    continue;
                }

                if (!$pretend) {
                    ($patchInstance)();

                    DB::table('patches')->insert([
                        'name' => $patchName,
                        'applied_at' => now(),
                    ]);
                }

                $this->command?->getOutput()->writeln('<fg=green>DONE</>');
            } catch (\Throwable $e) {
                $this->command?->getOutput()->writeln('<fg=red>FAILED</>');
                report($e);
            }
        }

        $this->command?->newLine();
    }

    /**
     * Rollback the last applied patch.
     *
     * @param bool $pretend
     */
    public function rollback(bool $pretend = false): void
    {
        $lastPatch = DB::table('patches')->orderByDesc('applied_at')->first();

        if (!$lastPatch) {
            $this->command?->info('No patches to rollback.');
            return;
        }

        $patchInstance = $this->resolvePatch($lastPatch->name);

        $this->command?->getOutput()->write("  Rolling back: {$lastPatch->name}  ");

        try {
            if (!$pretend) {
                $patchInstance->down();

                DB::table('patches')->where('name', $lastPatch->name)->delete();
            }

            $this->command?->getOutput()->writeln('<fg=green>DONE</>');
        } catch (\Throwable $e) {
            $this->command?->getOutput()->writeln('<fg=red>FAILED</>');
            report($e);
        }
    }

    /**
     * Resolve a patch class instance from its filename.
     *
     * @param string $patchName
     * @return Patch
     */
    protected function resolvePatch(string $patchName): Patch
    {
        $class = Str::studly(implode('_', array_slice(explode('_', $patchName), 4)));
        $class = "Database\\Patches\\{$class}";

        if (!class_exists($class)) {
            require_once "{$this->patchPath}/{$patchName}.php";
        }

        return new $class;
    }
}