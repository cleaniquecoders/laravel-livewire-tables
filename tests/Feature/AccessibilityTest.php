<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTable;

use function Pest\Livewire\livewire;

/*
| #25 — verifiable markup-level accessibility: sortable headers carry
| scope="col" + aria-sort, and the icon-only collapse toggle has an accessible
| name. Interactive a11y is implemented too: x-trap focus traps on the
| popovers (verified in-browser: focus moves in, Tab wraps, ESC returns focus)
| and keyboard row-reorder via ArrowUp/ArrowDown on the focusable drag handle.
| A manual screen-reader (AT) pass remains recommended.
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

it('traps focus inside the column-select dropdown (x-trap)', function () {
    livewire(PetsTable::class)
        ->assertSeeHtml('x-trap="open"');
});

it('traps focus inside the filter popover (x-trap)', function () {
    livewire(PetsTable::class)
        ->assertSeeHtml('x-trap="filterPopoverOpen"');
});

it('renders keyboard-operable reorder handles while reordering', function () {
    livewire(PetsTable::class)
        ->call('enableReordering')
        ->assertSeeHtml('role="button"')
        ->assertSeeHtml('aria-label="Reorder"')
        ->assertSeeHtml('moveRow(event, -1)')
        ->assertSeeHtml('moveRow(event, 1)');
});
