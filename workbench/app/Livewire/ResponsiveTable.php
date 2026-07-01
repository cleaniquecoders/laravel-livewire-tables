<?php

namespace Workbench\App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Workbench\App\Models\Pet;

/**
 * Demonstrates responsive column collapsing. Narrow the viewport to a
 * tablet / mobile breakpoint: the collapsed columns hide and a +/- toggle
 * appears to expand them per row.
 */
class ResponsiveTable extends DataTableComponent
{
    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTheme('flux')
            ->setSearchEnabled()
            ->setPerPageAccepted([10, 25]);
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Name', 'name')->sortable()->searchable(),
            Column::make('Age', 'age')->sortable()->collapseOnMobile(),
            Column::make('Species', 'species.name')->sortable()->collapseOnTablet(),
            Column::make('Breed', 'breed.name')->collapseOnMobile(),
            Column::make('Owner', 'owner.name')->collapseOnTablet(),
            BooleanColumn::make('Vaccinated', 'is_vaccinated')->collapseAlways(),
            DateColumn::make('Last Visit', 'last_visit')->emptyValue('—')->collapseAlways(),
        ];
    }
}
