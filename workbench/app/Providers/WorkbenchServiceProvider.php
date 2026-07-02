<?php

namespace Workbench\App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Workbench\App\Livewire\BootstrapTheme4Table;
use Workbench\App\Livewire\BootstrapThemeTable;
use Workbench\App\Livewire\ClientSideColumnsTable;
use Workbench\App\Livewire\ColumnTypesTable;
use Workbench\App\Livewire\CursorPaginationTable;
use Workbench\App\Livewire\DemoPetsTable;
use Workbench\App\Livewire\EmptyStateTable;
use Workbench\App\Livewire\FeaturesTable;
use Workbench\App\Livewire\Filters\ExternalBreedFilter;
use Workbench\App\Livewire\Filters\ExternalTextFilter;
use Workbench\App\Livewire\FilterTypesTable;
use Workbench\App\Livewire\FluxThemeTable;
use Workbench\App\Livewire\MultiTableReorderable;
use Workbench\App\Livewire\MultiTableStatic;
use Workbench\App\Livewire\NoPaginationTable;
use Workbench\App\Livewire\ResponsiveTable;
use Workbench\App\Livewire\SimplePaginationTable;
use Workbench\App\Livewire\TailwindThemeTable;

class WorkbenchServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Register the workbench views under a dedicated namespace so they do
        // not collide with Testbench's built-in "welcome" view.
        $this->loadViewsFrom(dirname(__DIR__, 2).'/resources/views', 'workbench');

        // Demo Livewire table components for the workbench showcase — one per
        // scenario (column types, filter types, features, pagination, empty
        // state, and a per-theme comparison).
        Livewire::component('demo-pets-table', DemoPetsTable::class);
        Livewire::component('column-types-table', ColumnTypesTable::class);
        Livewire::component('filter-types-table', FilterTypesTable::class);
        Livewire::component('features-table', FeaturesTable::class);
        Livewire::component('simple-pagination-table', SimplePaginationTable::class);
        Livewire::component('cursor-pagination-table', CursorPaginationTable::class);
        Livewire::component('no-pagination-table', NoPaginationTable::class);
        Livewire::component('empty-state-table', EmptyStateTable::class);
        Livewire::component('flux-theme-table', FluxThemeTable::class);
        Livewire::component('tailwind-theme-table', TailwindThemeTable::class);
        Livewire::component('bootstrap-theme-table', BootstrapThemeTable::class);
        Livewire::component('bootstrap-theme4-table', BootstrapTheme4Table::class);
        Livewire::component('multi-table-reorderable', MultiTableReorderable::class);
        Livewire::component('multi-table-static', MultiTableStatic::class);
        Livewire::component('responsive-table', ResponsiveTable::class);
        Livewire::component('client-side-columns-table', ClientSideColumnsTable::class);

        // LivewireComponentFilter validates its backing component against
        // livewire.class_namespace + a studly dot-path, so point that at the
        // workbench namespace...
        config(['livewire.class_namespace' => 'Workbench\\App\\Livewire']);

        // ...and register the backing components under the same dot-path names
        // the filters reference via setLivewireComponent(), so the runtime
        // <livewire:dynamic-component :is="..."> lookup resolves them.
        Livewire::component('filters.external-text-filter', ExternalTextFilter::class);
        Livewire::component('filters.external-breed-filter', ExternalBreedFilter::class);
    }
}
