<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Http\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

/**
 * Minimal table on the Flux theme: no footer / secondary-header / reorder /
 * bulk-action columns, so useFluxTable() is true and the body renders with
 * native flux:table components. Used to exercise the Flux render paths.
 */
class FluxPetsTable extends PetsTable
{
    public function configure(): void
    {
        $this->setPrimaryKey('id')->setTheme('flux');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Name')->sortable()->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Name', 'name_filter')
                ->filter(fn ($builder, string $value) => $builder->where('pets.name', 'like', "%{$value}%")),
        ];
    }
}
