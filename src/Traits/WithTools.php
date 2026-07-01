<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Illuminate\View\ComponentAttributeBag;
use Livewire\Attributes\Computed;

trait WithTools
{
    protected bool $toolsStatus = true;

    protected bool $toolBarStatus = true;

    // --- merged from ToolsConfiguration (#28) ---

    public function setToolsStatus(bool $status): self
    {
        $this->toolsStatus = $status;

        return $this;
    }

    public function setToolsEnabled(): self
    {
        return $this->setToolsStatus(true);
    }

    public function setToolsDisabled(): self
    {
        return $this->setToolsStatus(false);
    }

    public function setToolBarStatus(bool $status): self
    {
        $this->toolBarStatus = $status;

        return $this;
    }

    public function setToolBarEnabled(): self
    {
        return $this->setToolBarStatus(true);
    }

    public function setToolBarDisabled(): self
    {
        return $this->setToolBarStatus(false);
    }

    // --- merged from ToolsHelpers (#28) ---

    public function getToolsStatus(): bool
    {
        return $this->toolsStatus;
    }

    public function getToolBarStatus(): bool
    {
        return $this->toolBarStatus;
    }

    #[Computed]
    public function shouldShowTools(): bool
    {
        if ($this->getToolsStatus()) {
            if ($this->shouldShowToolBar()) {
                return true;
            } else {
                if ($this->showSortPillsSection()) { // Sort Pills Are Enabled
                    return true;
                } elseif ($this->showFilterPillsSection()) { // Filter Pills Are Enable)
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    #[Computed]
    public function shouldShowToolBar(): bool
    {
        if ($this->getToolsStatus() == false) {
            return false;
        }

        if ($this->getToolBarStatus()) {
            if (
                $this->hasToolbarConfigurableAreas() || // Has Configured Toolbar Configurable Areas
                $this->hasToolbarActions() ||  // Actions Exist In Toolbar
                $this->hasToolbarReorder() ||  // If Reorder Is Enabled
                $this->hasToolbarColumnSelect() || // Column Select Enabled
                $this->displayToolbarSearch() || // If Search Is Enabled
                $this->displayToolbarFilters() ||  // If Filters Are Enabled
                $this->displayToolbarPagination()  // Pagination Selection Is Enabled
            ) {
                return true;
            }

            return false;
        }

        return false;
    }

    #[Computed]
    public function displayToolbarPagination(): bool
    {
        return $this->paginationIsEnabled() && $this->perPageVisibilityIsEnabled();
    }

    #[Computed]
    public function displayToolbarSearch(): bool
    {
        return $this->searchIsEnabled() && $this->searchVisibilityIsEnabled();
    }

    #[Computed]
    public function displayToolbarFilters(): bool
    {
        return $this->filtersAreEnabled() && (($this->filtersVisibilityIsEnabled() && $this->hasVisibleFilters()) || ($this->showBulkActionsDropdownAlpine() && $this->shouldAlwaysHideBulkActionsDropdownOption() != true));
    }

    protected function hasToolbarColumnSelect(): bool
    {
        return $this->columnSelectIsEnabled();
    }

    protected function hasToolbarReorder(): bool
    {
        return $this->reorderIsEnabled();
    }

    protected function hasToolbarConfigurableAreas(): bool
    {
        return $this->hasConfigurableAreaFor('toolbar-left-end') || $this->hasConfigurableAreaFor('toolbar-left-start') || $this->hasConfigurableAreaFor('toolbar-right-start') || $this->hasConfigurableAreaFor('toolbar-right-end');
    }

    protected function hasToolbarActions(): bool
    {
        return $this->hasActions() && $this->showActionsInToolbar();
    }

    // --- merged from HasToolsStyling (#28) ---

    protected array $toolsAttributes = ['class' => '', 'default-colors' => true, 'default-styling' => true];

    protected array $toolBarAttributes = ['class' => '', 'default-colors' => true, 'default-styling' => true];

    #[Computed]
    public function getToolsAttributes(): array
    {
        return $this->getCustomAttributes(propertyName: 'toolsAttributes', default: false, classicMode: false);
    }

    #[Computed]
    public function getToolsAttributesBag(): ComponentAttributeBag
    {
        return $this->getCustomAttributesBagFromArray($this->getToolsAttributes());
    }

    protected function getToolBarAttributes(): array
    {
        return $this->getCustomAttributes(propertyName: 'toolBarAttributes', default: false, classicMode: false);
    }

    #[Computed]
    public function getToolBarAttributesBag(): ComponentAttributeBag
    {
        return $this->getCustomAttributesBagFromArray($this->getToolBarAttributes());

    }

    public function setToolsAttributes(array $toolsAttributes = []): self
    {
        $this->setCustomAttributes(propertyName: 'toolsAttributes', customAttributes: $toolsAttributes);

        return $this;
    }

    public function setToolBarAttributes(array $toolBarAttributes = []): self
    {
        $this->setCustomAttributes(propertyName: 'toolBarAttributes', customAttributes: $toolBarAttributes);

        return $this;
    }
}
