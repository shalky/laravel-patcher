<?php

it('runs the patch:install command successfully', function () {
    $this->artisan('patch:install')
        ->assertSuccessful()
        ->expectsOutputToContain('Patches table created successfully');
});
