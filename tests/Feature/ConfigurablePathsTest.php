<?php

use Illuminate\Support\ServiceProvider;
use Rappasoft\LaravelLivewireTables\LaravelLivewireTablesServiceProvider;

/*
| #32 — the fork's asset paths are configurable (namespace kept as Rappasoft\).
*/

it('exposes a configurable publish_path with the fork default', function () {
    expect(config('livewire-tables.publish_path'))->toBe('vendor/rappasoft/livewire-tables');
});

it('publishes the bundled JS/CSS to the configured publish_path', function () {
    $targets = array_values(ServiceProvider::pathsToPublish(
        LaravelLivewireTablesServiceProvider::class,
        'livewire-tables-public'
    ));

    $expected = public_path(config('livewire-tables.publish_path'));

    expect($targets)->toContain($expected.'/js')
        ->toContain($expected.'/css');
});
