@php($lwtTheme = lwtThemeName($isFlux ?? false, $isBootstrap4 ?? false, $isBootstrap5 ?? false))
@aware(['tableName','isTailwind','isBootstrap4','isBootstrap5'])

<div x-data="filterPillsHandler(@js($setupData))" x-bind="trigger" 
    wire:key="{{ $tableName }}-filter-pill-{{ $filterKey }}" {{
    $attributes->merge($filterPillsItemAttributes)
    ->class([
        lwtThemeClasses($lwtTheme,'pills.item.styling') => $filterPillsItemAttributes['default-styling'] ?? true,
        lwtThemeClasses($lwtTheme,'pills.item.text') => $isTailwind && ($filterPillsItemAttributes['default-text'] ?? ($filterPillsItemAttributes['default-styling'] ?? true)),
        lwtThemeClasses($lwtTheme,'pills.item.colors') => $isTailwind && ($filterPillsItemAttributes['default-colors'] ?? true),
    ])
    ->except(['default', 'default-styling', 'default-colors'])
}}
>
<span {{ $attributes->merge($pillTitleDisplayDataArray) }}></span>:&nbsp;
<span {{ $attributes->merge($pillDisplayDataArray) }}></span>

<x-livewire-tables::tools.filter-pills.buttons.reset-filter :$filterKey :$filterPillData/>

</div>
