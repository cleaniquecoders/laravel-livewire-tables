<?php

namespace Workbench\App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Workbench\App\Models\Pet;

/**
 * One of two tables on the multi-table demo page. It sets an explicit, unique
 * tableName so its DOM ids (and the reorder JS lookup) never collide with the
 * sibling table — the fix for the "reorder loads the wrong table" bug.
 */
class MultiTableReorderable extends DataTableComponent
{
    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableName('pets_reorderable')
            ->setTheme('flux')
            ->setReorderEnabled()
            ->setDefaultReorderSort('sort_order')
            ->setAdditionalSelects(['pets.sort_order'])
            ->setPerPageAccepted([10, 25]);
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Name', 'name')->sortable()->searchable(),
            Column::make('Age', 'age')->sortable(),
        ];
    }

    public function reorder($items): void
    {
        foreach ($items as $item) {
            Pet::where('id', $item['value'])->update(['sort_order' => $item['order']]);
        }
    }
}
