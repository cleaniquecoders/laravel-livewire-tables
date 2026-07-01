<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Illuminate\View\ComponentAttributeBag;
use Livewire\Attributes\Computed;
use Rappasoft\LaravelLivewireTables\Views\Column;

trait WithBulkActions
{
    public bool $bulkActionsStatus = true;

    // Entangled in JS
    public bool $selectAll = false;

    public array $bulkActions = [];

    public array $bulkActionConfirms = [];

    // Entangled in JS
    public array $selected = [];

    // Entangled in JS
    public bool $hideBulkActionsWhenEmpty = false;

    public ?string $bulkActionConfirmDefaultMessage;

    protected bool $alwaysHideBulkActionsDropdownOption = false;

    protected bool $clearSelectedOnSearch = true;

    protected bool $clearSelectedOnFilter = true;

    // Entangled in JS
    public bool $delaySelectAll = false;

    public function bulkActions(): array
    {
        return property_exists($this, 'bulkActions') ? $this->bulkActions : [];
    }

    // --- merged from BulkActionsConfiguration (#28) ---

    /**
     * @param  array<mixed>  $bulkActions
     */
    public function setBulkActions(array $bulkActions): self
    {
        $this->bulkActions = $bulkActions;

        return $this;
    }

    public function setBulkActionsStatus(bool $status): self
    {
        $this->bulkActionsStatus = $status;

        return $this;
    }

    public function setBulkActionsEnabled(): self
    {
        $this->setBulkActionsStatus(true);

        return $this;
    }

    public function setBulkActionsDisabled(): self
    {
        $this->setBulkActionsStatus(false);

        return $this;
    }

    public function setSelectAllStatus(bool $status): self
    {
        $this->selectAll = $status;

        return $this;
    }

    public function setSelectAllEnabled(): self
    {
        $this->setSelectAllStatus(true);

        return $this;
    }

    public function setSelectAllDisabled(): self
    {
        $this->setSelectAllStatus(false);

        return $this;
    }

    public function setHideBulkActionsWhenEmptyStatus(bool $status): self
    {
        $this->hideBulkActionsWhenEmpty = $status;

        return $this;
    }

    public function setHideBulkActionsWhenEmptyEnabled(): self
    {
        $this->setHideBulkActionsWhenEmptyStatus(true);

        return $this;
    }

    public function setHideBulkActionsWhenEmptyDisabled(): self
    {
        $this->setHideBulkActionsWhenEmptyStatus(false);

        return $this;
    }

    public function setBulkActionConfirms(array $bulkActionConfirms): self
    {
        foreach ($bulkActionConfirms as $bulkAction) {
            if (! $this->hasConfirmationMessage($bulkAction)) {
                $this->setBulkActionConfirmMessage($bulkAction, $this->getBulkActionDefaultConfirmationMessage());
            }
        }

        return $this;
    }

    public function setBulkActionConfirmMessage(string $action, string $confirmationMessage): self
    {
        $this->bulkActionConfirms[$action] = $confirmationMessage;

        return $this;
    }

    public function setBulkActionConfirmMessages(array $bulkActionMessages): self
    {
        foreach ($bulkActionMessages as $bulkAction => $confirmationMessage) {
            $this->setBulkActionConfirmMessage($bulkAction, $confirmationMessage);
        }

        return $this;
    }

    public function setBulkActionDefaultConfirmationMessage(string $defaultConfirmationMessage): self
    {
        $this->bulkActionConfirmDefaultMessage = $defaultConfirmationMessage;

        return $this;
    }

    public function setShouldAlwaysHideBulkActionsDropdownOption(bool $status = false): self
    {
        $this->alwaysHideBulkActionsDropdownOption = $status;

        return $this;
    }

    public function setShouldAlwaysHideBulkActionsDropdownOptionEnabled(): self
    {
        $this->setShouldAlwaysHideBulkActionsDropdownOption(true);

        return $this;
    }

    public function setShouldAlwaysHideBulkActionsDropdownOptionDisabled(): self
    {
        $this->setShouldAlwaysHideBulkActionsDropdownOption(false);

        return $this;
    }

    public function setClearSelectedOnSearch(bool $status): self
    {
        $this->clearSelectedOnSearch = $status;

        return $this;
    }

    public function setClearSelectedOnSearchEnabled(): self
    {
        $this->setClearSelectedOnSearch(true);

        return $this;
    }

