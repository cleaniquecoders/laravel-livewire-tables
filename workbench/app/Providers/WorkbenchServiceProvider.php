<?php

namespace Workbench\App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Workbench\App\Livewire\DemoPetsTable;

class WorkbenchServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Demo Livewire table components for the workbench showcase.
        Livewire::component('demo-pets-table', DemoPetsTable::class);

        // Additional demo tables (one per column/filter/feature group) are
        // registered here as milestone M2 is built out.
    }
}
