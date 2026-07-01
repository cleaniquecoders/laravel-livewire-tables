<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Rappasoft\LaravelLivewireTables\Traits\Core\QueryStrings\HasQueryStringForSort;

trait WithSorting
{
    use HasQueryStringForSort;

    public array $sorts = [];

    public Collection $sortableColumns;

    public bool $sortingStatus = true;

    public bool $singleColumnSortingStatus = true;

    public bool $sortingPillsStatus = true;

    public ?string $defaultSortColumn = null;

    public string $defaultSortDirection = 'asc';

    public string $defaultSortingLabelAsc = 'A-Z';

    public string $defaultSortingLabelDesc = 'Z-A';

    public function mountWithSorting(): void
    {
        $this->setupDefaultSorting();
    }

    public function sortBy(string $columnSelectName): ?string
    {

        if ($this->sortingIsDisabled()) {
            return null;
        }

        // If single sorting is enabled and there are sorts but not the field that is being sorted,
        // then clear all the sorts
        if ($this->singleSortingIsEnabled() && $this->hasSorts() && ! $this->hasSort($columnSelectName)) {
            $this->clearSorts();
            $this->resetComputedPage();

        }

        if (! $this->hasSort($columnSelectName)) {
            $this->resetComputedPage();

            return $this->setSortAsc($columnSelectName);
        }

        if ($this->isSortAsc($columnSelectName)) {
            $this->resetComputedPage();

            return $this->setSortDesc($columnSelectName);
        }

        $this->clearSort($columnSelectName);

        return null;
    }

    public function applySorting(): Builder
    {

        $allCols = $this->getColumns();

        foreach ($this->getSorts() as $column => $direction) {
            if (! in_array($direction, ['asc', 'desc'])) {
                $direction = 'asc';
            }
            $tmpCol = $column;
            $column = $this->getColumnBySelectName($tmpCol);

            if (is_null($column)) {
                foreach ($allCols as $cols) {
                    if ($cols->getSlug() == $tmpCol && $cols->hasSortCallback()) {
                        $this->setBuilder(call_user_func($cols->getSortCallback(), $this->getBuilder(), $direction));

                        continue;
                    }
                }

                continue;
            }

            if (! $column->isSortable()) {
                continue;
            }

            // TODO: Test
            if ($column->hasSortCallback()) {
                $this->setBuilder(call_user_func($column->getSortCallback(), $this->getBuilder(), $direction));
            } elseif ($column->isBaseColumn()) {
                $this->setBuilder($this->getBuilder()->orderBy($column->getColumnSelectName(), $direction));
            } else {
                $value = $this->getBuilder()->getGrammar()->wrap($column->getColumn().' as '.$column->getColumnSelectName());
                $segments = preg_split('/\s+as\s+/i', $value);
                $this->setBuilder($this->getBuilder()->orderByRaw($segments[1].' '.$direction));
            }
        }

        return $this->getBuilder();
    }

    // --- merged from SortingConfiguration (#28) ---

    protected function setupDefaultSorting(): void
    {
        if ($this->sortingIsEnabled() && $this->hasDefaultSort() && ! $this->hasSorts()) {
            $this->setSort($this->getDefaultSortColumn(), $this->getDefaultSortDirection());
        }
    }

    public function setSortingStatus(bool $status): self
    {
        $this->sortingStatus = $status;

        return $this;
    }

    public function setSortingEnabled(): self
    {
        $this->setSortingStatus(true);

        return $this;
    }

    public function setSortingDisabled(): self
    {
        $this->setSortingStatus(false);
        $this->sorts = [];

        return $this;
    }

    public function setSingleSortingStatus(bool $status): self
    {
        $this->singleColumnSortingStatus = $status;

        return $this;
    }

    public function setSingleSortingEnabled(): self
    {
        $this->setSingleSortingStatus(true);

        return $this;
    }

    public function setSingleSortingDisabled(): self
    {
        $this->setSingleSortingStatus(false);

        return $this;
    }

    public function setDefaultSort(string $field, string $direction = 'asc'): self
    {
        $this->defaultSortColumn = $field;
        $this->defaultSortDirection = $direction;

        return $this;
    }

    public function removeDefaultSort(): self
    {
        $this->defaultSortColumn = null;
        $this->defaultSortDirection = 'asc';

        return $this;
    }

    public function setSortingPillsStatus(bool $status): self
    {
        $this->sortingPillsStatus = $status;

        return $this;
    }

    public function setSortingPillsEnabled(): self
    {
        $this->setSortingPillsStatus(true);

        return $this;
    }

    public function setSortingPillsDisabled(): self
    {
        $this->setSortingPillsStatus(false);

        return $this;
    }

    public function setDefaultSortingLabels(string $asc, string $desc): self
    {
        $this->defaultSortingLabelAsc = $asc;
        $this->defaultSortingLabelDesc = $desc;

        return $this;
    }

    // --- merged from SortingHelpers (#28) ---

    public function getSortingStatus(): bool
    {
        return $this->sortingStatus;
    }

    public function getSingleSortingStatus(): bool
    {
        return $this->singleColumnSortingStatus;
    }

    public function getSorts(): array
    {
        foreach ($this->sorts as $column => $direction) {
            if (is_array($direction)) {
                foreach ($direction as $colAppend => $actualDirection) {
                    $this->sorts[$column.'.'.$colAppend] = $actualDirection;
                    unset($this->sorts[$column]);
                }
            }

        }

        return $this->sorts;
    }

