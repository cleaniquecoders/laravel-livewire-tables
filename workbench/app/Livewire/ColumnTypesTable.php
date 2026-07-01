<?php

namespace Workbench\App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ColorColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Workbench\App\Models\Pet;

/**
 * Showcases the built-in column types on the Flux theme.
 */
class ColumnTypesTable extends DataTableComponent
{
    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTheme('flux')
            ->setSearchEnabled()
            ->setPerPageAccepted([10, 25, 50]);
    }

    public function columns(): array
    {
        return [
            ImageColumn::make('Avatar')
                ->location(fn ($row) => 'https://robohash.org/'.urlencode($row->name).'?size=40x40&set=set4')
                ->attributes(fn ($row) => [
                    'class' => 'rounded-full h-10 w-10',
                    'alt' => $row->name.' avatar',
                ]),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Age', 'age')
                ->sortable(),

            Column::make('Species', 'species.name')
                ->sortable()
                ->searchable(),

            BooleanColumn::make('Vaccinated', 'is_vaccinated')
                ->sortable(),

            ColorColumn::make('Favorite Color', 'favorite_color'),

            DateColumn::make('Last Visit', 'last_visit')
                ->outputFormat('d M Y')
                ->emptyValue('—')
                ->sortable(),

            LinkColumn::make('Profile')
                ->title(fn ($row) => 'View')
                ->location(fn ($row) => 'https://rappasoft.com/docs/laravel-livewire-tables')
                ->attributes(fn ($row) => [
                    'target' => '_blank',
                    'class' => 'underline',
                ]),
        ];
    }
}
