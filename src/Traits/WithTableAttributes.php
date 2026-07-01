<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\ComponentAttributeBag;
use Livewire\Attributes\Computed;
use Rappasoft\LaravelLivewireTables\Views\Column;

trait WithTableAttributes
{
    protected array $componentWrapperAttributes = [];

    protected array $tableWrapperAttributes = [];

    protected array $tableAttributes = [];

    protected array $theadAttributes = [];

    protected array $tbodyAttributes = [];

    protected ?Closure $thAttributesCallback;

    protected ?Closure $thSortButtonAttributesCallback;

    protected ?Closure $thSortIconAttributesCallback;

    protected ?Closure $trAttributesCallback;

    protected ?Closure $tdAttributesCallback;

    protected ?Closure $trUrlCallback;

    protected ?Closure $trUrlTargetCallback;

    public bool $shouldBeDisplayed = true;

    // --- merged from TableAttributeConfiguration (#28) ---

    /**
     * Get a list of attributes to override on the main wrapper of the component
     *
     * @param  array<mixed>  $attributes
     * @return $this
     */
    public function setComponentWrapperAttributes(array $attributes = []): self
    {
        $this->componentWrapperAttributes = $attributes;

        return $this;
    }

    /**
     * Set a list of attributes to override on the div that wraps the table
     *
     * @param  array<mixed>  $attributes
     */
    public function setTableWrapperAttributes(array $attributes = []): self
    {
        $this->tableWrapperAttributes = $attributes;

        return $this;
    }

    /**
     * Set a list of attributes to override on the table element
     *
     * @param  array<mixed>  $attributes
     */
    public function setTableAttributes(array $attributes = []): self
    {
        $this->tableAttributes = [...['id' => 'table-'.$this->getTableName()], ...$attributes];

        return $this;
    }

    /**
     * Set a list of attributes to override on the thead element
     *
     * @param  array<mixed>  $attributes
     */
    public function setTheadAttributes(array $attributes = []): self
    {
        $this->theadAttributes = $attributes;

        return $this;
    }

    /**
     * Set a list of attributes to override on the tbody element
     *
     * @param  array<mixed>  $attributes
     */
    public function setTbodyAttributes(array $attributes = []): self
    {
        $this->tbodyAttributes = $attributes;

        return $this;
    }

    /**
     * Set a list of attributes to override on the th elements
     */
    public function setThAttributes(Closure $callback): self
    {
        $this->thAttributesCallback = $callback;

        return $this;
    }

    /**
     * Set a list of attributes to override on the th sort button elements
     */
    public function setThSortButtonAttributes(Closure $callback): self
    {
        $this->thSortButtonAttributesCallback = $callback;

        return $this;
    }

    /**
     * Set a list of attributes to override on the th sort icon elements
     */
    public function setThSortIconAttributes(Closure $callback): self
    {
        $this->thSortIconAttributesCallback = $callback;

        return $this;
    }

    /**
     * Set a list of attributes to override on the td elements
     */
    public function setTrAttributes(Closure $callback): self
    {
        $this->trAttributesCallback = $callback;

        return $this;
    }

    /**
     * Set a list of attributes to override on the td elements
     */
    public function setTdAttributes(Closure $callback): self
    {
        $this->tdAttributesCallback = $callback;

        return $this;
    }

    public function setTableRowUrl(Closure $callback): self
    {
        $this->trUrlCallback = $callback;

        return $this;
    }

    public function setTableRowUrlTarget(Closure $callback): self
    {
        $this->trUrlTargetCallback = $callback;

        return $this;
    }

    public function setShouldBeDisplayedStatus(bool $status): void
    {
        $this->shouldBeDisplayed = $status;
    }

    public function setShouldBeDisplayed(): void
    {
        $this->setShouldBeDisplayedStatus(true);
    }

    public function setShouldBeHidden(): void
    {
        $this->setShouldBeDisplayedStatus(false);
    }

    // --- merged from TableAttributeHelpers (#28) ---

    #[Computed]
    public function getComponentWrapperAttributes(): array
    {
        return count($this->componentWrapperAttributes) ? $this->componentWrapperAttributes : ['id' => 'datatable-'.$this->getId()];
    }

