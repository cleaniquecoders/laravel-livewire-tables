<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Http\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\WireLinkColumn;

/**
 * A ButtonGroupColumn mixing a LinkColumn and a WireLinkColumn, to verify a
 * WireLink column renders inside a button group.
 */
class PetsTableButtonGroupWireLink extends PetsTable
{
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            ButtonGroupColumn::make('Actions')
                ->buttons([
                    LinkColumn::make('View')
                        ->title(fn ($row) => 'View')
                        ->location(fn ($row) => '#view-'.$row->id),
                    WireLinkColumn::make('Edit')
                        ->title(fn ($row) => 'Edit')
                        ->action(fn ($row) => 'editRow('.$row->id.')'),
                ]),
        ];
    }
}
