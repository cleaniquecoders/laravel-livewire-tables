<?php

namespace Workbench\App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Workbench\App\Livewire\Concerns\PetColumns;
use Workbench\App\Models\Pet;

/**
 * Simple (previous / next) pagination on the Flux theme.
 */
class SimplePaginationTable extends DataTableComponent
{
    use PetColumns;

    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTheme('flux')
            ->setPaginationMethod('simple')
            ->setPerPageAccepted([10, 25, 50]);
    }
}
