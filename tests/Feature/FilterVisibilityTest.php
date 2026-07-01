<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTableHiddenFilter;

use function Pest\Livewire\livewire;

/*
| #27 (#2134) — a filter can be turned off. filters() is re-evaluated each
| render (so filters can be added/removed at runtime), and hiddenFromAll()
| removes a filter from the menu, pills, and count.
*/

it('excludes a hiddenFromAll() filter from the filter menu', function () {
    livewire(PetsTableHiddenFilter::class)
        ->assertSeeHtml('Visible Filter')
        ->assertDontSeeHtml('Hidden Filter');
});
