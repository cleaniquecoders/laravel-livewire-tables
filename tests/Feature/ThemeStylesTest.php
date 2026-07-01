<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTable;
use Rappasoft\LaravelLivewireTables\Themes\ThemeStyles;

/*
| #23 — the theme-strategy seam: class strings resolve per active theme (with a
| Tailwind fallback, since Flux is Tailwind-based), replacing inline blade
| @if($isTailwind) branches.
*/

it('resolves theme classes per theme with a tailwind fallback', function () {
    expect(ThemeStyles::for('tailwind', 'table.element'))->toBe('min-w-full divide-y divide-gray-200 dark:divide-none')
        ->and(ThemeStyles::for('bootstrap-5', 'table.element'))->toBe('laravel-livewire-table table')
        ->and(ThemeStyles::for('flux', 'table.element'))->toBe(ThemeStyles::for('tailwind', 'table.element'))
        ->and(ThemeStyles::for('flux', 'table.wrapper'))->toBe('lwt-flux overflow-y-auto')
        ->and(ThemeStyles::for('tailwind', 'nonexistent.key'))->toBe('');
});

it('exposes themeClasses() on the component bound to the active theme', function () {
    $table = new PetsTable;

    $table->setTheme('bootstrap-5');
    expect($table->themeClasses('table.element'))->toBe('laravel-livewire-table table');

    $table->setTheme('tailwind');
    expect($table->themeClasses('table.element'))->toBe('min-w-full divide-y divide-gray-200 dark:divide-none');
});
