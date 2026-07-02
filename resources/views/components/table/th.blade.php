@aware(['isTailwind','isBootstrap'])
@props(['column', 'index'])

@php
    $allThAttributes = $this->getAllThAttributes($column);
    $customThAttributes = $allThAttributes['customAttributes'];
    $customSortButtonAttributes = $allThAttributes['sortButtonAttributes'];
    $customLabelAttributes = $allThAttributes['labelAttributes'];
    $customIconAttributes = $this->getThSortIconAttributes($column);
    $direction = $column->hasField() ? $this->getSort($column->getColumnSelectName()) : $this->getSort($column->getSlug()) ?? null;
    $isSortableHeader = $this->sortingIsEnabled() && ($column->isSortable() || $column->getSortCallback());
    $ariaSort = $isSortableHeader
        ? match ($direction) {
            'asc' => 'ascending',
            'desc' => 'descending',
            default => 'none',
        }
        : null;
@endphp

@if ($this->useFluxTable())
    @if ($isSortableHeader)
        <flux:table.column sortable :sorted="! is_null($direction)" :direction="$direction ?? 'asc'" wire:click="sortBy('{{ $column->getColumnSortKey() }}')">{{ $column->getTitle() }}</flux:table.column>
    @else
        <flux:table.column>{{ $column->getTitle() }}</flux:table.column>
    @endif
@else
<th scope="col" @if($ariaSort) aria-sort="{{ $ariaSort }}" @endif @if($clientSideXShow = $this->getClientSideVisibilityXShow($column))x-cloak x-show="{{ $clientSideXShow }}" @endif{{
    $attributes->merge($customThAttributes)
        ->class([
            $this->themeClasses('th.colors') => $isTailwind && (($customThAttributes['default-colors'] ?? true) || ($customThAttributes['default'] ?? true)),
            $this->themeClasses('th.styling') => $isTailwind && (($customThAttributes['default-styling'] ?? true) || ($customThAttributes['default'] ?? true)),
            $this->themeClasses('td.collapse.always') => $column->shouldCollapseAlways(),
            $this->themeClasses('td.collapse.mobile') => $column->shouldCollapseOnMobile(),
            $this->themeClasses('td.collapse.tablet') => $column->shouldCollapseOnTablet(),
        ])
        ->except(['default', 'default-colors', 'default-styling'])
}}>
    @if($column->getColumnLabelStatus())
        @unless ($this->sortingIsEnabled() && ($column->isSortable() || $column->getSortCallback()))
            <x-livewire-tables::table.th.label :$customLabelAttributes :columnTitle="$column->getTitle()" />
        @else
            @if ($isTailwind)

                <button wire:click="sortBy('{{ $column->getColumnSortKey() }}')" {{
                        $attributes->merge($customSortButtonAttributes)
                            ->class([
                                'text-gray-500 dark:text-gray-400' => (($customSortButtonAttributes['default-colors'] ?? true) || ($customSortButtonAttributes['default'] ?? true)),
                                'flex items-center space-x-1 text-left text-xs leading-4 font-medium uppercase tracking-wider group focus:outline-none' => (($customSortButtonAttributes['default-styling'] ?? true) || ($customSortButtonAttributes['default'] ?? true)),
                            ])
                            ->except(['default', 'default-colors', 'default-styling', 'wire:key'])
                }}>
                    <x-livewire-tables::table.th.label :$customLabelAttributes :columnTitle="$column->getTitle()" />
                    <x-livewire-tables::table.th.sort-icons :$direction :$customIconAttributes />
                </button>
            @elseif ($isBootstrap)
                <div wire:click="sortBy('{{ $column->getColumnSortKey() }}')" {{
                        $attributes->merge($customSortButtonAttributes)
                            ->class([
                                'd-flex align-items-center laravel-livewire-tables-cursor' => (($customSortButtonAttributes['default-styling'] ?? true) || ($customSortButtonAttributes['default'] ?? true))
                            ])
                            ->except(['default', 'default-colors', 'default-styling', 'wire:key'])
                }}>
                    <x-livewire-tables::table.th.label :$customLabelAttributes :columnTitle="$column->getTitle()" />
                    <x-livewire-tables::table.th.sort-icons :$direction :$customIconAttributes />

                </div>
            @endif

        @endunless
    @endif
</th>
@endif
