<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Illuminate\Support\Collection;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Rappasoft\LaravelLivewireTables\Events\ColumnsSelected;
use Rappasoft\LaravelLivewireTables\Traits\Core\QueryStrings\HasQueryStringForColumnSelect;
use Rappasoft\LaravelLivewireTables\Views\Column;

trait WithColumnSelect
{
    use HasQueryStringForColumnSelect;

    #[Locked]
    public array $columnSelectColumns = ['setupRun' => false, 'selected' => [], 'deselected' => [], 'defaultdeselected' => []];

    public array $selectedColumns = [];

    public array $deselectedColumns = [];

    public array $selectableColumns = [];

    public array $defaultDeselectedColumns = [];

    #[Locked]
    public bool $excludeDeselectedColumnsFromQuery = false;

    #[Locked]
    public bool $defaultDeselectedColumnsSetup = false;

    protected bool $columnSelectStatus = true;

    protected bool $columnSelectHiddenOnMobile = false;

    protected bool $columnSelectHiddenOnTablet = false;

    protected bool $useClientSideColumnVisibility = false;

    /*protected function queryStringWithColumnSelect(): array
    {
        if ($this->queryStringIsEnabled() && $this->columnSelectIsEnabled()) {
            return [
                'columns' => ['except' => null, 'history' => false, 'keep' => false, 'as' => $this->getQueryStringAlias().'-columns'],
            ];
        }

        return [];
    }*/

    public function bootedWithColumnSelect(): void
    {
        $this->callHook('configuringColumnSelect');
        $this->callTraitHook('configuringColumnSelect');

        $this->setupColumnSelect();

        $this->callHook('configuredColumnSelect');
        $this->callTraitHook('configuredColumnSelect');

    }

    public function updatedSelectedColumns(): void
    {
        // The query string isn't needed if it's the same as the default
        $this->storeColumnSelectValues();
        if ($this->getEventStatusColumnSelect()) {
            event(new ColumnsSelected($this->getTableName(), $this->getColumnSelectSessionKey(), $this->selectedColumns));
        }
    }

    public function renderingWithColumnSelect(View $view, array $data = []): void
    {
        if (! $this->getComputedPropertiesStatus()) {
            $view->with([
                'selectedVisibleColumns' => $this->selectedVisibleColumns(),
            ]);
        }
    }

    // --- merged from ColumnSelectConfiguration (#28) ---

    public function setColumnSelectStatus(bool $status): self
    {
        $this->columnSelectStatus = $status;

        return $this;
    }

    public function setColumnSelectEnabled(): self
    {
        $this->setColumnSelectStatus(true);

        return $this;
    }

    public function setColumnSelectDisabled(): self
    {
        $this->setColumnSelectStatus(false);

        return $this;
    }

    /**
     * Opt-in (#48 / upstream #2260): render ALL selectable columns and toggle
     * their visibility client-side via Alpine x-show, instead of the default
     * server-side model where deselected columns are not rendered at all.
     * Column toggles become instant (no Livewire round-trip); the selection
     * still syncs to the server (entangled) on the next Livewire request.
     */
    public function setUseClientSideColumnVisibilityStatus(bool $status): self
    {
        $this->useClientSideColumnVisibility = $status;

        return $this;
    }

    public function setUseClientSideColumnVisibilityEnabled(): self
    {
        $this->setUseClientSideColumnVisibilityStatus(true);

        return $this;
    }

    public function setUseClientSideColumnVisibilityDisabled(): self
    {
        $this->setUseClientSideColumnVisibilityStatus(false);

        return $this;
    }

    public function setRememberColumnSelectionStatus(bool $status): self
    {
        $this->storeColumnSelectInSessionStatus($status);

        return $this;
    }

    public function setRememberColumnSelectionEnabled(): self
    {
        $this->setRememberColumnSelectionStatus(true);

        return $this;
    }

    public function setRememberColumnSelectionDisabled(): self
    {
        $this->setRememberColumnSelectionStatus(false);

        return $this;
    }

    public function setExcludeDeselectedColumnsFromQueryEnabled(): self
    {
        $this->setExcludeDeselectedColumnsFromQuery(true);

        return $this;
    }

    public function setExcludeDeselectedColumnsFromQueryDisabled(): self
    {
        $this->setExcludeDeselectedColumnsFromQuery(false);

        return $this;
    }

    public function setExcludeDeselectedColumnsFromQuery(bool $status): self
    {
        $this->excludeDeselectedColumnsFromQuery = $status;

        return $this;
    }

    public function setColumnSelectHiddenOnMobile(): self
    {
        $this->columnSelectHiddenOnMobile = true;

        return $this;
    }

    public function setColumnSelectHiddenOnTablet(): self
    {
        $this->columnSelectHiddenOnTablet = true;

        return $this;
    }

    public function setDefaultDeselectedColumns(): array
    {
        return collect($this->getColumns()
            ->reject(fn (Column $column) => ! $column->isSelectable())
            ->reject(fn (Column $column) => $column->isSelectable() && $column->isSelected())
        )
            ->keyBy(function (Column $column, int $key) {
                return $column->getSlug();
            })
            ->map(fn ($column) => $column->getTitle())
            ->toArray();
    }

