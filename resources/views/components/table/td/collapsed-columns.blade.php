@aware([ 'tableName','isTailwind','isBootstrap'])
@props(['rowIndex', 'hidden' => false])

@if ($this->collapsingColumnsAreEnabled && $this->hasCollapsedColumns)
    <td x-data="{open:false}" wire:key="{{ $tableName }}-collapsingIcon-{{ $rowIndex }}-{{ md5(now()) }}"
        {{
            $attributes
                ->merge()
                ->class([
                    $this->themeClasses('td.collapsed.base') => true,
                    $this->themeClasses('td.collapsed.sm') => !$this->shouldCollapseAlways() && !$this->shouldCollapseOnTablet(),
                    $this->themeClasses('td.collapsed.md') => !$this->shouldCollapseAlways() && !$this->shouldCollapseOnTablet() && $this->shouldCollapseOnMobile(),
                    $this->themeClasses('td.collapsed.lg') => !$this->shouldCollapseAlways() && ($this->shouldCollapseOnTablet() || $this->shouldCollapseOnMobile()),
                ])
        }}
        :class="currentlyReorderingStatus ? 'laravel-livewire-tables-reorderingMinimised' : ''"
    >
        @if (! $hidden)
            <button
                type="button"
                aria-label="{{ __('Toggle row details') }}"
                x-bind:aria-expanded="open"
                x-cloak x-show="!currentlyReorderingStatus"
                x-on:click.prevent="$dispatch('toggle-row-content', {'tableName': '{{ $tableName }}', 'row': {{ $rowIndex }}}); open = !open"
                @class([$this->themeClasses('td.collapsed.button')])
            >
                <x-heroicon-o-plus-circle x-cloak x-show="!open" {{ 
                    $attributes->merge($this->getCollapsingColumnButtonExpandAttributes)
                        ->class([
                            $this->themeClasses('td.collapsed.icon.styling') => $isTailwind && ($this->getCollapsingColumnButtonExpandAttributes['default-styling'] ?? true),
                            $this->themeClasses('td.collapsed.expandicon.colors') => $this->getCollapsingColumnButtonExpandAttributes['default-colors'] ?? true,
                        ])
                        ->except(['default','default-styling','default-colors']) 
                    }}
                />
                <x-heroicon-o-minus-circle x-cloak x-show="open"  {{ 
                    $attributes->merge($this->getCollapsingColumnButtonCollapseAttributes)
                        ->class([
                            $this->themeClasses('td.collapsed.icon.styling') => $isTailwind && ($this->getCollapsingColumnButtonCollapseAttributes['default-styling'] ?? true),
                            $this->themeClasses('td.collapsed.collapseicon.colors') => $this->getCollapsingColumnButtonCollapseAttributes['default-colors'] ?? true,
                        ])
                        ->except(['default','default-styling','default-colors']) 
                    }}
                />
            </button>
        @endif 
    </td>
@endif
