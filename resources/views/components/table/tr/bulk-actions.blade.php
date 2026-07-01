@aware([ 'tableName', 'isTailwind', 'isBootstrap', 'localisationPath'])

@if ($this->bulkActionsAreEnabled() && $this->hasBulkActions())
    @php
        $colspan = $this->getColspanCount();
        $selectAll = $this->selectAllIsEnabled();
        $simplePagination = $this->isPaginationMethod('simple');
    @endphp

    <x-livewire-tables::table.tr.plain
        x-cloak x-show="selectedItems.length > 0 && !currentlyReorderingStatus"
        wire:key="{{ $tableName }}-bulk-select-message"
        @class([$this->themeClasses('tr.bulkactions.row')])
    >
        <x-livewire-tables::table.td.plain :colspan="$colspan">
            <template x-if="selectedItems.length == paginationTotalItemCount || selectAllStatus">
                <div wire:key="{{ $tableName }}-all-selected">
                    <span>
                        {{ __($localisationPath.'You are currently selecting all') }}
                        @if(!$simplePagination) <strong><span x-text="paginationTotalItemCount"></span></strong> @endif
                        {{ __($localisationPath.'rows') }}.
                    </span>

                    <button
                        x-on:click="clearSelected"
                        wire:loading.attr="disabled"
                        type="button"
                        {{ 
                            $this->getBulkActionsRowButtonAttributesBag->class([
                                $this->themeClasses('tr.bulkactions.btn.styling') => $this->getBulkActionsRowButtonAttributes['default-styling'] ?? true,
                                $this->themeClasses('tr.bulkactions.btn.colors') => $this->getBulkActionsRowButtonAttributes['default-colors'] ?? true,
                            ])
                        }}
                    >
                        {{ __($localisationPath.'Deselect All') }}
                    </button>
                </div>
            </template>

            <template x-if="selectedItems.length !== paginationTotalItemCount && !selectAllStatus">
                <div wire:key="{{ $tableName }}-some-selected">
                    <span>
                        {{ __($localisationPath.'You have selected') }}
                        <strong><span x-text="selectedItems.length"></span></strong>
                        {{ __($localisationPath.'rows, do you want to select all') }}
                        @if(!$simplePagination) <strong><span x-text="paginationTotalItemCount"></span></strong> @endif
                    </span>

                    <button
                        x-on:click="selectAllOnPage()"
                        wire:loading.attr="disabled"
                        type="button"
                        {{ 
                            $this->getBulkActionsRowButtonAttributesBag->class([
                                $this->themeClasses('tr.bulkactions.btn.styling') => $this->getBulkActionsRowButtonAttributes['default-styling'] ?? true,
                                $this->themeClasses('tr.bulkactions.btn.colors') => $this->getBulkActionsRowButtonAttributes['default-colors'] ?? true,
                            ])
                        }}

                    >{{ __($localisationPath.'Select All On Page') }}
                    </button>&nbsp;

                    <button
                        x-on:click="setAllSelected()"
                        wire:loading.attr="disabled"
                        type="button"
                        {{ 
                            $this->getBulkActionsRowButtonAttributesBag->class([
                                $this->themeClasses('tr.bulkactions.btn.styling') => $this->getBulkActionsRowButtonAttributes['default-styling'] ?? true,
                                $this->themeClasses('tr.bulkactions.btn.colors') => $this->getBulkActionsRowButtonAttributes['default-colors'] ?? true,
                            ])
                        }}
                    >
                        {{ __($localisationPath.'Select All') }}
                    </button>

                    <button
                        x-on:click="clearSelected"
                        wire:loading.attr="disabled"
                        type="button"
                        {{ 
                            $this->getBulkActionsRowButtonAttributesBag->class([
                                $this->themeClasses('tr.bulkactions.btn.styling') => $this->getBulkActionsRowButtonAttributes['default-styling'] ?? true,
                                $this->themeClasses('tr.bulkactions.btn.colors') => $this->getBulkActionsRowButtonAttributes['default-colors'] ?? true,
                            ])
                        }}
                    >
                        {{ __($localisationPath.'Deselect All') }}
                    </button>
                </div>
            </template>
        </x-livewire-tables::table.td.plain>
    </x-livewire-tables::table.tr.plain>
@endif