    /**
     * @param  array<mixed>  $sorts
     * @return array<mixed>
     */
    public function setSorts(array $sorts = []): array
    {

        return $this->sorts = collect($sorts)
            ->reject(fn ($dir, $column) => ! in_array($column, $this->getSortableColumns()->toArray(), true))
            ->toArray();
    }

    public function getSort(string $field): ?string
    {
        return $this->sorts[$field] ?? null;
    }

    #[On('setSort')]
    #[On('set-sort')]
    public function setSort(string $field, string $direction): string
    {
        return $this->sorts[$field] = $direction;
    }

    public function hasSorts(): bool
    {
        return count($this->getSorts()) > 0;
    }

    public function hasSort(string $field): bool
    {
        return $this->getSort($field) !== null;
    }

    /**
     * Clear the sorts array
     */
    #[On('clearSorts')]
    #[On('clearsorts')]
    public function clearSorts(): void
    {
        $this->sorts = [];
    }

    public function clearSort(string $field): void
    {
        unset($this->sorts[$field]);
    }

    public function setSortAsc(string $field): string
    {
        return $this->setSort($field, 'asc');
    }

    public function setSortDesc(string $field): string
    {
        return $this->setSort($field, 'desc');
    }

    public function isSortAsc(string $field): bool
    {
        return $this->getSort($field) === 'asc';
    }

    public function isSortDesc(string $field): bool
    {
        return $this->getSort($field) === 'desc';
    }

    public function sortingIsEnabled(): bool
    {
        return $this->getSortingStatus() === true;
    }

    public function sortingIsDisabled(): bool
    {
        return $this->getSortingStatus() === false;
    }

    public function singleSortingIsEnabled(): bool
    {
        return $this->getSingleSortingStatus() === true;
    }

    public function singleSortingIsDisabled(): bool
    {
        return $this->getSingleSortingStatus() === false;
    }

    public function hasDefaultSort(): bool
    {
        return $this->getDefaultSortColumn() !== null;
    }

    public function getDefaultSortColumn(): ?string
    {
        return $this->defaultSortColumn;
    }

    public function getDefaultSortDirection(): string
    {
        return $this->defaultSortDirection;
    }

    public function getSortingPillsStatus(): bool
    {
        return $this->sortingPillsStatus;
    }

    public function sortingPillsAreEnabled(): bool
    {
        return $this->getSortingPillsStatus() === true;
    }

    public function sortingPillsAreDisabled(): bool
    {
        return $this->getSortingPillsStatus() === false;
    }

    #[Computed]
    public function getDefaultSortingLabelAsc(): string
    {
        return $this->defaultSortingLabelAsc;
    }

    #[Computed]
    public function getDefaultSortingLabelDesc(): string
    {
        return $this->defaultSortingLabelDesc;
    }

    /**
     * The subset of active sorts that will actually render as a pill: the
     * column resolves, is not hidden, and (when column select is enabled) is
     * currently selected. Mirrors the @continue guards in sorting-pills.blade.
     *
     * @return array<string, string>
     */
    public function getRenderableSortPills(): array
    {
        $renderable = [];

        foreach ($this->getSorts() as $columnSelectName => $direction) {
            $column = $this->getColumnBySelectName($columnSelectName) ?? $this->getColumnBySlug($columnSelectName);

            if (is_null($column) || $column->isHidden()) {
                continue;
            }

            if ($this->columnSelectIsEnabled() && ! $this->columnSelectIsEnabledForColumn($column)) {
                continue;
            }

            $renderable[$columnSelectName] = $direction;
        }

        return $renderable;
    }

    public function hasRenderableSortPills(): bool
    {
        return count($this->getRenderableSortPills()) > 0;
    }

    #[Computed]
    public function showSortPillsSection(): bool
    {
        return $this->sortingIsEnabled() && $this->sortingPillsAreEnabled() && $this->hasRenderableSortPills();
    }

    // --- merged from HasSortingPillsStyling (#28) ---

    protected array $sortingPillsItemAttributes = ['default-styling' => true, 'default-colors' => true, 'class' => ''];

    protected array $sortingPillsClearSortButtonAttributes = ['default-styling' => true, 'default-colors' => true, 'class' => ''];

    protected array $sortingPillsClearAllButtonAttributes = ['default-styling' => true, 'default-colors' => true, 'class' => ''];

    #[Computed]
    public function getSortingPillsItemAttributes(): array
    {
        return $this->sortingPillsItemAttributes;
    }

    #[Computed]
    public function getSortingPillsClearSortButtonAttributes(): array
    {
        return $this->sortingPillsClearSortButtonAttributes;
    }

    #[Computed]
    public function getSortingPillsClearAllButtonAttributes(): array
    {
        return $this->sortingPillsClearAllButtonAttributes;
    }

    public function setSortingPillsItemAttributes(array $attributes = []): self
    {
        $this->sortingPillsItemAttributes = [...$this->sortingPillsItemAttributes, ...$attributes];

        return $this;
    }

    public function setSortingPillsClearSortButtonAttributes(array $attributes = []): self
    {
        $this->sortingPillsClearSortButtonAttributes = [...$this->sortingPillsClearSortButtonAttributes, ...$attributes];

        return $this;
    }

    public function setSortingPillsClearAllButtonAttributes(array $attributes = []): self
    {
        $this->sortingPillsClearAllButtonAttributes = [...$this->sortingPillsClearAllButtonAttributes, ...$attributes];

        return $this;
    }
}
