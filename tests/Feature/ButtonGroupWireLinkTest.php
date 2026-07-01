<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTableButtonGroupWireLink;

use function Pest\Livewire\livewire;

/*
| #27 (#2297) — a WireLinkColumn can be used inside a ButtonGroupColumn.
*/

it('renders a WireLinkColumn inside a ButtonGroupColumn', function () {
    livewire(PetsTableButtonGroupWireLink::class)
        ->assertSee('View')  // the LinkColumn button
        ->assertSee('Edit'); // the WireLinkColumn button
});