    public function setClearSelectedOnSearchDisabled(): self
    {
        $this->setClearSelectedOnSearch(false);

        return $this;
    }

    public function setClearSelectedOnFilter(bool $status): self
    {
        $this->clearSelectedOnFilter = $status;

        return $this;
    }

    public function setClearSelectedOnFilterEnabled(): self
    {
        $this->setClearSelectedOnFilter(true);

        return $this;
    }

    public function setClearSelectedOnFilterDisabled(): self
    {
        $this->setClearSelectedOnFilter(false);

        return $this;
    }

    public function setDelaySelectAllStatus(bool $status): self
    {
        $this->delaySelectAll = $status;

        return $this;
    }

    public function setDelaySelectAllEnabled(): self
    {
        $this->setDelaySelectAllStatus(true);

        return $this;
    }

    public function setDelaySelectAllDisabled(): self
    {
        $this->setDelaySelectAllStatus(false);

        return $this;
    }

    // --- merged from BulkActionsHelpers (#28) ---

    #[Computed]
    public function showBulkActionsSections(): bool
    {
        return $this->bulkActionsAreEnabled() && $this->hasBulkActions();
    }

    public function getBulkActionsStatus(): bool
    {
        return $this->bulkActionsStatus;
    }

    public function bulkActionsAreEnabled(): bool
    {
        return $this->getBulkActionsStatus() === true;
    }

    public function bulkActionsAreDisabled(): bool
    {
        return $this->getBulkActionsStatus() === false;
    }

    public function getSelectAllStatus(): bool
    {
        return $this->selectAll;
    }

    public function selectAllIsEnabled(): bool
    {
        return $this->getSelectAllStatus() === true;
    }

    public function selectAllIsDisabled(): bool
    {
        return $this->getSelectAllStatus() === false;
    }

    public function getHideBulkActionsWhenEmptyStatus(): bool
    {
        return $this->hideBulkActionsWhenEmpty;
    }

    public function hideBulkActionsWhenEmptyIsEnabled(): bool
    {
        return $this->getHideBulkActionsWhenEmptyStatus() === true;
    }

    public function hideBulkActionsWhenEmptyIsDisabled(): bool
    {
        return $this->getHideBulkActionsWhenEmptyStatus() === false;
    }

    public function hasBulkActions(): bool
    {
        return count($this->bulkActions()) > 0;
    }

    /**
     * @return array<mixed>
     */
    public function getBulkActions(): array
    {
        return $this->bulkActions();
    }

    public function showBulkActionsDropdown(): bool
    {
        $show = false;

        if ($this->bulkActionsAreEnabled()) {
            if ($this->hasBulkActions()) {
                $show = true;
            }

            if ($this->hideBulkActionsWhenEmptyIsEnabled()) {
                if ($this->hasSelected()) {
                    $show = true;
                } else {
                    $show = false;
                }
            }
        }

        return $show;
    }

    /**
     * @param  array<mixed>  $selected
     * @return array<mixed>
     */
    public function setSelected(array $selected): array
    {
        return $this->selected = $selected;
    }

    /**
     * @return array<mixed>
     */
    public function getSelected(): array
    {
        return $this->selected;
    }

    public function hasSelected(): bool
    {
        return $this->getSelectedCount() > 0;
    }

    public function getSelectedCount(): int
    {
        return count($this->getSelected());
    }

    /**
     * Clear the bulk selected and disable select all
     */
    public function clearSelected(): void
    {
        $this->setSelectAllDisabled();
        $this->setSelected([]);
    }

    /**
     * Disable select all when the selected array is updated - if DelaySelectAll is not enabled
     */
    public function updatedSelected(): void
    {
        if (! $this->getDelaySelectAllStatus()) {
            $this->setSelectAllDisabled();
        }
    }

    /**
     * Clear or select all depending on what's selected when select all is changed
     */
    /*public function updatedSelectAll(): void
    {
        if (count($this->getSelected()) === (clone $this->baseQuery())->pluck($this->getPrimaryKey())->count()) {
            $this->clearSelected();
        } else {
            $this->setAllSelected();
        }
    }*/

    /**
     * Set select all and get all ids for selected
     */
    public function setAllSelected(): void
    {
        $this->setSelectAllEnabled();
        $this->setSelected((clone $this->baseQuery())->pluck($this->getBuilder()->getModel()->getTable().'.'.$this->getPrimaryKey())->map(fn ($item) => (string) $item)->toArray());
    }

