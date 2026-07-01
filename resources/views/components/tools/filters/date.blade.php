<div>
    <x-livewire-tables::tools.filter-label :$filter :$filterLayout :$tableName :$isTailwind :$isBootstrap4 :$isBootstrap5 :$isBootstrap />
    @if ($isFlux ?? false)
        <flux:input type="date" wire:model.live="filterComponents.{{ $filter->getKey() }}" class="w-full" />
    @else
    <div @class([$this->themeClasses('filter.input.wrapper')])>
        <input {!! $filter->getWireMethod('filterComponents.'.$filter->getKey()) !!} {{
                $filterInputAttributes->merge()
                ->class([
                    $this->themeClasses('filter.input.styling') => $isTailwind && ($filterInputAttributes['default-styling'] ?? true),
                    $this->themeClasses('filter.input.colors') => $isTailwind && ($filterInputAttributes['default-colors'] ?? true),
                    $this->themeClasses('filter.input.bs') => $isBootstrap,
                ])
                ->except(['default-styling','default-colors'])
            }} />
    </div>
    @endif
</div>
