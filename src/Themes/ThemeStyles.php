<?php

namespace Rappasoft\LaravelLivewireTables\Themes;

/**
 * Centralised, per-theme class strings — the first step of the theme-strategy
 * refactor (#23). Blades call `$this->themeClasses('key')` instead of inlining
 * `@if($isTailwind)/@elseif($isBootstrap)` class branches.
 *
 * Keys fall back to the Tailwind theme: the Flux theme is Tailwind-based and only
 * overrides the handful of keys where it differs. Structure (no closures) keeps
 * it config-cache safe. Migrate one blade group at a time, adding its keys here;
 * the tests/Visuals per-theme suite guards that the rendered output is unchanged.
 */
class ThemeStyles
{
    /**
     * @var array<string, array<string, string>>
     */
    protected static array $classes = [
        'tailwind' => [
            'table.wrapper' => 'shadow overflow-y-auto border-b border-gray-200 dark:border-gray-700 sm:rounded-lg',
            'table.element' => 'min-w-full divide-y divide-gray-200 dark:divide-none',
            'table.thead' => 'bg-gray-50 dark:bg-gray-800',
            'table.tbody' => 'bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-none',
            'table.tr.plain' => 'bg-white dark:bg-gray-700 dark:text-white',
            'tools.wrapper' => 'flex-col',
        ],
        'flux' => [
            'table.wrapper' => 'lwt-flux overflow-y-auto',
        ],
        'bootstrap-4' => [
            'table.wrapper' => 'table-responsive',
            'table.element' => 'laravel-livewire-table table',
            'table.thead' => '',
            'table.tbody' => '',
            'table.tr.plain' => '',
            'tools.wrapper' => 'd-flex flex-column',
        ],
        'bootstrap-5' => [
            'table.wrapper' => 'table-responsive',
            'table.element' => 'laravel-livewire-table table',
            'table.thead' => '',
            'table.tbody' => '',
            'table.tr.plain' => '',
            'tools.wrapper' => 'd-flex flex-column',
        ],
    ];

    public static function for(string $theme, string $key): string
    {
        return self::$classes[$theme][$key]
            ?? self::$classes['tailwind'][$key]
            ?? '';
    }
}
