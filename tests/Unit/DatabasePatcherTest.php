<?php

use DanieleMontecchi\LaravelDataPatcher\DatabasePatcher;

it('can instantiate DatabasePatcher', function () {
    $patcher = new DatabasePatcher();

    expect($patcher)->toBeInstanceOf(DatabasePatcher::class);
});
