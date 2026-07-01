@aware(['isTailwind', 'isBootstrap'])
@if ($this->collapsingColumnsAreEnabled && $this->hasCollapsedColumns)
    <th scope="col" :class="{ 'laravel-livewire-tables-reorderingMinimised': ! currentlyReorderingStatus }" {{
        $attributes->merge()
            ->class([
                $this->themeClasses('th.collapsed.base') => true,
                $this->themeClasses('td.collapsed.sm') => !$this->shouldCollapseOnTablet && !$this->shouldCollapseAlways,
                $this->themeClasses('td.collapsed.md') => !$this->shouldCollapseOnMobile && !$this->shouldCollapseOnTablet && !$this->shouldCollapseAlways,
                $this->themeClasses('td.collapsed.lg') => !$this->shouldCollapseAlways,
            ])
        }}></th>
@endif
