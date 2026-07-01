# Architecture overview

This package renders a dynamic, configurable data table as a single Livewire component. It supports sorting,
searching, filtering, pagination, bulk actions, reordering, secondary headers, and footers, and it is themeable
across Tailwind, Bootstrap 4, Bootstrap 5, and the Flux theme.

This document walks through the moving parts: the component entry point, the trait composition that supplies its
behaviour, the column and filter class hierarchies, the Blade view layer with its per-theme branching, and the
service provider plus configuration.

## The DataTableComponent entry point

Every table you build extends `Rappasoft\LaravelLivewireTables\DataTableComponent`. It is a deliberately thin
abstract class that extends `Livewire\Component` and mixes in a single aggregate trait:

```php
abstract class DataTableComponent extends Component
{
    use HasAllTraits;

    #[On('refreshDatatable')]
    public function boot(): void
    {
        //
    }

    public function booted(): void {}

    public function render(): Application|Factory|View
    {
        return view('livewire-tables::datatable');
    }
}
```

The class itself carries almost no logic. `render()` always returns the `livewire-tables::datatable` view, and the
`refreshDatatable` event is wired to Livewire's `boot()` lifecycle hook so the table can be refreshed from anywhere
in the page. All real behaviour is composed in through `HasAllTraits`.

Your own subclass provides the data source and the shape of the table, typically by implementing `columns()` and a
`configure()` method (where you set the theme, pagination style, search behaviour, and so on).

## Trait composition: HasAllTraits

`src/Traits/HasAllTraits.php` is the composition root. It pulls in roughly 26 root `With*` traits in a
**load-order-dependent sequence** — the file is explicitly annotated with a "Note Specific Order Below!" comment,
because some traits depend on properties or methods defined by traits loaded before them. Do not reorder these
`use` groups casually.

The behaviour of the package fans out across four kinds of trait. Each feature area (Columns, Sorting, Filters,
Pagination, Bulk Actions, Reordering, Secondary Header, Footer, Tools, and so on) is typically split into a
matching set:

| Trait kind      | Approximate count | Responsibility                                        |
| --------------- | ----------------- | ----------------------------------------------------- |
| `With*`         | ~26               | Root feature traits, wired together in `HasAllTraits` |
| `*Configuration`| ~22               | Setters and feature flags (how the feature is set up) |
| `*Helpers`      | ~22               | Getters and logic (how the feature behaves at render) |
| `*Styling`      | ~11               | Theme-aware CSS class resolution                       |

So a single feature such as Columns is usually expressed as a `WithColumns` root trait plus a `ColumnConfiguration`
setter trait, a `ColumnHelpers` logic trait, and a `ColumnStyling` styling trait. This spread keeps each concern
small but produces a large, interconnected trait surface. It is the central refactor target for v4, but changes
here must stay behaviour-preserving and test-guarded.

The root traits wired in by `HasAllTraits` include `WithTableHooks`, `WithFilters`, `WithQuery`, `WithActions`,
`WithData`, `WithQueryString`, `WithColumns`, `WithSorting`, `WithSearch`, `WithPagination`, `WithBulkActions`,
`WithCollapsingColumns`, `WithColumnSelect`, `WithConfigurableAreas`, `WithCustomisations`, `WithDebugging`,
`WithEvents`, `WithFooter`, `WithRefresh`, `WithReordering`, `WithSecondaryHeader`, `WithSessionStorage`,
`WithTableAttributes`, and `WithTools`, alongside the core `HasLocalisations`, `HasTheme`, `HasCustomAttributes`,
and `ComponentUtilities` traits.

## Column hierarchy

Columns live under `src/Views/Columns/`. The base class is `src/Views/Column.php`, and every column is constructed
with the static factory `Column::make($title, $from)` (the `$from` argument is the field or relation the column
reads). Column behaviour is composed from traits under `src/Views/Columns/Traits/` — for example `IsSortable`,
`IsSearchable`, `HasView`, and `HasRelations`.

There are 17 column types. The aggregate family (`AggregateColumn`, `AvgColumn`, `CountColumn`, `SumColumn`) is a
set of near-duplicates.

| Column class            | Purpose                                              |
| ----------------------- | ---------------------------------------------------- |
| `Column`                | Base text/value column and factory                   |
| `BooleanColumn`         | Renders a truthy/falsy value as an indicator          |
| `ColorColumn`           | Renders a colour swatch                               |
| `DateColumn`            | Formats a date value                                 |
| `ImageColumn`           | Renders an image                                     |
| `LinkColumn`            | Renders an anchor link                               |
| `WireLinkColumn`        | Renders a Livewire-navigable link                    |
| `IconColumn`            | Renders an icon                                       |
| `ButtonGroupColumn`     | Groups multiple link/button columns                   |
| `ArrayColumn`           | Renders array/collection values                       |
| `IncrementColumn`       | Renders a running row number                          |
| `ComponentColumn`       | Renders a Blade component                             |
| `ViewComponentColumn`   | Renders via a view component                          |
| `LivewireComponentColumn`| Embeds a nested Livewire component                   |
| `AggregateColumn`       | Base for relation aggregates                          |
| `AvgColumn`             | Averages a related field                              |
| `CountColumn`           | Counts related records                               |
| `SumColumn`             | Sums a related field                                 |

