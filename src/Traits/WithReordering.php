<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Livewire\Attributes\Computed;
use Rappasoft\LaravelLivewireTables\Views\Column;

trait WithReordering
{
    // Entangled in JS
    public bool $reorderStatus = false;

    // Entangled in JS
    public bool $currentlyReorderingStatus = false;

    // Entangled in JS
    public bool $hideReorderColumnUnlessReorderingStatus = false;

    // Entangled in JS
    public bool $reorderDisplayColumn = false;

    // Retrieved in JS
    public string $defaultReorderColumn = 'sort';

    public array $orderedItems = [];

    protected string $reorderMethod = 'reorder';

    protected string $defaultReorderDirection = 'asc';

    public function setupReordering(): void
    {
        if ($this->reorderIsDisabled()) {
            return;
        }

        // If reordering is disabled but the page has a reorder session, remove it
        if (! $this->reorderIsEnabled() && $this->hasReorderingSession()) {
            $this->forgetReorderingSession();
        }

        $this->restartReorderingIfNecessary();
    }

    public function enablePaginatedReordering(): void {}

    public function enableReordering(): void
    {
        $this->setReorderingSession();
        $this->setReorderingBackup();
        $this->resetReorderFields();
        $this->reorderStatus = $this->currentlyReorderingStatus = $this->reorderDisplayColumn = true;
    }

    public function disableReordering(): void
    {

        $this->forgetReorderingSession();
        $this->setCurrentlyReorderingDisabled();
        $this->getReorderingBackup();
        $this->currentlyReorderingStatus = $this->reorderDisplayColumn = false;

    }

    private function restartReorderingIfNecessary(): void
    {
        // If the page loads with the session, enable reordering
        // Also called in ComponentUtilities@hydrate
        if ($this->reorderIsEnabled() && $this->hasReorderingSession()) {
            $this->setCurrentlyReorderingEnabled();
            $this->resetReorderFields();
        }
    }

    private function resetReorderFields(): void
    {
        $this->{$this->getTableName()} = [];
        $this->setSortingPillsDisabled();
        $this->setSortingDisabled();
        $this->setPaginationDisabled();
        $this->setPerPageVisibilityDisabled();
        $this->setPerPageAccepted([-1]);
        $this->setPerPage(-1);
        $this->setSearchDisabled();
        $this->setBulkActionsDisabled();
        $this->clearSelected();
        $this->setFiltersDisabled();
        $this->setSecondaryHeaderDisabled();
        $this->setFooterDisabled();
        $this->setCollapsingColumnsDisabled();
        $this->resetComputedPage();
    }

    private function setReorderingBackup(): void
    {
        if (session()->has($this->getReorderingBackupSessionKey())) {
            session()->forget($this->getReorderingBackupSessionKey());
        }
        session([$this->getReorderingBackupSessionKey() => $this->getTableStateToArray()]);
    }

    protected function getTableStateToArray(): array
    {
        return [
            $this->getTableName() => $this->{$this->getTableName()},
            'sorts' => $this->sorts,
            'search' => $this->search,
            'selectedColumns' => $this->selectedColumns,
            'sortingPillsStatus' => $this->getSortingPillsStatus(),
            'sortingStatus' => $this->getSortingStatus(),
            'paginationStatus' => $this->getPaginationStatus(),
            'perPageVisibilityStatus' => $this->getPerPageVisibilityStatus(),
            'perPageAccepted' => $this->getPerPageAccepted(),
            'perPage' => $this->getPerPage(),
            'page' => $this->paginators[$this->getComputedPageName()] ?? 1,
            'searchStatus' => $this->getSearchStatus(),
            'bulkActionsStatus' => $this->getBulkActionsStatus(),
            'selected' => $this->getSelected(),
            'selectAllStatus' => $this->getSelectAllStatus(),
            'filtersStatus' => $this->getFiltersStatus(),
            'secondaryHeaderStatus' => $this->getSecondaryHeaderStatus(),
            'footerStatus' => $this->getFooterStatus(),
            'collapsingColumnsStatus' => $this->hasCollapsingColumns(),
        ];
    }

    protected function restoreStateFromArray(array $tableState): void
    {
        $this->{$this->getTableName()} = $tableState[$this->getTableName()];
        $this->sorts = $tableState['sorts'];
        $this->search = $tableState['search'];
        $this->selectedColumns = $tableState['selectedColumns'];
        $this->setSortingPillsStatus($tableState['sortingPillsStatus']);
        $this->setSortingStatus($tableState['sortingStatus']);
        $this->setPaginationStatus($tableState['paginationStatus']);
        $this->setPerPageVisibilityStatus($tableState['perPageVisibilityStatus']);
        $this->setPerPageAccepted($tableState['perPageAccepted']);
        $this->setPerPage($tableState['perPage']);
        $this->setPage($tableState['page'], $this->getComputedPageName());
        $this->setSearchStatus($tableState['searchStatus']);
        $this->setBulkActionsStatus($tableState['bulkActionsStatus']);
        $this->setSelected($tableState['selected']);
        $this->setSelectAllStatus($tableState['selectAllStatus']);
        $this->setFiltersStatus($tableState['filtersStatus']);
        $this->setSecondaryHeaderStatus($tableState['secondaryHeaderStatus']);
        $this->setFooterStatus($tableState['footerStatus']);
        $this->setCollapsingColumnsStatus($tableState['collapsingColumnsStatus']);

    }

