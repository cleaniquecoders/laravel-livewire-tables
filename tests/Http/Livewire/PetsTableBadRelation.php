<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Http\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Misconfiguration: a scalar column pointed at a BelongsToMany relation, which
 * cannot be resolved via a join. Used to assert the guard raises a clear error.
 */
class PetsTableBadRelation extends PetsTable
{
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Vet Name', 'veterinaries.name'),
        ];
    }
}
