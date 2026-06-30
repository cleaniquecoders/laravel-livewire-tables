<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTable;

use function Pest\Livewire\livewire;

/*
| Regression: #2033 — an invalid (non-array) value arriving for a
| MultiSelectFilter (whose filter callback is typed `array $values`) must be
| treated as empty and dropped, never reaching the callback as a scalar
| (which would TypeError). Confirmed fixed in this codebase; locked here.
*/

it('drops a non-array multiselect value instead of erroring', function () {
    livewire(PetsTable::class)
        ->set('filterComponents.breed', 'not-an-array')
        ->assertHasNoErrors()
        ->assertSee('Name'); // still renders
});

it('strips unknown option keys from a multiselect value', function () {
    $filter = livewire(PetsTable::class)->instance()->getFilterByKey('breed');

    // 999999 is not a valid breed option key and must be stripped.
    expect($filter->validate(['999999']))->toBe([]);
});
