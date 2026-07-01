<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTableBadRelation;
use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTableRelations;

use function Pest\Livewire\livewire;

/*
| Regression coverage for #12 — relation columns must resolve for single and
| nested BelongsTo, for two columns hitting the same related table via
| different paths, and for a BelongsToMany rendered through a label column.
*/

it('renders single and nested BelongsTo relation columns', function () {
    livewire(PetsTableRelations::class)
        ->assertSee('Norwegian Forest')  // breed.name (Cartman, breed 4)
        ->assertSee('Ben')               // owner.name (owner 1)
        ->assertSee('Arabian');          // breed.name (Ben the pet, breed 200)
});

it('resolves two columns against the same table via different relation paths', function () {
    // Cartman: species (direct) = Cat and breed.species (nested) = Cat.
    // May: species = Dog and breed.species = Dog. Both paths must render.
    livewire(PetsTableRelations::class)
        ->assertSee('Cat')
        ->assertSee('Dog')
        ->assertSee('Horse');
});

it('renders a BelongsToMany relation through a label column', function () {
    // Pivot: pet 1 -> vets 1,2 (Dr John Smith, Dr Fabio Ivona).
    livewire(PetsTableRelations::class)
        ->assertSee('Dr John Smith')
        ->assertSee('Dr Fabio Ivona');
});

it('raises a clear error for a scalar column on a to-many relation', function () {
    livewire(PetsTableBadRelation::class);
})->throws('cannot be resolved as a scalar relation column');
