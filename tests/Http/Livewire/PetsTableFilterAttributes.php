<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Http\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

/**
 * A filter carrying arbitrary input attributes via setInputAttributes(), to
 * verify those attributes reach the rendered filter input.
 */
class PetsTableFilterAttributes extends PetsTable
{
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Name', 'name')->searchable(),
        ];
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Name', 'name_attr_filter')
                ->setInputAttributes([
                    'data-role' => 'name-filter',
                    'maxlength' => '40',
                    'default-styling' => true,
                    'default-colors' => true,
                ]),
        ];
    }
}
