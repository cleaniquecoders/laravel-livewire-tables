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
<td wire:key="{{ $tableName . '-table-td-'.$row->{$primaryKey}.'-'.$column->getSlug() }}"
    @if ($rowUrl)
        @if($this->getTableRowUrlTarget($row) === 'navigate') wire:navigate href="{{ $rowUrl }}"
        @else onclick="window.open('{{ $rowUrl }}', '{{ $this->getTableRowUrlTarget($row) ?? '_self' }}')"
        @endif
    @endif
        {{
            $attributes->merge($customAttributes)
                ->class([
                    'px-6 py-4 whitespace-nowrap text-sm font-medium dark:text-white' => $isTailwind && ($customAttributes['default'] ?? true),
                    'hidden' =>  $isTailwind && $column && $column->shouldCollapseAlways(),
                    'hidden md:table-cell' => $isTailwind && $column && $column->shouldCollapseOnMobile(),
                    'hidden lg:table-cell' => $isTailwind && $column && $column->shouldCollapseOnTablet(),
                    '' => $isBootstrap && ($customAttributes['default'] ?? true),
                    'd-none' => $isBootstrap && $column && $column->shouldCollapseAlways(),
                    'd-none d-md-table-cell' => $isBootstrap && $column && $column->shouldCollapseOnMobile(),
                    'd-none d-lg-table-cell' => $isBootstrap && $column && $column->shouldCollapseOnTablet(),
                    'laravel-livewire-tables-cursor' => $isBootstrap && $rowUrl,
                ])
                ->except(['default','default-styling','default-colors'])
        }}
    >
        {{ $slot }}
</td>
@endif
