@aware(['tableName','isTailwind', 'isBootstrap'])
@php
    $customAttributes = $this->hasBulkActionsThAttributes ? $this->getBulkActionsThAttributes : $this->getAllThAttributes($this->getBulkActionsColumn())['customAttributes'];
    $bulkActionsThCheckboxAttributes = $this->getBulkActionsThCheckboxAttributes();
@endphp

@if ($this->bulkActionsAreEnabled() && $this->hasBulkActions())
    <x-livewire-tables::table.th.plain  :displayMinimisedOnReorder="true" wire:key="{{ $tableName }}-thead-bulk-actions" :$customAttributes>
        <div
            x-data="{newSelectCount: 0, indeterminateCheckbox: false, bulkActionHeaderChecked: false}"
            x-init="$watch('selectedItems', value => indeterminateCheckbox = (value.length > 0 && value.length < paginationTotalItemCount))"
            x-cloak x-show="currentlyReorderingStatus !== true"
            @class([$this->themeClasses('th.bulkactions.wrapper')])
        >
            <input
                x-init="$watch('indeterminateCheckbox', value => $el.indeterminate = value); $watch('selectedItems', value => newSelectCount = value.length);"
                x-on:click="if(selectedItems.length == paginationTotalItemCount) { $el.indeterminate = false; $wire.clearSelected(); bulkActionHeaderChecked = false; } else { bulkActionHeaderChecked = true; $el.indeterminate = false; $wire.setAllSelected(); }"
                type="checkbox"
                :checked="selectedItems.length == paginationTotalItemCount"
                {{
                    $attributes->merge($bulkActionsThCheckboxAttributes)->class([
                        $this->themeClasses('th.bulkactions.checkbox.colors') => ($bulkActionsThCheckboxAttributes['default'] ?? true) || ($bulkActionsThCheckboxAttributes['default-colors'] ?? true),
                        $this->themeClasses('th.bulkactions.checkbox.styling') => ($bulkActionsThCheckboxAttributes['default'] ?? true) || ($bulkActionsThCheckboxAttributes['default-styling'] ?? true),
                        $this->themeClasses('th.bulkactions.checkbox.bs') => $bulkActionsThCheckboxAttributes['default'] ?? true,
                    ])->except(['default','default-styling','default-colors'])
                }}
            />
        </div>
    </x-livewire-tables::table.th.plain>
@endif