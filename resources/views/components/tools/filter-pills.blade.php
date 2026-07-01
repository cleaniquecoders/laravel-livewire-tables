@aware([ 'tableName','isTailwind','isBootstrap','isBootstrap4','isBootstrap5', 'localisationPath'])

<div {{ $attributes->merge([

    'wire:loading.class' => $this->displayFilterPillsWhileLoading ? '' : 'invisible',
    'x-cloak',
])
->class([$this->themeClasses('filterpills.wrapper') => true])

}}>
    <small @class([$this->themeClasses('filterpills.small')])>
        {{ __($localisationPath.'Applied Filters') }}:
    </small>
    @tableloop($this->getPillDataForFilter() as $filterKey => $filterPillData)

        @if ($filterPillData->hasCustomPillBlade)
            @include($filterPillData->getCustomPillBlade(), ['filter' => $this->getFilterByKey($filterKey), 'filterPillData' => $filterPillData])
        @else
            <x-livewire-tables::filter-pill :$filterKey :$filterPillData />
        @endif
    @endtableloop

    <x-livewire-tables::tools.filter-pills.buttons.reset-all />
</div>