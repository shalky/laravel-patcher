<?php

namespace DanieleMontecchi\LaravelPatcher\Managers;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use DanieleMontecchi\LaravelPatcher\Contracts\Patch;

class PatcherManager
{
    protected string $patchPath;
    protected ?Command $command = null;

    public function __construct(?string $patchPath = null)
    {
        $this->patchPath = $patchPath ?? database_path('patches');
    }

    public function setCommand(?Command $command): void
    {
        $this->command = $command;
    }

    public function runAll(bool $pretend = false): void
    {
        $applied = array_map('strtolower', DB::table('patches')->pluck('name')->all());
        $all = $this->getPatchFiles();
        $batch = DB::table('patches')->max('batch') + 1;
        $ran = [];

        $pending = array_filter($all, fn($patch) => !in_array(strtolower($patch), $applied));

        if (empty($pending)) {
            $this->command?->outputComponents()->info('Nothing to patch.', \Symfony\Component\Console\Output\Output::OUTPUT_NORMAL);
            return;
        }

        $this->command?->outputComponents()->info('Running patches.', \Symfony\Component\Console\Output\Output::OUTPUT_NORMAL);

        foreach ($pending as $patchName) {
            $patch = $this->resolvePatch($patchName);

            $shouldRun = $patch->shouldRun();
            $description = $shouldRun ? $patchName : "$patchName (SKIPPED)";

            $this->command?->outputComponents()->task($description, function () use (
                $patch,
                $patchName,
                $batch,
                $shouldRun
            ) {
                DB::table('patches')->insert([
                    'name' => $patchName,
                    'batch' => $batch,
                    'applied_at' => now(),
                    'is_applied' => $shouldRun,
                ]);

                if ($shouldRun) {
                    ($patch)();
                }

                return true;
            });


        }

    }

    public function rollback(int $steps = 1): void
    {
        $maxBatch = DB::table('patches')->max('batch');

        if ($maxBatch === null) {
            $this->command?->outputComponents()->info('Nothing to rollback.', \Symfony\Component\Console\Output\Output::OUTPUT_NORMAL);
            return;
        }

        $this->command?->outputComponents()->info('Rolling back patches.', \Symfony\Component\Console\Output\Output::OUTPUT_NORMAL);

        for ($batch = $maxBatch; $batch > $maxBatch - $steps && $batch > 0; $batch--) {
            $patches = DB::table('patches')
                ->where('batch', $batch)
                ->orderByDesc('id')
                ->get();

            foreach ($patches as $record) {
                $patch = $this->resolvePatch($record->name);

                $this->command?->outputComponents()->task($record->name, function () use ($record, $patch) {
                    $patch->down();
                    DB::table('patches')->where('id', $record->id)->delete();
                });
            }
        }
    }

    public function getPatchFiles(): array
    {
        if (!File::exists($this->patchPath)) {
            return [];
        }

        return collect(File::allFiles($this->patchPath))
            ->filter(fn($file) => $file->getExtension() === 'php')
            ->map(fn($file) => $file->getFilenameWithoutExtension())
            ->sort()
            ->values()
            ->all();
    }

    public function resolvePatch(string $name): Patch
    {
        $file = "$this->patchPath/{$name}.php";
        $result = require $file;

        if (!$result instanceof Patch) {
            throw new \RuntimeException("Patch file [{$file}] must return an instance of Patch using an anonymous class.");
        }

        return $result;
    }
}
