<?php

namespace Workbench\App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Workbench\App\Livewire\Concerns\BootstrapDemoFeatures;
use Workbench\App\Livewire\Concerns\PetColumns;
use Workbench\App\Models\Pet;

class BootstrapTheme4Table extends DataTableComponent
{
    use BootstrapDemoFeatures;
    use PetColumns;

    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTheme('bootstrap-4')
            ->setSearchEnabled()
            ->setColumnSelectEnabled();
    }
}
