<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTableInlineMarkup;

use function Pest\Livewire\livewire;

/*
| #27 (#2214) — inline custom markup can be rendered from a label() callback
| with html(), without creating a dedicated Blade view.
*/

it('renders inline custom markup from a label callback without a view', function () {
    livewire(PetsTableInlineMarkup::class)
        ->assertSeeHtml('<span class="inline-badge"');
});