    // --- merged from ColumnSelectHelpers (#28) ---

    public function getColumnSelectStatus(): bool
    {
        return $this->columnSelectStatus;
    }

    #[Computed]
    public function columnSelectIsEnabled(): bool
    {
        return $this->getColumnSelectStatus() === true;
    }

    public function columnSelectIsDisabled(): bool
    {
        return $this->getColumnSelectStatus() === false;
    }

    public function columnSelectIsEnabledForColumn(mixed $column): bool
    {
        return in_array($column instanceof Column ? $column->getSlug() : $column, $this->selectedColumns, true);
    }

    public function getColumnSelectIsHiddenOnTablet(): bool
    {
        return $this->columnSelectHiddenOnTablet;
    }

    public function getExcludeDeselectedColumnsFromQuery(): bool
    {
        // Client-side visibility renders every selectable column (toggled via
        // x-show), so their data must always be selected regardless of the flag.
        if ($this->useClientSideColumnVisibilityIsEnabled()) {
            return false;
        }

        return $this->excludeDeselectedColumnsFromQuery;
    }

    /**
     * Whether the client-side (Alpine x-show) column-visibility mode is active.
     * Requires column select itself to be enabled — otherwise there is no
     * selection state to mirror client-side. Ignored on the Flux theme: its
     * native flux:table cells and flux:checkbox dropdown carry no x-show hooks,
     * so flux keeps the default server-side model.
     */
    public function useClientSideColumnVisibilityIsEnabled(): bool
    {
        return $this->useClientSideColumnVisibility && $this->columnSelectIsEnabled() && ! $this->isFlux();
    }

    /**
     * The Alpine x-show expression for a column when client-side visibility is
     * active, or null when the column should render without one (mode off,
     * no column, or a non-selectable/hidden column that always shows).
     */
    public function getClientSideVisibilityXShow(?Column $column): ?string
    {
        if (! $this->useClientSideColumnVisibilityIsEnabled() || is_null($column) || ! $column->isSelectable() || $column->isHidden()) {
            return null;
        }

        return "visibleColumns.includes('".$column->getSlug()."')";
    }

    /**
     * Alpine click handler for the "All Columns" checkbox in client-side mode:
     * select-all mirrors selectAllColumns() (every column slug), deselect-all
     * mirrors deselectAllColumns() (empty; setup re-adds non-selectable ones).
     */
    public function getClientSideAllColumnsToggle(): string
    {
        $allSlugs = json_encode($this->getColumns()->map(fn (Column $column) => $column->getSlug())->values()->toArray());

        return "visibleColumns = \$event.target.checked ? {$allSlugs} : []";
    }

    /**
     * Alpine checked-state expression for the "All Columns" checkbox in
     * client-side mode: checked while every selectable column is visible.
     */
    public function getClientSideAllColumnsChecked(): string
    {
        $selectableSlugs = json_encode($this->getSelectableColumns()->map(fn (Column $column) => $column->getSlug())->values()->toArray());

        return "{$selectableSlugs}.every(s => visibleColumns.includes(s))";
    }

    public function getColumnSelectIsHiddenOnMobile(): bool
    {
        return $this->columnSelectHiddenOnMobile;
    }

    public function getSelectableColumns(): Collection
    {
        return $this->getColumns()
            ->reject(fn (Column $column) => $column->isHidden())
            ->reject(fn (Column $column) => ! $column->isSelectable())
            ->values();
    }

    public function getSelectableSelectedColumns(): Collection
    {
        return $this->getColumns()
            ->reject(fn (Column $column) => $column->isHidden())
            ->reject(fn (Column $column) => ! $column->isSelectable())
            ->reject(fn (Column $column) => ! $this->columnSelectIsEnabledForColumn($column))
            ->values();
    }

    public function getUnSelectableColumns(): Collection
    {
        return $this->getColumns()
            ->reject(fn (Column $column) => $column->isHidden())
            ->reject(fn (Column $column) => $column->isSelectable())
            ->values();
    }

    public function getSelectedColumns(): array
    {
        return $this->selectedColumns ?? [];
    }

    public function getSelectedColumnsForQuery(): array
    {
        return $this->getColumns()
            ->reject(fn (Column $column) => $column->isLabel())
            ->reject(fn (Column $column) => $column->isHidden())
            ->reject(fn (Column $column) => ($column->isSelectable() && ! $this->columnSelectIsEnabledForColumn($column)))
            ->values()
            ->toArray();
    }

    public function getColumnsForColumnSelect(): array
    {
        return $this->getColumns()
            ->reject(fn (Column $column) => ! $column->isSelectable())
            ->reject(fn (Column $column) => $column->isHidden())
            ->keyBy(function (Column $column, int $key) {
                return $column->getSlug();
            })
            ->map(fn ($column) => $column->getTitle())
            ->toArray();
    }

