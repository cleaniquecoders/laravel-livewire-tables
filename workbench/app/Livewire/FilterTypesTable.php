<?php

namespace Workbench\App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\BooleanFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateTimeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectDropdownFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Workbench\App\Models\Breed;
use Workbench\App\Models\Pet;
use Workbench\App\Models\Species;

/**
 * Showcases every built-in filter type on the Flux theme, in the popover layout.
 */
class FilterTypesTable extends DataTableComponent
{
    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTheme('flux')
            ->setSearchEnabled()
            ->setFilterLayoutPopover()
            ->setPerPageAccepted([10, 25, 50]);
    }

    public function columns(): array
    {
        return [
            Column::make('Name', 'name')->sortable()->searchable(),
            Column::make('Age', 'age')->sortable(),
            Column::make('Species', 'species.name')->sortable(),
            Column::make('Breed', 'breed.name')->sortable(),
            BooleanColumn::make('Vaccinated', 'is_vaccinated'),
            DateColumn::make('Last Visit', 'last_visit')->emptyValue('—')->sortable(),
        ];
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Name', 'name_filter')
                ->filter(fn (Builder $builder, string $value) => $builder->where('pets.name', 'like', "%{$value}%")),

            NumberFilter::make('Min Age', 'min_age_filter')
                ->filter(fn (Builder $builder, string $value) => $builder->where('pets.age', '>=', (int) $value)),

            BooleanFilter::make('Vaccinated', 'vaccinated_filter')
                ->filter(fn (Builder $builder, string $value) => $builder->where('pets.is_vaccinated', (bool) $value)),

            SelectFilter::make('Species', 'species_filter')
                ->options(['' => 'All'] + Species::orderBy('name')->pluck('name', 'id')->toArray())
                ->filter(fn (Builder $builder, string $value) => $builder->where('pets.species_id', $value)),

            MultiSelectFilter::make('Breed', 'breed_filter')
                ->options(Breed::orderBy('name')->pluck('name', 'id')->toArray())
                ->filter(fn (Builder $builder, array $values) => $builder->whereIn('pets.breed_id', $values)),

            MultiSelectDropdownFilter::make('Species (dropdown)', 'species_dropdown_filter')
                ->options(Species::orderBy('name')->pluck('name', 'id')->toArray())
                ->filter(fn (Builder $builder, array $values) => $builder->whereIn('pets.species_id', $values)),

            DateFilter::make('Visited After', 'visited_after_filter')
                ->filter(fn (Builder $builder, string $value) => $builder->whereDate('pets.last_visit', '>=', $value)),

            DateTimeFilter::make('Visited Before', 'visited_before_filter')
                ->filter(fn (Builder $builder, string $value) => $builder->whereDate('pets.last_visit', '<=', $value)),
        ];
    }
}
