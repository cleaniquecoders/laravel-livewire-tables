<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTable;

use function Pest\Livewire\livewire;

/*
| #25 — verifiable markup-level accessibility: sortable headers carry
| scope="col" + aria-sort, and the icon-only collapse toggle has an accessible
| name. (Interactive a11y — focus trap, keyboard nav — needs an AT/browser
| audit and is tracked separately.)
*/

it('marks table headers with scope="col"', function () {
    livewire(PetsTable::class)
        ->assertSeeHtml('scope="col"');
});

it('exposes aria-sort on a sorted header', function () {
    livewire(PetsTable::class)
        ->call('sortBy', 'name')
        ->assertSeeHtml('aria-sort="ascending"');
});

it('announces the results summary to screen readers via aria-live', function () {
    livewire(PetsTable::class)
        ->assertSeeHtml('aria-live="polite"')
        ->assertSeeHtml('role="status"');
});