    public function showBulkActionsDropdownAlpine(): bool
    {
        return $this->bulkActionsAreEnabled() && $this->hasBulkActions();
    }

    public function getBulkActionConfirms(): array
    {
        return array_keys($this->bulkActionConfirms);
    }

    public function hasConfirmationMessage(string $bulkAction): bool
    {
        return isset($this->bulkActionConfirms[$bulkAction]);
    }

    public function getBulkActionConfirmMessage(string $bulkAction): string
    {
        return $this->bulkActionConfirms[$bulkAction] ?? $this->getBulkActionDefaultConfirmationMessage();
    }

    public function getBulkActionDefaultConfirmationMessage(): string
    {
        return isset($this->bulkActionConfirmDefaultMessage) ? $this->bulkActionConfirmDefaultMessage : __($this->getLocalisationPath().'Bulk Actions Confirm');
    }

    #[Computed]
    public function shouldAlwaysHideBulkActionsDropdownOption(): bool
    {
        return $this->alwaysHideBulkActionsDropdownOption ?? false;
    }

    public function getClearSelectedOnSearch(): bool
    {
        return $this->clearSelectedOnSearch ?? true;
    }

    public function getClearSelectedOnFilter(): bool
    {
        return $this->clearSelectedOnFilter ?? true;
    }

    public function getSelectedRows(): array
    {
        if ($this->getDelaySelectAllStatus() && $this->selectAllIsEnabled()) {
            return (clone $this->baseQuery())->select($this->getBuilder()->getModel()->getTable().'.'.$this->getPrimaryKey())->pluck($this->getBuilder()->getModel()->getTable().'.'.$this->getPrimaryKey())->map(fn ($item) => $item)->toArray();
        } else {
            return $this->selected;
        }
    }

    public function getDelaySelectAllStatus(): bool
    {
        return $this->delaySelectAll ?? false;
    }

    public function getBulkActionsColumn(): Column
    {
        return Column::make('bulkactions')->label(fn () => null);
    }

    // --- merged from HasBulkActionsStyling (#28) ---

    protected array $bulkActionsCheckboxAttributes = [];

    protected array $bulkActionsThAttributes = ['default' => null, 'default-colors' => null, 'default-styling' => null];

    protected array $bulkActionsThCheckboxAttributes = ['default' => null, 'default-colors' => null, 'default-styling' => null];

    protected array $bulkActionsTdAttributes = ['default' => null, 'default-colors' => null, 'default-styling' => null];

    protected array $bulkActionsTdCheckboxAttributes = ['default' => null, 'default-colors' => null, 'default-styling' => null];

    protected array $bulkActionsButtonAttributes = ['default-colors' => true, 'default-styling' => true];

    protected array $bulkActionsMenuAttributes = ['default-colors' => true, 'default-styling' => true];

    protected array $bulkActionsMenuItemAttributes = ['default-colors' => true, 'default-styling' => true];

    protected array $bulkActionsRowButtonAttributes = ['default-colors' => true, 'default-styling' => true];

    /**
     * Used to get attributes for the Bulk Actions Button
     *
     * @return array<mixed>
     */
    #[Computed]
    public function getBulkActionsButtonAttributes(): array
    {
        return $this->getCustomAttributes('bulkActionsButtonAttributes', true);

    }

    /**
     * Used to get attributes for the Bulk Actions Menu (Dropdown)
     *
     * @return array<mixed>
     */
    #[Computed]
    public function getBulkActionsMenuAttributes(): array
    {
        return $this->getCustomAttributes('bulkActionsMenuAttributes', true, false);

    }

    /**
     * Used to get attributes for the items in the Bulk Actions Menu (Dropdown)
     *
     * @return array<mixed>
     */
    #[Computed]
    public function getBulkActionsMenuItemAttributes(): array
    {
        return $this->getCustomAttributes('bulkActionsMenuItemAttributes', true, false);

    }

    /**
     * Used to get attributes for the <th> for Bulk Actions
     *
     * @return array<mixed>
     */
    #[Computed]
    public function getBulkActionsThAttributes(): array
    {
        return $this->getCustomAttributesNew('bulkActionsThAttributes', true, true);

    }