    public function getDefaultVisibleColumns(): array
    {
        return collect($this->getColumns()
            ->reject(fn (Column $column) => $column->isHidden())
            ->reject(fn (Column $column) => $column->isSelectable() && ! $column->isSelected())

        )
            ->map(fn ($column) => $column->getSlug())
            ->values()
            ->toArray();
    }

    public function getAllColumnsAreSelected(): bool
    {
        return $this->getSelectableSelectedColumns()->count() === $this->getSelectableColumns()->count();
    }

    #[Computed]
    public function selectedVisibleColumns(): array
    {
        // In client-side visibility mode, deselected columns still render (their
        // th/td carry an Alpine x-show) so toggling them needs no round-trip.
        return $this->getColumns()
            ->reject(fn (Column $column) => $column->isHidden())
            ->reject(fn (Column $column) => ! $this->useClientSideColumnVisibilityIsEnabled() && ($column->isSelectable() && ! $this->columnSelectIsEnabledForColumn($column)))
            ->values()
            ->toArray();
    }

    public function selectAllColumns(): void
    {
        $this->selectedColumns = [];
        foreach ($this->getColumns() as $column) {
            $this->selectedColumns[] = $column->getSlug();
        }
        $this->forgetColumnSelectSession();
        if ($this->getEventStatusColumnSelect()) {
            event(new ColumnsSelected($this->getTableName(), $this->getColumnSelectSessionKey(), $this->selectedColumns));
        }
    }

    public function deselectAllColumns(): void
    {
        $this->selectedColumns = [];
        session([$this->getColumnSelectSessionKey() => []]);
        if ($this->getEventStatusColumnSelect()) {
            event(new ColumnsSelected($this->getTableName(), $this->getColumnSelectSessionKey(), $this->selectedColumns));
        }
    }

    public function allVisibleColumnsAreSelected(): bool
    {
        return count($this->selectedColumns) === count($this->getDefaultVisibleColumns());
    }

    public function allSelectedColumnsAreVisibleByDefault(): bool
    {
        return count($this->selectedColumns) === count($this->getDefaultVisibleColumns());
    }

    public function setupColumnSelect(): void
    {

        // If the column select is off, make sure to clear the session
        if ($this->columnSelectIsDisabled() && session()->has($this->getColumnSelectSessionKey())) {
            session()->forget($this->getColumnSelectSessionKey());

            return;
        }

        if (empty($this->selectableColumns)) {
            $this->selectableColumns = $this->getColumnsForColumnSelect();
        }
        $this->setupFirstColumnSelectRun();

        // If remember selection is off, then clear the session
        if (! $this->shouldStoreColumnSelectInSession()) {
            $this->forgetColumnSelectSession();
        }

        // Set to either the default set or what is stored in the session
        $selectedColumns = (count($this->selectedColumns) > 1) ?
            $this->selectedColumns :
            session()->get($this->getColumnSelectSessionKey(), $this->getDefaultVisibleColumns());

        // Check to see if there are any excluded that are already stored in the enabled and remove them
        foreach ($this->getColumns() as $column) {
            if (! $column->isSelectable() && ! in_array($column->getSlug(), $selectedColumns, true)) {
                $selectedColumns[] = $column->getSlug();
            }
        }
        $this->selectedColumns = $selectedColumns;
        // $this->storeColumnSelectValues();
    }

    protected function setupFirstColumnSelectRun(): void
    {
        if (! $this->columnSelectColumns['setupRun']) {
            $this->columnSelectColumns['deselected'] = $this->columnSelectColumns['defaultdeselected'] = $this->setDefaultDeselectedColumns();
            $this->columnSelectColumns['setupRun'] = true;
        }

    }

    /** To Be Removed */
    /*
    public function getVisibleColumns(): array
    {
        return $this->selectedVisibleColumns();
    }

    public function getCurrentlySelectedCols(): void {}
    */

    // --- merged from HasColumnSelectStyling (#28) ---

    protected array $columnSelectButtonAttributes = ['default-styling' => true, 'default-colors' => true, 'class' => ''];

    protected array $columnSelectMenuOptionCheckboxAttributes = ['default-styling' => true, 'default-colors' => true, 'class' => ''];

    #[Computed]
    public function getColumnSelectButtonAttributes(): array
    {
        return $this->columnSelectButtonAttributes;
    }

    #[Computed]
    public function getColumnSelectMenuOptionCheckboxAttributes(): array
    {
        return $this->columnSelectMenuOptionCheckboxAttributes;
    }

    public function setColumnSelectButtonAttributes(array $attributes = []): self
    {
        $this->columnSelectButtonAttributes = [...$this->columnSelectButtonAttributes, ...$attributes];

        return $this;
    }

    public function setColumnSelectMenuOptionCheckboxAttributes(array $attributes = []): self
    {
        $this->columnSelectMenuOptionCheckboxAttributes = [...$this->columnSelectMenuOptionCheckboxAttributes, ...$attributes];

        return $this;
    }
}
