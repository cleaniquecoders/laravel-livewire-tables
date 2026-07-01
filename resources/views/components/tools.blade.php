@aware(['isTailwind','isBootstrap'])

{{-- #23: theme-specific wrapper class comes from themeClasses(). --}}
<div {{
    $attributes->merge($this->getToolsAttributes)
        ->class([
            $this->themeClasses('tools.wrapper') => $this->getToolsAttributes['default-styling'] ?? true,
        ])
        ->except(['default','default-styling','default-colors'])
    }}
>
    {{ $slot }}
</div>