    /**
     * Used to check if the Bulk Actions TH has any attributes (supports historic approach)
     */
    #[Computed]
    public function hasBulkActionsThAttributes(): bool
    {
        return $this->getBulkActionsThAttributes() != ['default' => true, 'default-colors' => true, 'default-styling' => true];
    }

    /**
     * Used to get attributes for the Checkbox for Bulk Actions TH
     *
     * @return array<mixed>
     */
    public function getBulkActionsThCheckboxAttributes(): array
    {
        return $this->getCustomAttributesNew('bulkActionsThCheckboxAttributes', true, true);

    }

    /**
     * Used to get attributes for the Bulk Actions TD
     *
     * @return array<mixed>
     */
    #[Computed]
    public function getBulkActionsTdAttributes(): array
    {
        return $this->getCustomAttributesNew('bulkActionsTdAttributes', true, true);
    }

    /**
     * Used to get attributes for the Bulk Actions TD
     *
     * @return array<mixed>
     */
    #[Computed]
    public function getBulkActionsTdCheckboxAttributes(): array
    {
        return array_merge(
            [
                'x-show' => '!currentlyReorderingStatus',
                'x-model' => 'selectedItems',
                'wire:loading.attr.delay' => 'disabled',
                'type' => 'checkbox',
            ],
            $this->getCustomAttributesNew('bulkActionsTdCheckboxAttributes', true, true)
        );
    }

    /**
     * Used to get attributes for the Bulk Actions Row Buttons
     *
     * @return array<mixed>
     */
    #[Computed]
    public function getBulkActionsRowButtonAttributes(): array
    {
        return $this->getCustomAttributes('bulkActionsRowButtonAttributes', true);

    }

    #[Computed]
    public function getBulkActionsRowButtonAttributesBag(): ComponentAttributeBag
    {
        return $this->getCustomAttributesBagFromArray($this->getBulkActionsRowButtonAttributes());
    }

    /**
     * Used to set attributes for the Bulk Actions Menu Button
     */
    public function setBulkActionsButtonAttributes(array $bulkActionsButtonAttributes): self
    {
        return $this->setCustomAttributes('bulkActionsButtonAttributes', $bulkActionsButtonAttributes);
    }

    /**
     * Used to set attributes for the Bulk Actions Menu
     */
    public function setBulkActionsMenuAttributes(array $bulkActionsMenuAttributes): self
    {
        return $this->setCustomAttributes('bulkActionsMenuAttributes', $bulkActionsMenuAttributes);
    }

    /**
     * Used to set attributes for the Bulk Actions Menu Items
     */
    public function setBulkActionsMenuItemAttributes(array $bulkActionsMenuItemAttributes): self
    {
        return $this->setCustomAttributes('bulkActionsMenuItemAttributes', $bulkActionsMenuItemAttributes);
    }

    /**
     * Used to set attributes for the Bulk Actions TD in the Row
     */
    public function setBulkActionsTdAttributes(array $bulkActionsTdAttributes): self
    {
        return $this->setCustomAttributesDefaults('bulkActionsTdAttributes', $bulkActionsTdAttributes);

    }

    /**
     * Used to set attributes for the Bulk Actions Checkbox in the Row
     */
    public function setBulkActionsTdCheckboxAttributes(array $bulkActionsTdCheckboxAttributes): self
    {
        return $this->setCustomAttributesDefaults('bulkActionsTdCheckboxAttributes', $bulkActionsTdCheckboxAttributes);
    }

    /**
     * Used to set attributes for the <th> for Bulk Actions
     */
    public function setBulkActionsThAttributes(array $bulkActionsThAttributes): self
    {
        return $this->setCustomAttributesDefaults('bulkActionsThAttributes', $bulkActionsThAttributes);
    }

    /**
     * Used to set attributes for the Bulk Actions Checkbox in the <th>
     */
    public function setBulkActionsThCheckboxAttributes(array $bulkActionsThCheckboxAttributes): self
    {
        return $this->setCustomAttributesDefaults('bulkActionsThCheckboxAttributes', $bulkActionsThCheckboxAttributes);
    }

    /**
     * Used to set attributes for the Bulk Actions Row Buttons
     */
    public function setBulkActionsRowButtonAttributes(array $bulkActionsRowButtonAttributes): self
    {
        return $this->setCustomAttributes('bulkActionsRowButtonAttributes', $bulkActionsRowButtonAttributes);
    }
}
