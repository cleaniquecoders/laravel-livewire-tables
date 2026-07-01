<?php

namespace Workbench\App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Workbench\App\Livewire\Concerns\PetColumns;
use Workbench\App\Models\Pet;

/**
 * Pagination disabled (all rows) on the Flux theme — capped to a small subset
 * so the demo stays snappy.
 */
class NoPaginationTable extends DataTableComponent
{
    use PetColumns;

    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTheme('flux')
            ->setPaginationDisabled()
            ->setDefaultSort('sort_order', 'asc')
            ->setAdditionalSelects(['pets.sort_order']);
    }

    public function builder(): Builder
    {
        return Pet::query()->limit(15);
    }
}
