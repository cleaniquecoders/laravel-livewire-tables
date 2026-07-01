<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Http\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;

/**
 * A column producing inline HTML markup from a label callback + html(), with no
 * dedicated Blade view.
 */
class PetsTableInlineMarkup extends PetsTable
{
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Badge')
                ->label(fn ($row) => '<span class="inline-badge" data-pet="'.$row->id.'">'.$row->name.'</span>')
                ->html(),
        ];
    }
}
