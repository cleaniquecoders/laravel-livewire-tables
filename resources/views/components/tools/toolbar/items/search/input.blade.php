@aware(['isTailwind', 'isBootstrap'])
<input
    wire:model{{ $this->getSearchOptions() }}="search"
    placeholder="{{ $this->getSearchPlaceholder() }}"
    type="text"
    {{ 
        $attributes->merge($this->getSearchFieldAttributes())
        ->class([
            $this->themeClasses('searchinput.styling.has') => $isTailwind && $this->hasSearch() && (($this->getSearchFieldAttributes()['default'] ?? true) || ($this->getSearchFieldAttributes()['default-styling'] ?? true)),
            $this->themeClasses('searchinput.styling.no') => $isTailwind && !$this->hasSearch()  && (($this->getSearchFieldAttributes()['default'] ?? true) || ($this->getSearchFieldAttributes()['default-styling'] ?? true)),
            $this->themeClasses('searchinput.colors.has') => $isTailwind && $this->hasSearch()  && (($this->getSearchFieldAttributes()['default'] ?? true) || ($this->getSearchFieldAttributes()['default-colors'] ?? true)),
            $this->themeClasses('searchinput.colors.no') => $isTailwind && !$this->hasSearch()  && (($this->getSearchFieldAttributes()['default'] ?? true) || ($this->getSearchFieldAttributes()['default-colors'] ?? true)),
            'block w-full' => !$this->hasSearchIcon,
            'pl-8 pr-4' => $this->hasSearchIcon,
            $this->themeClasses('searchinput.bs') => $isBootstrap && $this->getSearchFieldAttributes()['default'] ?? true,
        ])
        ->except(['default','default-styling','default-colors']) 
    }}

/>