    private function getReorderingBackup(): void
    {
        // TODO: Why won't secondary header and footer come back?
        if (session()->has($this->getReorderingBackupSessionKey())) {
            $this->restoreStateFromArray(session()->get($this->getReorderingBackupSessionKey()));
            session()->forget($this->getReorderingBackupSessionKey());
        }
        $this->currentlyReorderingStatus = $this->reorderDisplayColumn = false;

    }

    public function storeReorder(array $rows = []): void
    {
        $this->{$this->getReorderMethod()}($rows);
        $this->forgetReorderingSession();
        $this->getReorderingBackup();
    }

    public function renderingWithReordering(): void
    {
        $this->setupReordering();
    }

    // --- merged from ReorderingConfiguration (#28) ---

    public function setReorderStatus(bool $status): self
    {
        $this->reorderStatus = $status;

        return $this;
    }

    public function setReorderEnabled(): self
    {
        $this->setReorderStatus(true);

        return $this;
    }

    public function setReorderDisabled(): self
    {
        $this->setReorderStatus(false);

        return $this;
    }

    public function setCurrentlyReorderingStatus(bool $status): self
    {
        $this->currentlyReorderingStatus = $status;

        return $this;
    }

    public function setCurrentlyReorderingEnabled(): self
    {
        $this->setCurrentlyReorderingStatus(true);

        return $this;
    }

    public function setCurrentlyReorderingDisabled(): self
    {
        $this->setCurrentlyReorderingStatus(false);

        return $this;
    }

    public function setHideReorderColumnUnlessReorderingStatus(bool $status): self
    {
        $this->hideReorderColumnUnlessReorderingStatus = $status;

        return $this;
    }

    public function setHideReorderColumnUnlessReorderingEnabled(): self
    {
        $this->setHideReorderColumnUnlessReorderingStatus(true);

        return $this;
    }

    public function setHideReorderColumnUnlessReorderingDisabled(): self
    {
        $this->setHideReorderColumnUnlessReorderingStatus(false);

        return $this;
    }

    public function setReorderMethod(string $method): self
    {
        $this->reorderMethod = $method;

        return $this;
    }

    public function setDefaultReorderSort(string $field, string $direction = 'asc'): self
    {
        $this->defaultReorderColumn = $field;
        $this->defaultReorderDirection = $direction;

        return $this;
    }

    // --- merged from ReorderingHelpers (#28) ---

    public function getReorderMethod(): string
    {
        return $this->reorderMethod;
    }

    public function getReorderStatus(): bool
    {
        return $this->reorderStatus;
    }

    #[Computed]
    public function showReorderButton(): bool
    {
        return $this->getReorderStatus() === true;
    }

    #[Computed]
    public function reorderIsEnabled(): bool
    {
        return $this->getReorderStatus() === true;
    }

    public function reorderIsDisabled(): bool
    {
        return $this->getReorderStatus() === false;
    }

    #[Computed]
    public function getCurrentlyReorderingStatus(): bool
    {
        return $this->currentlyReorderingStatus;
    }

    public function currentlyReorderingIsEnabled(): bool
    {
        return $this->getCurrentlyReorderingStatus() === true;
    }

    public function currentlyReorderingIsDisabled(): bool
    {
        return $this->getCurrentlyReorderingStatus() === false;
    }

    public function getHideReorderColumnUnlessReorderingStatus(): bool
    {
        return $this->hideReorderColumnUnlessReorderingStatus;
    }

    public function hideReorderColumnUnlessReorderingIsEnabled(): bool
    {
        return $this->getHideReorderColumnUnlessReorderingStatus() === true;
    }

    public function hideReorderColumnUnlessReorderingIsDisabled(): bool
    {
        return $this->getHideReorderColumnUnlessReorderingStatus() === false;
    }

    public function getDefaultReorderColumn(): ?string
    {
        return $this->defaultReorderColumn;
    }

    public function getDefaultReorderDirection(): string
    {
        return $this->defaultReorderDirection;
    }

    public function setReorderingSession(): void
    {
        session([$this->getReorderingSessionKey() => true]);
    }

    public function forgetReorderingSession(): void
    {
        session()->forget($this->getReorderingSessionKey());
    }

    public function hasReorderingSession(): bool
    {
        return session()->has($this->getReorderingSessionKey());
    }

    public function getReorderingSessionKey(): string
    {
        return $this->getTableName().'-reordering';
    }

    public function getReorderingBackupSessionKey(): string
    {
        return $this->getTableName().'-reordering-backup';
    }

    public function getReorderColumn(): Column
    {
        return Column::make('reorder')->label(fn () => null);
    }

    // --- merged from HasReorderStyling (#28) ---

    protected array $reorderThAttributes = ['default' => true];

    /**
     * Used to get attributes for the <th> for Bulk Actions
     *
     * @return array<mixed>
     */
    #[Computed]
    public function getReorderThAttributes(): array
    {
        return $this->reorderThAttributes ?? ['default' => true];
    }

    #[Computed]
    public function hasReorderThAttributes(): bool
    {
        return $this->getReorderThAttributes() != ['default' => true];
    }

    /**
     * Used to set attributes for the <th> for Reorder Column
     */
    public function setReorderThAttributes(array $reorderThAttributes): self
    {
        $this->reorderThAttributes = [...$this->reorderThAttributes, ...$reorderThAttributes];

        return $this;
    }
}
