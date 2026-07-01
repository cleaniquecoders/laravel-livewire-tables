<?php

namespace Workbench\App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Workbench\App\Livewire\Concerns\PetColumns;
use Workbench\App\Models\Pet;

/**
 * A table with no matching rows, to preview the Flux empty-state row.
 */
class EmptyStateTable extends DataTableComponent
{
    use PetColumns;

    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTheme('flux')
            ->setSearchEnabled()
            ->setEmptyMessage('No pets match your criteria — try clearing your filters.');
    }

    public function builder(): Builder
    {
        // Force an empty result set so the empty-state row always renders.
        return Pet::query()->whereRaw('1 = 0');
    }
}
