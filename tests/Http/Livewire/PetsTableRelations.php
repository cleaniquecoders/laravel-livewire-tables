<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Http\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * Exercises relation columns: single BelongsTo, nested BelongsTo, two columns
 * resolving to the same related table via different relation paths (species
 * directly vs breed.species), and a BelongsToMany rendered via a label column.
 */
class PetsTableRelations extends PetsTable
{
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Species', 'species.name'),
            Column::make('Breed', 'breed.name'),
            Column::make('Breed Species', 'breed.species.name'),
            Column::make('Owner', 'owner.name'),
            Column::make('Vets')
                ->label(fn ($row) => $row->veterinaries->pluck('name')->join(', ')),
        ];
    }
}
