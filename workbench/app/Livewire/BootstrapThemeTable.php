<?php

namespace Workbench\App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Workbench\App\Livewire\Concerns\PetColumns;
use Workbench\App\Models\Pet;

class BootstrapThemeTable extends DataTableComponent
{
    use PetColumns;

    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTheme('bootstrap-5')
            ->setSearchEnabled()
            ->setColumnSelectEnabled();
    }
}
