@aware(['tableName','isTailwind','isBootstrap4','isBootstrap5'])
@props([
    'filterKey', 
    'filterPillData', 
    'shouldWatch' => ($filterPillData->shouldWatchForEvents() ?? 0),
    'filterPillsItemAttributes' => $filterPillData->getFilterPillsItemAttributes(),
    ])

@if ($this->isFlux())
    <div
        x-data="filterPillsHandler(@js($filterPillData->getPillSetupData($filterKey,$shouldWatch)))"
        x-bind="trigger"
        wire:key="{{ $tableName }}-filter-pill-{{ $filterKey }}"
        class="inline-flex"
    >
        <flux:badge color="zinc" size="sm" variant="pill">
            <span x-text="localFilterTitle + ':&nbsp;'"></span>
            <span {{ $filterPillData->getFilterPillDisplayData() }}></span>
            <x-livewire-tables::tools.filter-pills.buttons.reset-filter :$filterKey :$filterPillData/>
        </flux:badge>
    </div>
@else
<div x-data="filterPillsHandler(@js($filterPillData->getPillSetupData($filterKey,$shouldWatch)))" x-bind="trigger"
        wire:key="{{ $tableName }}-filter-pill-{{ $filterKey }}" {{
        $attributes->merge($filterPillsItemAttributes)
        ->class([
            $this->themeClasses('pills.item.styling') => $filterPillsItemAttributes['default-styling'] ?? true,
            $this->themeClasses('pills.item.text') => $isTailwind && ($filterPillsItemAttributes['default-text'] ?? ($filterPillsItemAttributes['default-styling'] ?? true)),
            $this->themeClasses('pills.item.colors') => $isTailwind && ($filterPillsItemAttributes['default-colors'] ?? true),
        ])
        ->except(['default', 'default-styling', 'default-colors'])
    }}
>
    <span x-text="localFilterTitle + ':&nbsp;'"></span>

    <span {{ $filterPillData->getFilterPillDisplayData() }}></span>

    <x-livewire-tables::tools.filter-pills.buttons.reset-filter :$filterKey :$filterPillData/>

</div>
@endif
