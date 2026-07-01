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
        return $this->excludeDeselectedColumnsFromQuery;
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
        return $this->getColumns()
            ->reject(fn (Column $column) => $column->isHidden())
            ->reject(fn (Column $column) => ($column->isSelectable() && ! $this->columnSelectIsEnabledForColumn($column)))
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
