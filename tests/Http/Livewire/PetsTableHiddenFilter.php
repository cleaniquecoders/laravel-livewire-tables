<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Http\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

/**
 * One visible filter and one hidden via hiddenFromAll(), to verify a filter can
 * be turned off (e.g. conditionally at runtime, since filters() is re-evaluated
 * each render).
 */
class PetsTableHiddenFilter extends PetsTable
{
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Name', 'name'),
        ];
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Visible Filter', 'visible_filter'),
            TextFilter::make('Hidden Filter', 'hidden_filter')->hiddenFromAll(),
        ];
    }
}
