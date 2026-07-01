<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTable;
use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTableNamed;

use function Pest\Livewire\livewire;

/*
| #16 — multiple tables on one page. Each table must namespace its DOM ids by
| tableName so the reorder JS (which looks up elements by id) never targets the
| wrong table. setTableName() must also be chainable like every other setter.
*/

it('makes setTableName chainable (returns self)', function () {
    $table = new PetsTable;

    expect($table->setTableName('custom_pets'))->toBe($table);
});

it('namespaces DOM ids by tableName so tables do not collide with the default', function () {
    livewire(PetsTableNamed::class)
        ->assertSeeHtml('custom_pets-table')
        ->assertDontSeeHtml('"table-tbody"');
});
