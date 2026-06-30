<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTable;
use Rappasoft\LaravelLivewireTables\Views\Column;

use function Pest\Livewire\livewire;

/*
|--------------------------------------------------------------------------
| Pest-native examples
|--------------------------------------------------------------------------
|
| Reference for writing new tests in Pest syntax (the v4 default). Existing
| class-based PHPUnit tests keep running via Pest's PHPUnit interop.
|
*/

it('builds a configurable column fluently', function () {
    $column = Column::make('Name', 'name')->sortable()->searchable();

    expect($column->getTitle())->toBe('Name')
        ->and($column->getField())->toBe('name')
        ->and($column->isSortable())->toBeTrue()
        ->and($column->isSearchable())->toBeTrue();
});

it('renders the datatable component', function () {
    livewire(PetsTable::class)->assertSee('Name');
});
