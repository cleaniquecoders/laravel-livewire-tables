<div>
    @php($lwtTheme = lwtThemeName($isFlux ?? false, $isBootstrap4 ?? false, $isBootstrap5 ?? false))
    <x-livewire-tables::tools.filter-label :$filter :$filterLayout :$tableName :$isTailwind :$isBootstrap4 :$isBootstrap5 :$isBootstrap />

    @if ($isFlux ?? false)
        <flux:checkbox.group wire:model.live="filterComponents.{{ $filter->getKey() }}" class="space-y-1.5">
            @foreach($filter->getOptions() as $key => $value)
                <flux:checkbox value="{{ $key }}" label="{{ $value }}" />
            @endforeach
        </flux:checkbox.group>
    @else
    @if ($isTailwind)
    <div class="rounded-md shadow-sm">
    @endif
        <div @class([lwtThemeClasses($lwtTheme,'filter.multiselect.checkwrapper')])>
            <input id="{{ $tableName }}-filter-{{ $filter->getKey() }}-select-all{{ $filter->hasCustomPosition() ? '-'.$filter->getCustomPosition() : null }}" wire:input="selectAllFilterOptions('{{ $filter->getKey() }}')" {{ 
                    $filterInputAttributes->merge([
                        'type' => 'checkbox'
                    ])
                    ->class([
                        lwtThemeClasses($lwtTheme,'filter.multiselect.check.styling') => $filterInputAttributes['default-styling'] ?? true,
                        lwtThemeClasses($lwtTheme,'filter.multiselect.check.colors') => $isTailwind && ($filterInputAttributes['default-colors'] ?? true),
                    ])
                    ->except(['id','wire:key','value','default-styling','default-colors']) 
                }}>
            <label for="{{ $tableName }}-filter-{{ $filter->getKey() }}-select-all{{ $filter->hasCustomPosition() ? '-'.$filter->getCustomPosition() : null }}" @class([lwtThemeClasses($lwtTheme,'filter.multiselect.label')])>
                @if ($filter->getFirstOption() !== '')
                    {{ $filter->getFirstOption() }}
                @else
                    {{ __($localisationPath.'All') }}
                @endif
            </label>
        </div>

        @foreach($filter->getOptions() as $key => $value)
            <div @class([lwtThemeClasses($lwtTheme,'filter.multiselect.checkwrapper')]) wire:key="{{ $tableName }}-filter-{{ $filter->getKey() }}-multiselect-{{ $key }}{{ $filter->hasCustomPosition() ? '-'.$filter->getCustomPosition() : null }}">
                <input {!! $filter->getWireMethod('filterComponents.'.$filter->getKey()) !!} 
                id="{{ $tableName }}-filter-{{ $filter->getKey() }}-{{ $loop->index }}{{ $filter->hasCustomPosition() ? '-'.$filter->getCustomPosition() : null }}" 
                
                wire:key="{{ $tableName }}-filter-{{ $filter->getKey() }}-{{ $loop->index }}{{ $filter->hasCustomPosition() ? '-'.$filter->getCustomPosition() : null }}" value="{{ $key }}" {{ 
                    $filterInputAttributes->merge([
                        'type' => 'checkbox'
                    ])
                    ->class([
                        lwtThemeClasses($lwtTheme,'filter.multiselect.check.styling') => $filterInputAttributes['default-styling'] ?? true,
                        lwtThemeClasses($lwtTheme,'filter.multiselect.check.colors') => $isTailwind && ($filterInputAttributes['default-colors'] ?? true),
                    ])
                    ->except(['id','wire:key','value','default-styling','default-colors']) 
                }}>
                <label for="{{ $tableName }}-filter-{{ $filter->getKey() }}-{{ $loop->index }}{{ $filter->hasCustomPosition() ? '-'.$filter->getCustomPosition() : null }}" @class([lwtThemeClasses($lwtTheme,'filter.multiselect.label')])>{{ $value }}</label>
            </div>
        @endforeach
    @if ($isTailwind)
    </div>
    @endif
    @endif
</div>
