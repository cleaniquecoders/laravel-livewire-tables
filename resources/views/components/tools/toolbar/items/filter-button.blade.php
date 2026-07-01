@aware([ 'tableName','isTailwind','isBootstrap','isBootstrap4','isBootstrap5', 'localisationPath'])
@props([])

<div 
                @class([
                    'ml-0 ml-md-2 mb-3 mb-md-0' => $isBootstrap4,
                    'ms-0 ms-md-2 mb-3 mb-md-0' => $isBootstrap5 && $this->searchIsEnabled(),
                    'mb-3 mb-md-0' => $isBootstrap5 && !$this->searchIsEnabled(),
                ])
>
    <div
        @if ($this->isFilterLayoutPopover())
            x-data="{ filterPopoverOpen: false }"
            x-on:keydown.escape.stop="if (!this.childElementOpen) { filterPopoverOpen = false }"
            x-on:mousedown.away="if (!this.childElementOpen) { filterPopoverOpen = false }"
        @endif
        @class([$this->themeClasses('toolbar.filterbtn.wrapper')])
    >
        <div>
            <button
                type="button"
                @class([$this->themeClasses('toolbar.filterbtn.button')])
                @if ($this->isFilterLayoutPopover()) x-on:click="filterPopoverOpen = !filterPopoverOpen"
                    aria-haspopup="true"
                    x-bind:aria-expanded="filterPopoverOpen"
                    aria-expanded="true"
                @endif
                @if ($this->isFilterLayoutSlideDown()) x-on:click="filtersOpen = !filtersOpen" @endif
            >
                {{ __($localisationPath.'Filters') }}

                @if ($count = $this->getFilterBadgeCount())
                    <span @class([$this->themeClasses('toolbar.filterbtn.badge')])>
                        {{ $count }}
                    </span>
                @endif

                @if($isTailwind)
                    <x-heroicon-o-funnel class="-mr-1 ml-2 h-5 w-5" />
                @else
                <span @class([
                    'caret' => $isBootstrap,
                ])></span>
                @endif

            </button>
        </div>

        @if ($this->isFilterLayoutPopover())
            <x-livewire-tables::tools.toolbar.items.filter-popover  />
        @endif

    </div>
</div>
