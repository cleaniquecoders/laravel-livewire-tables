@php
    $customThAttributes = $this->hasReorderThAttributes() ? $this->getReorderThAttributes() : $this->getAllThAttributes($this->getReorderColumn())['customAttributes'];
@endphp

<x-livewire-tables::table.th.plain x-cloak x-show="currentlyReorderingStatus" wire:key="{{ $this->getTableName }}-thead-reorder" :displayMinimisedOnReorder="false" 
    {{ 
        $attributes->merge($customThAttributes)
            ->class([
                $this->themeClasses('th.reorder.styling') => ($customThAttributes['default-styling'] ?? true) || ($customThAttributes['default'] ?? true),
                $this->themeClasses('th.reorder.colors') => ($customThAttributes['default-colors'] ?? true) || ($customThAttributes['default'] ?? true),
                $this->themeClasses('th.reorder.bs') => $customThAttributes['default'] ?? true,
            ])
            ->except(['default','default-styling','default-colors'])
    }}
>
    <div x-cloak x-show="currentlyReorderingStatus"></div>
</x-livewire-tables::table.th.plain>

