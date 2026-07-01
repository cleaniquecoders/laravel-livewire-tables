<?php

namespace Workbench\App\Livewire\Concerns;

use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;

/**
 * A representative column set reused across the pagination and theme demos.
 */
trait PetColumns
{
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Name', 'name')->sortable()->searchable(),
            Column::make('Age', 'age')->sortable(),
            Column::make('Species', 'species.name')->sortable(),
            Column::make('Breed', 'breed.name')->sortable(),
            BooleanColumn::make('Vaccinated', 'is_vaccinated'),
            DateColumn::make('Last Visit', 'last_visit')->emptyValue('—')->sortable(),
        ];
    }
}
