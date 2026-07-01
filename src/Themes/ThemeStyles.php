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
            'toolbar.wrapper' => 'md:flex md:justify-between mb-4 px-4 md:p-0',
            'toolbar.left' => 'w-full mb-4 md:mb-0 md:w-2/4 md:flex space-y-4 md:space-y-0 md:space-x-2',
            'toolbar.right' => 'md:flex md:items-center space-y-4 md:space-y-0 md:space-x-2',
            'toolbar.area' => 'flex rounded-md shadow-sm',
            'th.plain.styling' => 'table-cell px-3 py-2 md:px-6 md:py-3 text-center md:text-left laravel-livewire-tables-reorderingMinimised',
            'th.plain.colors' => 'bg-gray-50 dark:bg-gray-800',
            'th.reorder.styling' => 'table-cell px-6 py-3 text-left text-xs font-medium whitespace-nowrap uppercase tracking-wider',
            'th.reorder.colors' => 'text-gray-500 dark:bg-gray-800 dark:text-gray-400',
            'th.reorder.bs' => '',
            'th.bulkactions.wrapper' => 'inline-flex rounded-md shadow-sm',
            'th.bulkactions.checkbox.colors' => 'border-gray-300 text-indigo-600 focus:border-indigo-300 focus:ring-indigo-200 dark:bg-gray-900 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 dark:focus:bg-gray-600',
            'th.bulkactions.checkbox.styling' => 'rounded shadow-sm transition duration-150 ease-in-out focus:ring focus:ring-opacity-50 ',
            'th.bulkactions.checkbox.bs' => '',
            'td.bulkactions.wrapper' => 'inline-flex rounded-md shadow-sm',
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
            'toolbar.wrapper' => 'd-md-flex justify-content-between mb-3',
            'toolbar.left' => 'd-md-flex',
            'toolbar.right' => 'd-md-flex',
            'toolbar.area' => 'mb-3 mb-md-0 input-group',
            'th.plain.styling' => '',
            'th.plain.colors' => 'laravel-livewire-tables-reorderingMinimised',
            'th.reorder.styling' => '',
            'th.reorder.colors' => '',
            'th.reorder.bs' => 'laravel-livewire-tables-reorderingMinimised',
            'th.bulkactions.wrapper' => 'form-check',
            'th.bulkactions.checkbox.colors' => '',
            'th.bulkactions.checkbox.styling' => '',
            'th.bulkactions.checkbox.bs' => 'form-check-input',
            'td.bulkactions.wrapper' => '',
        ],
        'bootstrap-5' => [
            'table.wrapper' => 'table-responsive',
            'table.element' => 'laravel-livewire-table table',
            'table.thead' => '',
            'table.tbody' => '',
            'table.tr.plain' => '',
            'tools.wrapper' => 'd-flex flex-column',
            'toolbar.wrapper' => 'd-md-flex justify-content-between mb-3',
            'toolbar.left' => 'd-md-flex',
            'toolbar.right' => 'd-md-flex',
            'toolbar.area' => 'mb-3 mb-md-0 input-group',
            'th.plain.styling' => '',
            'th.plain.colors' => 'laravel-livewire-tables-reorderingMinimised',
            'th.reorder.styling' => '',
            'th.reorder.colors' => '',
            'th.reorder.bs' => 'laravel-livewire-tables-reorderingMinimised',
            'th.bulkactions.wrapper' => 'form-check',
            'th.bulkactions.checkbox.colors' => '',
            'th.bulkactions.checkbox.styling' => '',
            'th.bulkactions.checkbox.bs' => 'form-check-input',
            'td.bulkactions.wrapper' => 'form-check',
        ],
    ];

    public static function for(string $theme, string $key): string
    {
        return self::$classes[$theme][$key]
            ?? self::$classes['tailwind'][$key]
            ?? '';
    }
}
