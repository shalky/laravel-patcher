<?php

namespace DanieleMontecchi\LaravelDataPatcher\Contracts;

/**
 * Interface Patch
 *
 * Defines the methods that must be implemented for data patch classes.
 */
interface Patch
{
    /**
     * Apply the patch.
     */
    public function up(): void;

    /**
     * Revert the patch.
     */
    public function down(): void;

    /**
     * Determine if the patch should run.
     *
     * @return bool
     */
    public function shouldRun(): bool;

    /**
     * Execute the patch logic conditionally.
     */
    public function __invoke(): void;
}
