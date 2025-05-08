<?php

namespace DanieleMontecchi\LaravelPatcher\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MakePatchCommand
 *
 * Artisan command to generate a new data patch class from a stub.
 */
class MakePatchCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:patch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new patch class';

    /**
     * Handle the command execution by appending a timestamp to the name argument.
     *
     * @return void
     */
    public function handle(): void
    {
        $input = $this->argument('name');
        $timestamp = now()->format('Y_m_d_His');
        $fileName = $timestamp . '_' . Str::snake($input) . '.php';
        $className = Str::studly($input);

        $directory = database_path('patches');
        $path = $directory . DIRECTORY_SEPARATOR . $fileName;

        $this->makeDirectory($path);

        $stub = str_replace('{{ class }}', $className, $this->files->get($this->getStub()));
        $this->files->put($path, $stub);

        $relativePath = str($path)->after(base_path() . DIRECTORY_SEPARATOR)->toString();
        $this->components->info("Patch [{$relativePath}] created successfully.");
    }

    /**
     * Modify the given path to remove the base directory and return the relative path.
     *
     * @param string $fullPath The full file path to be processed.
     * @return string The relative path after removing the base directory.
     */
    protected function patchPath(string $fullPath): string
    {
        return str($fullPath)->after(base_path() . DIRECTORY_SEPARATOR)->toString();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return realpath(__DIR__ . '/../../stubs/patch.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return 'Database\\Patches';
    }

    /**
     * Get the arguments for the command.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the patch'],
        ];
    }
}
