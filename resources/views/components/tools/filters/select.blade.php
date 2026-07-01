<div>
    <x-livewire-tables::tools.filter-label :$filter :$filterLayout :$tableName :$isTailwind :$isBootstrap4 :$isBootstrap5 :$isBootstrap />

    @if ($isFlux ?? false)
        <flux:select wire:model.live="filterComponents.{{ $filter->getKey() }}" class="w-full">
            @foreach($filter->getOptions() as $key => $value)
                @if (is_iterable($value))
                    @foreach ($value as $optionKey => $optionValue)
                        <flux:select.option :value="$optionKey">{{ $optionValue }}</flux:select.option>
                    @endforeach
                @else
                    <flux:select.option :value="$key">{{ $value }}</flux:select.option>
                @endif
            @endforeach
        </flux:select>
    @else
    <div @class([$this->themeClasses('filter.select.wrapper')])>
        <select {!! $filter->getWireMethod('filterComponents.'.$filter->getKey()) !!} {{ 
                $filterInputAttributes->merge()
                ->class([
                    $this->themeClasses('filter.select.styling') => $filterInputAttributes['default-styling'] ?? true,
                    $this->themeClasses('filter.input.colors') => $isTailwind && ($filterInputAttributes['default-colors'] ?? true),
                ])
                ->except(['default-styling','default-colors']) 
            }}>
            @foreach($filter->getOptions() as $key => $value)
                @if (is_iterable($value))
                    <optgroup label="{{ $key }}">
                        @foreach ($value as $optionKey => $optionValue)
                            <option value="{{ $optionKey }}">{{ $optionValue }}</option>
                        @endforeach
                    </optgroup>
                @else
                    <option value="{{ $key }}">{{ $value }}</option>
                @endif
            @endforeach
        </select>
    </div>
    @endif
</div>
