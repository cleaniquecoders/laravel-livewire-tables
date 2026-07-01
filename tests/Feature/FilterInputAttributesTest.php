<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTableFilterAttributes;

use function Pest\Livewire\livewire;

/*
| #27 (#2000) — arbitrary attributes set on a filter via setInputAttributes()
| must reach the rendered filter input.
*/

it('renders arbitrary attributes set on a filter input', function () {
    livewire(PetsTableFilterAttributes::class)
        ->assertSeeHtml('data-role="name-filter"')
        ->assertSeeHtml('maxlength="40"');
});