## Filter hierarchy

Filters live under `src/Views/Filters/` and follow the same base-plus-traits pattern as columns. There are 12
filter types; the Date and Select families overlap in structure. Several filters read defaults from
`config/livewire-tables.php` (see the configuration section below).

| Filter class                    | Purpose                                     |
| ------------------------------- | ------------------------------------------- |
| `TextFilter`                    | Free-text match                             |
| `NumberFilter`                  | Single numeric value                        |
| `NumberRangeFilter`             | Numeric min/max range                       |
| `SelectFilter`                  | Single-choice dropdown                      |
| `MultiSelectFilter`             | Multiple-choice selection                   |
| `MultiSelectDropdownFilter`     | Multiple-choice dropdown                    |
| `BooleanFilter`                 | Yes/no/all toggle                           |
| `DateFilter`                    | Single date                                 |
| `DateTimeFilter`                | Single date and time                        |
| `DateRangeFilter`               | Start/end date range                        |
| `LivewireComponentFilter`       | Custom filter backed by a Livewire component|
| `LivewireComponentArrayFilter`  | Array-valued Livewire-component filter      |

## Blade views and theme branching

The rendered markup lives in `resources/views/`. `DataTableComponent::render()` returns the
`livewire-tables::datatable` view, and the sub-views under `resources/views/components/` are registered as Blade
components through `Blade::componentNamespace(...)` in the service provider (namespace prefix `livewire-tables`).

Themes are not separate view sets. Instead, each theme is selected inline inside the shared Blade files using
`@if ($isTailwind) / @elseif ($isBootstrap)` branches, spread across roughly 59 Blade files. Adding or altering a
theme therefore touches many files. The theme flags come from the `HasTheme` trait, whose computed properties
resolve the active theme:

| Method           | Returns true when                                             |
| ---------------- | ------------------------------------------------------------- |
| `isTailwind()`   | Theme is not Bootstrap 4 or 5 (also true for Flux)            |
| `isBootstrap()`  | Theme is Bootstrap 4 or 5                                     |
| `isBootstrap4()` | Theme is `bootstrap-4`                                        |
| `isBootstrap5()` | Theme is `bootstrap-5`                                        |
| `isFlux()`       | Theme is `flux`                                               |
| `useFluxTable()` | Flux is active and no feature blocks the native `flux:table`  |

The Flux theme is Tailwind-based: `isFlux()` is true only for the `flux` theme, but `isTailwind()` stays true for
Flux so the table body still renders. The Flux theme is covered in detail in
[Theming — the Flux theme](02-theming.md).

## Service provider and configuration

`src/LaravelLivewireTablesServiceProvider.php` bootstraps the package. In `boot()` it:

- Registers an `AboutCommand` entry for `php artisan about`.
- Loads translations — JSON translations when `use_json_translations` is enabled, otherwise the PHP array
  translations under the `livewire-tables` namespace.
- Registers the `@tableloop` / `@endtableloop` Blade directives.
- Loads views from `resources/views` under the `livewire-tables` namespace and registers the Blade component
  namespace.
- Registers the `make:datatable` console command and the publish groups.
- Boots the frontend asset injector when any of the asset/directive toggles are enabled.

In `register()` it merges the package config and (when the asset toggles are on) registers the frontend assets and
the `AutoInjectRappasoftAssets` component hook. Configuration is merged in `register()`, not `boot()`.

The publishable groups are:

| Publish tag                          | Publishes                                    |
| ------------------------------------ | -------------------------------------------- |
| `livewire-tables-translations`       | PHP array translations                       |
| `livewire-tables-translations-json`  | JSON translations                            |
| `livewire-tables-config`             | `config/livewire-tables.php`                 |
| `livewire-tables-views`              | Blade views for local overrides              |
| `livewire-tables-public`             | Compiled CSS/JS to the public path           |

The config file `config/livewire-tables.php` exposes:

| Config key                          | Purpose                                               |
| ----------------------------------- | ----------------------------------------------------- |
| `theme`                             | Active theme (`tailwind`, `bootstrap-4`, `bootstrap-5`)|
| `cache_assets`                      | Cache the injected frontend assets                    |
| `inject_core_assets_enabled`        | Auto-inject the package's core CSS/JS                  |
| `inject_third_party_assets_enabled` | Auto-inject bundled third-party assets                |
| `enable_blade_directives`           | Enable manual `@..Scripts` / `@..Styles` directives   |
| `use_json_translations`            | Use JSON translations instead of PHP arrays           |
| `script_base_path`                  | Base path for the served scripts and styles           |
| `dateFilter` / `dateTimeFilter`     | Default format and pill format for date filters       |
| `dateRange` / `numberRange`         | Default options and config for range filters          |
| `selectFilter` / `multiSelectFilter`| Default options and config for select filters         |
| `events`                            | Event options (e.g. attach the auth user to events)   |

The `theme` key documents `tailwind`, `bootstrap-4`, and `bootstrap-5`; the Flux theme is selected at runtime with
`$this->setTheme('flux')` in your component's `configure()` method rather than via this config default.
