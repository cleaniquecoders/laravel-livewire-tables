<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTable;

use function Pest\Livewire\livewire;

/*
| M5 a11y: sortable column headers expose their sort state via aria-sort
| (none | ascending | descending) for screen-reader users.
*/

it('renders aria-sort on sortable headers', function () {
    livewire(PetsTable::class)
        ->assertSeeHtml('aria-sort="none"')
        ->call('sortBy', 'name')
        ->assertSeeHtml('aria-sort="ascending"');
});
