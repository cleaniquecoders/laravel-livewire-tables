@php
    $filterKey = $filter->getKey();
@endphp

<div x-cloak id="{{ $tableName }}-dateRangeFilter-{{ $filterKey }}" x-data="flatpickrFilter($wire, '{{ $filterKey }}', @js($filter->getConfigs()), $refs.dateRangeInput, '{{ App::currentLocale() }}')" >
    <x-livewire-tables::tools.filter-label :$filter :$filterLayout :$tableName :$isTailwind :$isBootstrap4 :$isBootstrap5 :$isBootstrap />
    <div
        @class([$this->themeClasses('filter.daterange.wrapper')])
    >
        <input
            type="text"
            x-ref="dateRangeInput"
            x-on:click="init"
            x-on:change="changedValue($refs.dateRangeInput.value)"
            value="{{ $filter->getDateString(isset($this->appliedFilters[$filterKey]) ? $this->appliedFilters[$filterKey] : '') }}"
            wire:key="{{ $filter->generateWireKey($tableName, 'dateRange') }}"
            id="{{ $tableName }}-filter-dateRange-{{ $filterKey }}"
            @class([$this->themeClasses('filter.daterange.input')])
            @if($filter->hasConfig('placeholder')) placeholder="{{ $filter->getConfig('placeholder') }}" @endif
        />
    </div>
</div>
