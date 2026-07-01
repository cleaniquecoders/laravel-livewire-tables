# Upgrading from v3 to v4

v4.0 of this fork targets **Laravel 12 and 13** with **Livewire 4**, and **drops Livewire 3** entirely. This is the
canonical guide for upgrading from `rappasoft/laravel-livewire-tables` v3.x (or an earlier fork build).

The fork exists because upstream declined Livewire 4 support
([rappasoft#2315](https://github.com/rappasoft/laravel-livewire-tables/issues/2315), marked `wontfix`) and had not
shipped Laravel 13. v4.0 delivers both.

## Requirements

| Dependency | v3 | v4.0 |
|---|---|---|
| PHP | 8.1+ | **8.2+** |
| Laravel | 10 / 11 / 12 | **12 / 13** |
| Livewire | 3 | **4 only** |

## Steps

### 1. Bump the dependency

Make sure your app is on Livewire 4 first. This fork is not published to Packagist, so add it as a VCS
repository in your `composer.json`, then require the `4.0` branch:

```json
{
    "repositories": [
        { "type": "vcs", "url": "https://github.com/cleaniquecoders/laravel-livewire-tables" }
    ]
}
```

```bash
composer require livewire/livewire:^4.0
composer require rappasoft/laravel-livewire-tables:dev-4.0
```

Livewire 3 is no longer supported. Livewire 4 bundles Alpine.js, so no separate Alpine install is needed.
See the [installation guide](../04-reference/01-getting-started/installation.md) for details.

### 2. The component namespace is unchanged

The PHP namespace stays `Rappasoft\LaravelLivewireTables\` in v4.0, so existing tables, columns, and filters keep
working without any `use`-statement changes:

```php
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
```

The Composer package name is likewise still `rappasoft/laravel-livewire-tables`. A namespace and package rebrand is
deferred to a later major (M6).

### 3. `wire:model` modifier change (Livewire 4)

Livewire 4 changed modifier semantics: `.blur` and `.change` now also gate **client-side** state sync, not just the
network request. The package handles this internally — search and all filters now bind with `wire:model.live.blur`. If
you set custom wire modifiers on filters via `setWireBlur()` or `setWireMethod()`, review them: to keep the v3
"update on blur" behaviour under v4, use `live.blur` rather than `blur` alone.

### 4. `make:datatable`

The generator was rewritten to drop Livewire 3 internals (the removed `ComponentParser`). Usage is unchanged:

```bash
php artisan make:datatable MyTable MyModel
```

Nested names such as `Admin/MyTable` resolve against your `livewire.class_namespace` and `livewire.class_path` config.

### 5. Nothing else should change

The public API (`columns()`, `filters()`, `configure()`, and the fluent `Column::make()` / `Filter::make()` builders) is
unchanged. Run your test suite after upgrading.

## Behaviour fixes you may notice

- `setDefaultPerPage()` set inside `configure()` is now honoured (was previously ignored).
- Sort pills: the *Applied Sorting* header no longer appears when no sortable pill is actually rendered.
- Cursor pagination no longer runs a `COUNT(*)` when totals are disabled via
  `setShouldRetrieveTotalItemCountDisabled()`.
- Sortable headers now expose `aria-sort` for screen readers.

## For package developers

- Tests run on **Pest 4** (`composer test`); existing PHPUnit-style tests still run via Pest's interop.
- A **Testbench workbench** ships for local QA — see [Workbench](../02-development/02-workbench.md).

## Known follow-ups (post-4.0)

Tracked in the post-4.0 follow-ups milestone: the theme-strategy refactor and Tailwind 4, trait consolidation, the
Vite asset pipeline, BelongsToMany relation columns, multi-table reorder isolation, and exhaustive per-component
workbench demos. See the [roadmap](../00-product/02-roadmap.md) for the full picture.
