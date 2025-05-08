<?php

namespace Tests;

use DanieleMontecchi\LaravelPatcher\LaravelPatcherServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelPatcherServiceProvider::class,
        ];
    }

}
