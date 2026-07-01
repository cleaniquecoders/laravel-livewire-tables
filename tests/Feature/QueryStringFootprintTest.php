<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTable;

use function Pest\Livewire\livewire;

/*
| #22 — keep the query-string footprint small: column selection is NOT persisted
| to the URL by default (it would bloat every link), while the shareable state
| (search / filters / sorts) is; and no default/empty state is tracked until the
| user changes it. (Large-dataset rendering is paginated + join-resolved — see
| RelationColumnQueryCountTest for the no-N+1 baseline.)
*/

it('does not persist column selection to the URL by default', function () {
    $table = new PetsTable;

    expect($table->queryStringConfig['columns']['status'])->toBeFalse()
        ->and($table->queryStringConfig['filters']['status'])->toBeTrue()
        ->and($table->queryStringConfig['search']['status'])->toBeTrue()
        ->and($table->queryStringConfig['sorts']['status'])->toBeTrue();
});

it('tracks no filter state until the user applies one', function () {
    livewire(PetsTable::class)
        ->assertSet('appliedFilters', [])
        ->call('setFilter', 'pet_name_filter', 'Ben')
        ->assertSet('appliedFilters', ['pet_name_filter' => 'Ben']);
});
