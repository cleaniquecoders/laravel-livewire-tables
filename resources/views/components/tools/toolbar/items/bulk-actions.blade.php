@aware([ 'tableName','isTailwind','isBootstrap','isBootstrap4','isBootstrap5', 'localisationPath'])
<div
    x-data="{ open: false, childElementOpen: false, isTailwind: @js($isTailwind), isBootstrap: @js($isBootstrap) }"
    x-cloak x-show="(selectedItems.length > 0 || hideBulkActionsWhenEmpty == false)"
    @class([$this->themeClasses('ba.outer')])
>
    <div @class([$this->themeClasses('ba.inner')])>
        <button
            {{ 
                $attributes->merge($this->getBulkActionsButtonAttributes)
                ->class([
                    $this->themeClasses('ba.button.bs') => $isBootstrap && ($this->getBulkActionsButtonAttributes['default-styling'] ?? true),
                    $this->themeClasses('ba.button.colors') => $isTailwind && ($this->getBulkActionsButtonAttributes['default-colors'] ?? true),
                    $this->themeClasses('ba.button.styling') => $isTailwind && ($this->getBulkActionsButtonAttributes['default-styling'] ?? true),
                    $this->themeClasses('ba.button.rounded') => $isTailwind && ($this->getBulkActionsButtonAttributes['default-styling'] ?? true),
                ])
                ->except(['default','default-styling','default-colors']) 
            }}
            type="button"
            id="{{ $tableName }}-bulkActionsDropdown" 
            
                        
            @if($isTailwind)
                        x-on:click="open = !open"
                        @else
                        data-toggle="dropdown" data-bs-toggle="dropdown"
                        @endif
            aria-haspopup="true" aria-expanded="false">

            {{ __($localisationPath.'Bulk Actions') }}

            @if($isTailwind)
                <x-heroicon-m-chevron-down class="-mr-1 ml-2 h-5 w-5" />
            @endif
        </button>
        
        @if($isTailwind)
            <div
                x-on:click.away="if (!childElementOpen) { open = false }"
                @keydown.window.escape="if (!childElementOpen) { open = false }"
                x-cloak x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                @class([$this->themeClasses('ba.menu.wrapper.base'), $this->themeClasses('ba.menu.wrapper.variant')])
            >
                <div
                    {{ 
                        $attributes->merge($this->getBulkActionsMenuAttributes)
                        ->class([
                            $this->themeClasses('ba.menu.colors') => $isTailwind && ($this->getBulkActionsMenuAttributes['default-colors'] ?? true),
                            $this->themeClasses('ba.menu.colors.variant') => $isTailwind && ($this->getBulkActionsMenuAttributes['default-colors'] ?? true),
                            $this->themeClasses('ba.menu.styling') => $isTailwind && ($this->getBulkActionsMenuAttributes['default-styling'] ?? true),
                            $this->themeClasses('ba.menu.rounded') => $isTailwind && ($this->getBulkActionsMenuAttributes['default-styling'] ?? true),
                        ])
                        ->except(['default','default-styling','default-colors']) 
                    }}
                >
                    <div class="py-1" role="menu" aria-orientation="vertical">
                        @foreach ($this->getBulkActions() as $action => $title)
                            <button
                                wire:click="{{ $action }}"
                                @if($this->hasConfirmationMessage($action))
                                    wire:confirm="{{ $this->getBulkActionConfirmMessage($action) }}"
                                @endif
                                wire:key="{{ $tableName }}-bulk-action-{{ $action }}"
                                type="button"
                                role="menuitem"
                                {{ 
                                    $attributes->merge($this->getBulkActionsMenuItemAttributes)
                                    ->class([
                                        $this->themeClasses('ba.item.colors') => $isTailwind && ($this->getBulkActionsMenuItemAttributes['default-colors'] ?? true),
                                        $this->themeClasses('ba.item.styling') => $isTailwind && ($this->getBulkActionsMenuItemAttributes['default-styling'] ?? true),
                                    ])
                                    ->except(['default','default-styling','default-colors']) 
                                }}
                            >
                                <span>{{ $title }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div
                {{ 
                    $attributes->merge($this->getBulkActionsMenuAttributes)
                    ->class([$this->themeClasses('ba.bsmenu') => $isBootstrap && ($this->getBulkActionsMenuAttributes['default-styling'] ?? true)])
                    ->except(['default','default-styling','default-colors']) 
                }}
                aria-labelledby="{{ $tableName }}-bulkActionsDropdown"
            >
                @foreach ($this->getBulkActions() as $action => $title)
                    <a
                        href="#"
                        @if($this->hasConfirmationMessage($action))
                            wire:confirm="{{ $this->getBulkActionConfirmMessage($action) }}"
                        @endif
                        wire:click="{{ $action }}"
                        wire:key="{{ $tableName }}-bulk-action-{{ $action }}"
                        {{ 
                            $attributes->merge($this->getBulkActionsMenuItemAttributes)
                                ->class([$this->themeClasses('ba.bsitem') => $isBootstrap && ($this->getBulkActionsMenuItemAttributes['default-styling'] ?? true)])
                                ->except(['default','default-styling','default-colors']) 
                        }}
                    >
                        {{ $title }}
                    </a>
                @endforeach
            </div>
        @endif

    </div>
</div>
