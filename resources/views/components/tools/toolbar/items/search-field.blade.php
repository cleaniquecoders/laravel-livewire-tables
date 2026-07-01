@aware(['isTailwind', 'isBootstrap'])

@if ($this->isFlux())
    <flux:input
        wire:model{{ $this->getSearchOptions() }}="search"
        :placeholder="$this->getSearchPlaceholder()"
        icon="magnifying-glass"
        type="search"
        class="w-full md:w-72"
    />
@else
<div
    @class([
        $this->themeClasses('searchfield.wrapper') => true,
        'flex' => ($isTailwind && !$this->hasSearchIcon),
        'relative inline-flex flex-row' => $this->hasSearchIcon,
    ])>

        @if($this->hasSearchIcon)
            <x-livewire-tables::tools.toolbar.items.search.icon :searchIcon="$this->getSearchIcon" :searchIconClasses="$this->getSearchIconClasses" :searchIconOtherAttributes="$this->getSearchIconOtherAttributes"  />
        @endif

        <x-livewire-tables::tools.toolbar.items.search.input />

        @if ($this->hasSearch)
            <x-livewire-tables::tools.toolbar.items.search.remove />
        @endif
</div>
@endif
