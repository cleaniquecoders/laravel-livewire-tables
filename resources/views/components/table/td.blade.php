@aware([ 'row', 'rowIndex', 'tableName', 'primaryKey','isTailwind','isBootstrap'])
@props(['column', 'colIndex'])

@php
    $customAttributes = $this->getTdAttributes($column, $row, $colIndex, $rowIndex);
    // Resolve the row URL per row so a callback returning null skips the link
    // (and the pointer cursor) for that specific row.
    $rowUrl = $column->isClickable() ? $this->getTableRowUrl($row) : null;
@endphp

@if ($this->useFluxTable())
    <flux:table.cell>{{ $slot }}</flux:table.cell>
@else
<td wire:key="{{ $tableName . '-table-td-'.$row->{$primaryKey}.'-'.$column->getSlug() }}"@if($clientSideXShow = $this->getClientSideVisibilityXShow($column)) x-cloak x-show="{{ $clientSideXShow }}"@endif

    @if ($rowUrl)
        @if($this->getTableRowUrlTarget($row) === 'navigate') wire:navigate href="{{ $rowUrl }}"
        @else onclick="window.open('{{ $rowUrl }}', '{{ $this->getTableRowUrlTarget($row) ?? '_self' }}')"
        @endif
    @endif
        {{
            $attributes->merge($customAttributes)
                ->class([
                    $this->themeClasses('td.base') => ($customAttributes['default'] ?? true),
                    $this->themeClasses('td.collapse.always') => $column && $column->shouldCollapseAlways(),
                    $this->themeClasses('td.collapse.mobile') => $column && $column->shouldCollapseOnMobile(),
                    $this->themeClasses('td.collapse.tablet') => $column && $column->shouldCollapseOnTablet(),
                    $this->themeClasses('td.cursor') => $rowUrl,
                ])
                ->except(['default','default-styling','default-colors'])
        }}
    >
        {{ $slot }}
</td>
@endif
