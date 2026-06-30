<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTable;

use function Pest\Livewire\livewire;

/*
| Regression: #2268 — the "Applied Sorting" header + Clear button must not
| render when every sort entry is filtered out of the pill loop (unknown,
| hidden, or column-select-deselected column).
*/

it('hides the Applied Sorting header when no sort pills are renderable', function () {
    livewire(PetsTable::class)
        ->call('sortBy', 'name2') // not a real column -> pill is @continue'd
        ->assertDontSee('Applied Sorting');
});

it('shows the Applied Sorting header for a real sortable column', function () {
    livewire(PetsTable::class)
        ->call('sortBy', 'name')
        ->assertSee('Applied Sorting')
        ->assertSee('Name: A-Z');
});
