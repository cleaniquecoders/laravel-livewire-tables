<?php

namespace Workbench\App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Workbench\App\Livewire\Concerns\PetColumns;
use Workbench\App\Models\Pet;

/**
 * Cursor pagination on the Flux theme.
 */
class CursorPaginationTable extends DataTableComponent
{
    use PetColumns;

    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTheme('flux')
            ->setPaginationMethod('cursor')
            ->setDefaultSort('id', 'asc')
            ->setPerPageAccepted([10, 25, 50]);
    }
}
