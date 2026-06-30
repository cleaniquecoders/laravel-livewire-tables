<?php

namespace Workbench\App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Workbench\App\Livewire\DemoPetsTable;

class WorkbenchServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register the workbench views under a dedicated namespace so they do
        // not collide with Testbench's built-in "welcome" view.
        $this->loadViewsFrom(dirname(__DIR__, 2).'/resources/views', 'workbench');

        // Demo Livewire table components for the workbench showcase.
        Livewire::component('demo-pets-table', DemoPetsTable::class);

        // Additional demo tables (one per column/filter/feature group) are
        // registered here as milestone M2 is built out.
    }
}
