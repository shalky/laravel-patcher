<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    Schema::dropIfExists('patches');
    File::ensureDirectoryExists(database_path('patches/Database/Patches'));
});

test('patcher:install crea la tabella patches', function () {
    $this->artisan('patcher:install')
        ->assertExitCode(0);

    expect(Schema::hasTable('patches'))->toBeTrue();
});