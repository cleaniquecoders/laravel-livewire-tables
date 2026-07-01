<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTable;
use Rappasoft\LaravelLivewireTables\Traits\WithBulkActions;
use Rappasoft\LaravelLivewireTables\Traits\WithColumns;
use Rappasoft\LaravelLivewireTables\Traits\WithColumnSelect;
use Rappasoft\LaravelLivewireTables\Traits\WithFilters;
use Rappasoft\LaravelLivewireTables\Traits\WithFooter;
use Rappasoft\LaravelLivewireTables\Traits\WithPagination;
use Rappasoft\LaravelLivewireTables\Traits\WithReordering;
use Rappasoft\LaravelLivewireTables\Traits\WithSearch;
use Rappasoft\LaravelLivewireTables\Traits\WithSecondaryHeader;
use Rappasoft\LaravelLivewireTables\Traits\WithSorting;

/*
| #28 — characterization guard for HasAllTraits: the component composes every
| feature trait and exposes a stable public API surface. This pins the surface
| so the trait-consolidation refactor can proceed safely.
|
| Empirical note: the `use` order in HasAllTraits IS load-bearing — reordering it
| breaks ~174 tests, because Livewire fires trait lifecycle hooks
| (boot{Trait}/mount{Trait}) in declaration order, so setup sequencing matters.
| Removing the order-dependency therefore requires making that boot/mount
| sequencing explicit, not just reordering the `use` statements.
*/

it('composes every feature trait', function () {
    $uses = class_uses_recursive(PetsTable::class);

    expect($uses)->toContain(
        WithColumns::class,
        WithFilters::class,
        WithSorting::class,
        WithSearch::class,
        WithPagination::class,
        WithBulkActions::class,
        WithReordering::class,
        WithColumnSelect::class,
        WithFooter::class,
        WithSecondaryHeader::class,
    );
});

it('exposes the core public API surface', function () {
    $table = new PetsTable;

    foreach (['columns', 'configure', 'getColumns', 'getFilters', 'getTableName', 'setTableName', 'isTailwind', 'render'] as $method) {
        expect(method_exists($table, $method))->toBeTrue("missing {$method}()");
    }
});