    #[Computed]
    public function getTableWrapperAttributes(): array
    {
        return count($this->tableWrapperAttributes) ? $this->tableWrapperAttributes : ['default' => true];
    }

    #[Computed]
    public function getTableAttributes(): array
    {
        return count($this->tableAttributes) ? $this->tableAttributes : ['id' => 'table-'.$this->getTableName(), 'default' => true];
    }

    #[Computed]
    public function getTheadAttributes(): array
    {
        return count($this->theadAttributes) ? $this->theadAttributes : ['default' => true];
    }

    #[Computed]
    public function getTbodyAttributes(): array
    {
        return count($this->tbodyAttributes) ? $this->tbodyAttributes : ['default' => true];
    }

    /**
     * Used in resources/views/components/table/th.blade.php
     */
    #[Computed]
    public function getThAttributes(Column $column): array
    {

        if (isset($this->thAttributesCallback)) {
            return array_merge(['scope' => 'col', 'default' => false, 'default-colors' => false, 'default-styling' => false], call_user_func($this->thAttributesCallback, $column));
        }

        return ['default' => true, 'default-colors' => true, 'default-styling' => true];
    }

    /**
     * Used in resources/views/components/table/th.blade.php
     */
    #[Computed]
    public function getThSortButtonAttributes(Column $column): array
    {
        if (isset($this->thSortButtonAttributesCallback)) {
            return array_merge(['default' => false, 'default-colors' => false, 'default-styling' => false], call_user_func($this->thSortButtonAttributesCallback, $column));
        }

        return ['default' => true, 'default-colors' => true, 'default-styling' => true];
    }

    /**
     * Used in resources/views/components/table/th.blade.php
     */
    #[Computed]
    public function getThSortIconAttributes(Column $column): array
    {
        if (isset($this->thSortIconAttributesCallback)) {
            return array_merge(['default' => false, 'default-colors' => false, 'default-styling' => false], call_user_func($this->thSortIconAttributesCallback, $column));
        }

        return ['default' => true, 'default-colors' => true, 'default-styling' => true];
    }

    /**
     * Used in resources/views/components/table/th.blade.php
     */
    #[Computed]
    public function getAllThAttributes(Column $column): array
    {
        return [
            'customAttributes' => $this->getThAttributes($column),
            'labelAttributes' => $column->getLabelAttributesBag(),
            'sortButtonAttributes' => $this->getThSortButtonAttributes($column),
            'sortIconAttributes' => $this->getThSortIconAttributes($column),
        ];
    }

    #[Computed]
    public function getTrAttributes(Model $row, int $index): array
    {
        return isset($this->trAttributesCallback) ? call_user_func($this->trAttributesCallback, $row, $index) : ['default' => true];
    }

    #[Computed]
    public function getTdAttributes(Column $column, Model $row, int $colIndex, int $rowIndex): array
    {
        return isset($this->tdAttributesCallback) ? call_user_func($this->tdAttributesCallback, $column, $row, $colIndex, $rowIndex) : ['default' => true];
    }

    public function hasTableRowUrl(): bool
    {
        return isset($this->trUrlCallback);
    }

    public function getTableRowUrl(int|Model $row): ?string
    {
        return isset($this->trUrlCallback) ? call_user_func($this->trUrlCallback, $row) : null;
    }

    public function getTableRowUrlTarget(int|Model $row): ?string
    {
        return isset($this->trUrlTargetCallback) ? call_user_func($this->trUrlTargetCallback, $row) : null;
    }

    #[Computed]
    public function getShouldBeDisplayed(): bool
    {
        return $this->shouldBeDisplayed;
    }

    public function getTopLevelAttributesArray(): array
    {
        return [
            'x-data' => 'laravellivewiretable($wire)',
            'x-init' => "setTableId('".$this->getTableAttributes()['id']."'); setAlpineBulkActions('".$this->showBulkActionsDropdownAlpine()."'); setPrimaryKeyName('".$this->getPrimaryKey()."');",
            'x-cloak',
            'x-show' => 'shouldBeDisplayed',
            'x-on:show-table.window' => 'showTable(event)',
            'x-on:hide-table.window' => 'hideTable(event)',
        ];
    }

    #[Computed]
    public function getTopLevelAttributes(): ComponentAttributeBag
    {
        return new ComponentAttributeBag($this->getTopLevelAttributesArray());
    }
}
