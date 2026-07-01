<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTableNullableRowUrl;

use function Pest\Livewire\livewire;

/*
| #27 (nullable table row URL) — a row URL callback returning null for a row
| must not render a broken clickable link for that row.
*/

it('renders a link only for rows whose row URL is not null', function () {
    livewire(PetsTableNullableRowUrl::class)
        ->assertSeeHtml('href="https://example.test/pet/1"') // pet #1 is clickable
        ->assertDontSeeHtml('href=""');                      // null-URL rows are not broken links
});
