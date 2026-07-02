<?php

namespace Workbench\App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Workbench\App\Livewire\Concerns\PetColumns;
use Workbench\App\Models\Pet;

/**
 * #48 — client-side column visibility: every selectable column renders and is
 * toggled instantly via Alpine x-show (no Livewire round-trip per toggle).
 */
class ClientSideColumnsTable extends DataTableComponent
{
    use PetColumns;

    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTheme('tailwind')
            ->setColumnSelectEnabled()
            ->setUseClientSideColumnVisibilityEnabled();
    }
}
