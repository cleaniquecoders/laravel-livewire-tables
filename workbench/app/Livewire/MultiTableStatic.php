<?php

namespace Workbench\App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Workbench\App\Models\Pet;

/**
 * The sibling table on the multi-table demo page. Its own unique tableName keeps
 * its DOM ids distinct from the reorderable table's.
 */
class MultiTableStatic extends DataTableComponent
{
    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableName('pets_browse')
            ->setTheme('flux')
            ->setSearchEnabled()
            ->setPerPageAccepted([10, 25]);
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Name', 'name')->sortable()->searchable(),
            Column::make('Species', 'species.name')->sortable(),
            Column::make('Owner', 'owner.name')->sortable(),
        ];
    }
}
