<?php

namespace DanieleMontecchi\LaravelPatcher\Contracts;

/**
 * Abstract base class for all patches.
 * Implement up(), down() and shouldRun(). Do not override __invoke().
 */
abstract class Patch
{
    /**
     * Execute the patch if it should run.
     */
    public function __invoke(): void
    {
        if ($this->shouldRun()) {
            $this->up();
        }
    }

    /**
     * Apply the patch logic.
     *
     * @return void
     */
    abstract public function up(): void;

    /**
     * Revert the patch logic.
     *
     * @return void
     */
    abstract public function down(): void;

    /**
     * Determine whether the patch should run.
     *
     * @return bool
     */
    abstract public function shouldRun(): bool;
}
