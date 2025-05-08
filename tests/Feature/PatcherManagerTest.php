<?php

test('this is a dummy test just to check setup', function () {
    expect(true)->toBeTrue();
});

//
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\File;
//use DanieleMontecchi\LaravelPatcher\Managers\PatcherManager;
//
//beforeEach(function () {
//    // Make sure the patches table is migrated
//    $this->artisan('migrate')->run();
//
//    // Clear the table before each test
//    DB::table('patches')->delete();
//});
//
//it('stores the patch as not applied when shouldRun returns false', function () {
//    $patchName = '2020_01_01_000001_alpha';
//    $patchFile = database_path("patches/{$patchName}.php");
//
//    File::ensureDirectoryExists(database_path('patches'));
//    File::put($patchFile, <<<PHP
//<?php
//
//use DanieleMontecchi\LaravelPatcher\Contracts\Patch;
//
//return new class extends Patch {
//    public function shouldRun(): bool {
//        return false;
//    }
//
//    public function up(): void {}
//
//    public function down(): void {}
//};
//PHP);
//
//    $manager = new PatcherManager();
//    $manager->runAll();
//
//    $record = DB::table('patches')->where('name', $patchName)->first();
//
//    expect($record)->not()->toBeNull()
//        ->and((bool) $record->is_applied)->toBeFalse();
//
//    File::delete($patchFile);
//});
//
//it('stores the patch as applied when shouldRun returns true', function () {
//    $patchName = '2020_01_01_000001_alpha';
//    $patchFile = database_path("patches/{$patchName}.php");
//
//    File::ensureDirectoryExists(database_path('patches'));
//    File::put($patchFile, <<<PHP
//<?php
//
//use DanieleMontecchi\LaravelPatcher\Contracts\Patch;
//
//return new class extends Patch {
//    public function shouldRun(): bool {
//        return true;
//    }
//
//    public function up(): void {}
//
//    public function down(): void {}
//};
//PHP);
//
//    $manager = new PatcherManager();
//    $manager->runAll();
//
//    $record = DB::table('patches')->where('name', $patchName)->first();
//
//    expect($record)->not()->toBeNull()
//        ->and((bool) $record->is_applied)->toBeTrue();
//
//    File::delete($patchFile);
//});
