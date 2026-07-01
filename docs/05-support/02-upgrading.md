# Upgrading from v3 to v4

v4.0 of this fork targets **Laravel 12 and 13** with **Livewire 4**, and **drops Livewire 3** entirely. This page is a
faithful summary of the canonical migration notes. For the full version, read
[docs/v4/MIGRATION.md](../../docs/v4/MIGRATION.md).

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

Make sure your app is on Livewire 4 first, then require the new major:

```bash
composer require livewire/livewire:^4.0
composer require cleaniquecoders/laravel-livewire-tables:^4.0
```

Livewire 3 is no longer supported. Livewire 4 bundles Alpine.js, so no separate Alpine install is needed.

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

## Canonical reference

This page is a summary. The authoritative migration guide — including the full requirements table, package-developer
notes (Pest 4, the Testbench workbench), and known post-4.0 follow-ups — lives at
[docs/v4/MIGRATION.md](../../docs/v4/MIGRATION.md).
