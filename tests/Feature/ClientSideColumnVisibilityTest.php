<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\FluxPetsTable;
use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTable;
use Rappasoft\LaravelLivewireTables\Views\Column;

use function Pest\Livewire\livewire;

/*
| #48 (upstream #2260) — opt-in client-side column visibility. When enabled,
| every selectable column renders with an Alpine x-show bound to an entangled
| mirror of selectedColumns, so toggling a column is instant (no round-trip).
| The default server-side model (deselected columns not rendered) is unchanged.
*/

class ClientSideColumnVisibilityPetsTable extends PetsTable
{
    public function configure(): void
    {
        parent::configure();

        $this->setUseClientSideColumnVisibilityEnabled();
    }
}

class ClientSideColumnVisibilityFluxPetsTable extends FluxPetsTable
{
    public function configure(): void
    {
        parent::configure();

        $this->setUseClientSideColumnVisibilityEnabled();
    }
}

class ClientSideColumnVisibilityCollapsedPetsTable extends PetsTable
{
    public function configure(): void
    {
        parent::configure();

        $this->setUseClientSideColumnVisibilityEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable(),
            Column::make('Name')->sortable(),
            Column::make('Age')->collapseAlways(),
        ];
    }
}

it('keeps the server-side model by default (no entangle, no x-show)', function () {
    livewire(PetsTable::class)
        ->assertDontSeeHtml("\$wire.entangle('selectedColumns')")
        ->assertDontSeeHtml('visibleColumns.includes(');
});

it('renders the entangled visibleColumns state and per-column x-show when enabled', function () {
    livewire(ClientSideColumnVisibilityPetsTable::class)
        ->assertSeeHtml("visibleColumns: \$wire.entangle('selectedColumns')")
        ->assertSeeHtml('x-show="visibleColumns.includes(&#039;age&#039;)"');
});

it('still renders a deselected column (hidden via x-show) when enabled', function () {
    $component = livewire(ClientSideColumnVisibilityPetsTable::class);

    $selected = $component->get('selectedColumns');

    $component->set('selectedColumns', array_values(array_diff($selected, ['age'])))
        ->assertSeeHtml('x-show="visibleColumns.includes(&#039;age&#039;)"');
});

it('removes a deselected column from the DOM in the default server-side model', function () {
    $component = livewire(PetsTable::class);

    $selected = $component->get('selectedColumns');

    $component->set('selectedColumns', array_values(array_diff($selected, ['age'])))
        ->assertDontSeeHtml('-table-td-1-age');
});

it('binds the column-select checkboxes to Alpine instead of wire:model when enabled', function () {
    livewire(ClientSideColumnVisibilityPetsTable::class)
        ->assertSeeHtml('x-model="visibleColumns"');

    livewire(PetsTable::class)
        ->assertDontSeeHtml('x-model="visibleColumns"');
});

it('never excludes deselected columns from the query when enabled', function () {
    $table = new ClientSideColumnVisibilityPetsTable;
    $table->configure();
    $table->setExcludeDeselectedColumnsFromQueryEnabled();

    expect($table->getExcludeDeselectedColumnsFromQuery())->toBeFalse();

    $server = new PetsTable;
    $server->configure();
    $server->setExcludeDeselectedColumnsFromQueryEnabled();

    expect($server->getExcludeDeselectedColumnsFromQuery())->toBeTrue();
});

it('is ignored on the flux theme, which keeps the server-side model', function () {
    // Flux's native table cells and checkbox dropdown carry no x-show hooks, so
    // the mode must gate itself off — otherwise column selection would become a
    // permanent no-op there (confirmed pre-fix by adversarial review).
    $component = livewire(ClientSideColumnVisibilityFluxPetsTable::class);

    expect($component->instance()->useClientSideColumnVisibilityIsEnabled())->toBeFalse();

    $component->assertDontSeeHtml("\$wire.entangle('selectedColumns')");

    $selected = $component->get('selectedColumns');
    $component->set('selectedColumns', array_values(array_diff($selected, ['name'])))
        ->assertDontSeeHtml("sortBy('name')");
});

it('renders deselected collapsed columns in the detail row with x-show when enabled', function () {
    $component = livewire(ClientSideColumnVisibilityCollapsedPetsTable::class);

    $selected = $component->get('selectedColumns');

    // The collapsed-contents detail row must mirror the client-side model: the
    // deselected column still renders there, hidden by x-show, so toggling it
    // needs no round-trip (pre-fix it was server-filtered and went stale).
    $component->set('selectedColumns', array_values(array_diff($selected, ['age'])))
        ->assertSeeHtml('<strong>Age</strong>')
        ->assertSeeHtml('x-show="visibleColumns.includes(&#039;age&#039;)"');
});

it('exposes a chainable, gated API', function () {
    $table = new PetsTable;

    expect($table->useClientSideColumnVisibilityIsEnabled())->toBeFalse()
        ->and($table->setUseClientSideColumnVisibilityEnabled())->toBe($table)
        ->and($table->useClientSideColumnVisibilityIsEnabled())->toBeTrue()
        ->and($table->setUseClientSideColumnVisibilityDisabled())->toBe($table)
        ->and($table->useClientSideColumnVisibilityIsEnabled())->toBeFalse();

    // The mode requires column select itself to be enabled.
    $table->setUseClientSideColumnVisibilityEnabled()->setColumnSelectDisabled();
    expect($table->useClientSideColumnVisibilityIsEnabled())->toBeFalse();
});
