<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTable;
use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTableDefaultPerPage;

use function Pest\Livewire\livewire;

/*
| Regression: #2050 — setDefaultPerPage() set inside configure() must be
| honored. Previously mountWithPagination() pinned perPage to the framework
| default (10) during the MOUNT phase, before configure() ran in the BOOTED
| phase, so the configured default was ignored.
*/

beforeEach(function () {
    session()->forget('table-perPage');
});

it('honors setDefaultPerPage set in configure', function () {
    livewire(PetsTableDefaultPerPage::class)->assertSet('perPage', 25);
});

it('persists and restores per-page via the session', function () {
    livewire(PetsTable::class)->set('perPage', 50)->assertSet('perPage', 50);

    // A fresh instance restores the persisted value.
    livewire(PetsTable::class)->assertSet('perPage', 50);
});

it('falls back to the framework default when none configured', function () {
    livewire(PetsTable::class)->assertSet('perPage', 10);
});
