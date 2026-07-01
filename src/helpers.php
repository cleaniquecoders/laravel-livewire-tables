<?php

use Rappasoft\LaravelLivewireTables\Themes\ThemeStyles;

if (! function_exists('lwtThemeClasses')) {
    /**
     * Resolve a theme class string for views that are rendered without the
     * component `$this` context (filter views, leaf column includes). Component
     * blades should use `$this->themeClasses($key)` instead.
     */
    function lwtThemeClasses(string $theme, string $key): string
    {
        return ThemeStyles::for($theme, $key);
    }
}

if (! function_exists('lwtThemeName')) {
    /**
     * Derive the active theme name from the boolean flags passed to a view.
     */
    function lwtThemeName(bool $isFlux = false, bool $isBootstrap4 = false, bool $isBootstrap5 = false): string
    {
        return match (true) {
            $isFlux => 'flux',
            $isBootstrap4 => 'bootstrap-4',
            $isBootstrap5 => 'bootstrap-5',
            default => 'tailwind',
        };
    }
}
