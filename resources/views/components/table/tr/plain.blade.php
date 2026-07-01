@aware(['isTailwind','isBootstrap'])
@props(['customAttributes' => [], 'displayMinimisedOnReorder' => true])

{{-- #23: one structure; the theme-specific row class comes from themeClasses(). --}}
<tr {{ $attributes
        ->merge($customAttributes)
        ->class([
            'laravel-livewire-tables-reorderingMinimised',
            $this->themeClasses('table.tr.plain') => ($customAttributes['default'] ?? true),
        ])
        ->except(['default','default-styling','default-colors'])
    }}
>
    {{ $slot }}
</tr>
