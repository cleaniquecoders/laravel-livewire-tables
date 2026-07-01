<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\FluxPetsTable;

use function Pest\Livewire\livewire;

/*
| Flux theme render coverage. TestCase registers Flux\FluxServiceProvider, so
| <flux:*> tags compile as real components here — these tests catch both the
| component-tag compile gotchas and the runtime rendering of the Flux paths.
*/

it('renders the table body with native flux:table components under the flux theme', function () {
    livewire(FluxPetsTable::class)
        ->assertSeeHtml('data-flux-columns')
        ->assertSeeHtml('data-flux-column')
        ->assertSeeHtml('data-flux-rows')
        ->assertSeeHtml('data-flux-cell');
});

it('renders filter pills as flux:badge under the flux theme', function () {
    livewire(FluxPetsTable::class)
        ->set('filterComponents.name_filter', 'Cartman')
        ->assertSeeHtml('data-flux-badge')
        ->assertSeeHtml('data-flux-badge-close');
});
