@aware([ 'tableName'])
@props(['filter', 'filterLayout' => 'popover', 'tableName' => 'table', 'isTailwind' => false, 'isBootstrap' => false, 'isBootstrap4' => false, 'isBootstrap5' => false, 'for' => null])

@php
    $filterLabelAttributes = $filter->getFilterLabelAttributes();
    $customLabelAttributes = $filter->getLabelAttributes();
    $lwtTheme = lwtThemeName($isFlux ?? false, $isBootstrap4 ?? false, $isBootstrap5 ?? false);
@endphp

@if($filter->hasCustomFilterLabel() && !$filter->hasCustomPosition())
    @include($filter->getCustomFilterLabel(),['filter' => $filter, 'filterLayout' => $filterLayout, 'tableName' => $tableName, 'isTailwind' => $isTailwind, 'isBootstrap' => $isBootstrap, 'isBootstrap4' => $isBootstrap4, 'isBootstrap5' => $isBootstrap5, 'customLabelAttributes' => $customLabelAttributes])
@elseif(!$filter->hasCustomPosition())
    <label for="{{ $for ?? $tableName.'-filter-'.$filter->getKey() }}" {{
            $attributes->merge($customLabelAttributes)->merge($filterLabelAttributes)
                ->class([
                    lwtThemeClasses($lwtTheme,'filterlabel.styling') => $isTailwind && ($filterLabelAttributes['default-styling'] ?? ($filterLabelAttributes['default'] ?? true)),
                    lwtThemeClasses($lwtTheme,'filterlabel.colors') => $isTailwind && ($filterLabelAttributes['default-colors'] ?? ($filterLabelAttributes['default'] ?? true)),
                    lwtThemeClasses($lwtTheme,'filterlabel.slidedown') => $isBootstrap && $filterLayout === 'slide-down' && ($filterLabelAttributes['default-styling'] ?? ($filterLabelAttributes['default'] ?? true)),
                    lwtThemeClasses($lwtTheme,'filterlabel.popover') => $isBootstrap && $filterLayout === 'popover' && ($filterLabelAttributes['default-styling'] ?? ($filterLabelAttributes['default'] ?? true)),
                ])
                ->except(['default', 'default-colors', 'default-styling'])
        }}
    >
        {{ $filter->getName() }}
    </label>
@endif
