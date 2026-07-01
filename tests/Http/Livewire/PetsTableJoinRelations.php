<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Http\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Only join-resolved BelongsTo relation columns (no lazy access), used to
 * baseline that relation columns do not trigger N+1 queries.
 */
class PetsTableJoinRelations extends PetsTable
{
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Name', 'name'),
            Column::make('Species', 'species.name'),
            Column::make('Breed', 'breed.name'),
            Column::make('Owner', 'owner.name'),
        ];
    }
}
