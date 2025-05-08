<?php

use DanieleMontecchi\LaravelPatcher\Contracts\Patch;

return new class extends Patch {
    public function up(): void {}
    public function down(): void {}
    public function shouldRun(): bool {
        return false; // o true, secondo il caso
    }
};