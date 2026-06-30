# Upgrading to v4.0

v4.0 of this fork targets **Laravel 13 (and 12)** with **Livewire 4**, and **drops Livewire 3**. This guide covers upgrading from `rappasoft/laravel-livewire-tables` v3.x (or an earlier fork build).

> Why this fork? Upstream declined Livewire 4 support ([rappasoft#2315](https://github.com/rappasoft/laravel-livewire-tables/issues/2315), `wontfix`). This fork delivers it.

## Requirements

| | v3 | **v4.0** |
|---|---|---|
| PHP | 8.1+ | **8.2+** (test toolchain needs 8.3+) |
| Laravel | 10 / 11 / 12 | **12 / 13** |
| Livewire | 3 | **4 only** |

## Steps

### 1. Bump the dependency

```bash
composer require cleaniquecoders/laravel-livewire-tables:^4.0
```

Ensure your app is on **Livewire 4** first (`composer require livewire/livewire:^4.0`) — see the [Livewire 4 upgrade guide](https://livewire.laravel.com/docs/4.x/upgrading). Livewire 3 is no longer supported.

### 2. The component namespace is unchanged

The PHP namespace remains `Rappasoft\LaravelLivewireTables\` in v4.0, so your existing tables, columns, and filters keep working without `use`-statement changes:

```php
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
```

(A namespace rebrand is deferred to a later major.)

### 3. `wire:model` modifier change (Livewire 4)

Livewire 4 changed modifier semantics: `.blur`/`.change` now also gate **client-side** state sync, not just the network request. The package handles this internally — search and all filters now bind with `wire:model.live.blur`. **If you set custom wire modifiers** on filters via `setWireBlur()` / `setWireMethod()`, review them: to keep the v3 "update on blur" behavior under v4 use `live.blur` rather than `blur`.

### 4. `make:datatable`

The generator was rewritten to drop Livewire 3 internals (the removed `ComponentParser`). `php artisan make:datatable MyTable MyModel` works as before; nested names (`Admin/MyTable`) resolve against your `livewire.class_namespace` / `livewire.class_path` config.

### 5. Nothing else should change

The public API (`columns()`, `filters()`, `configure()`, the fluent `Column::make()` / `Filter::make()` builders) is unchanged. Run your test suite.

## Behavior fixes you may notice

- **`setDefaultPerPage()`** set inside `configure()` is now honored (was previously ignored). (#2050)
- **Sort pills**: the *Applied Sorting* header no longer appears when no sortable pill is actually rendered. (#2268)
- **Cursor pagination** no longer runs a `COUNT(*)` when totals are disabled via `setShouldRetrieveTotalItemCountDisabled()`. (#2186)
- Sortable headers now expose `aria-sort` for screen readers.

## For package developers

- Tests run on **Pest 4** (`composer test`). Existing PHPUnit-style tests still run via Pest's interop.
- A **Testbench workbench** ships for local QA: `composer build` then `composer serve`.

## Known follow-ups (post-4.0)

Tracked in the **v4.x — Post-4.0 Follow-ups** milestone: theme-strategy refactor + Tailwind 4, trait consolidation, a Vite asset pipeline, BelongsToMany relation columns, multi-table reorder isolation, and exhaustive per-component workbench demos.
