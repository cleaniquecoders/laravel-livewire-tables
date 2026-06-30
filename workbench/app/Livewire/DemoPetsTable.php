<?php

namespace Workbench\App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ColorColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\BooleanFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Workbench\App\Models\Breed;
use Workbench\App\Models\Pet;
use Workbench\App\Models\Species;

/**
 * Reference demo table for the workbench.
 *
 * Milestone M2 expands the workbench into one demo component per column type,
 * filter type, and feature, across all three themes. This component is the
 * starting reference that exercises a representative slice.
 */
class DemoPetsTable extends DataTableComponent
{
    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setSearchEnabled()
            ->setColumnSelectEnabled()
            ->setPerPageAccepted([10, 25, 50]);
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()
                ->searchable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Age', 'age')
                ->sortable(),

            Column::make('Species', 'species.name')
                ->sortable()
                ->searchable(),

            Column::make('Breed', 'breed.name')
                ->sortable()
                ->searchable(),

            Column::make('Owner', 'owner.name')
                ->sortable()
                ->searchable(),

            BooleanColumn::make('Vaccinated', 'is_vaccinated'),

            ColorColumn::make('Favorite Color')
                ->color(fn ($row) => $row->favorite_color),

            DateColumn::make('Last Visit', 'last_visit')
                ->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Name')
                ->filter(fn ($builder, string $value) => $builder->where('pets.name', 'like', "%{$value}%")),

            NumberFilter::make('Min Age')
                ->filter(fn ($builder, string $value) => $builder->where('pets.age', '>=', (int) $value)),

            BooleanFilter::make('Vaccinated')
                ->filter(fn ($builder, string $value) => $builder->where('pets.is_vaccinated', (bool) $value)),

            SelectFilter::make('Species')
                ->options(['' => 'All'] + Species::pluck('name', 'id')->toArray())
                ->filter(fn ($builder, string $value) => $builder->where('pets.species_id', $value)),

            MultiSelectFilter::make('Breed')
                ->options(Breed::pluck('name', 'id')->toArray())
                ->filter(fn ($builder, array $values) => $builder->whereIn('pets.breed_id', $values)),
        ];
    }
}
