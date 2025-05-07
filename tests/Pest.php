<?php

use DanieleMontecchi\LaravelDataPatcher\DataPatcherServiceProvider;

uses(Tests\TestCase::class)->in('Feature', 'Unit');

function getPackageProviders($app)
{
    return [
        DataPatcherServiceProvider::class,
    ];
}
