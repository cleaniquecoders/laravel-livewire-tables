@aware(['isTailwind', 'isBootstrap'])
@props(['displayMinimisedOnReorder' => false, 'hideUntilReorder' => false, 'customAttributes' => ['default' => true]])

<th x-cloak scope="col" @if($hideUntilReorder) :class="!reorderDisplayColumn && 'w-0 p-0 hidden'" @endif {{
        $attributes->merge($customAttributes)->class([
            $this->themeClasses('th.plain.styling') => ($customAttributes['default-styling'] ?? true) || ($customAttributes['default'] ?? true),
            $this->themeClasses('th.plain.colors') => ($customAttributes['default-colors'] ?? true) || ($customAttributes['default'] ?? true),
        ])->except(['default','default-styling','default-colors'])
}}>
    {{ $slot }}
</th>
