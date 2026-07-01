# FAQ and Troubleshooting

Answers to the questions we hear most often about the v4 fork, plus troubleshooting for the new Flux theme and a
contributor note on Blade gotchas. This is the `cleaniquecoders/laravel-livewire-tables` fork; the Composer package
name is still `rappasoft/laravel-livewire-tables` (a rebrand is deferred to a later major).

### Does this support Livewire 3?

No. v4.0 targets **Livewire 4 only** and drops Livewire 3 entirely. This is the whole reason the fork exists: upstream
declined Livewire 4 support ([rappasoft#2315](https://github.com/rappasoft/laravel-livewire-tables/issues/2315), marked
`wontfix`) and had not shipped Laravel 13. If you are still on Livewire 3, stay on the v3 line of the package until you
can upgrade Livewire. Livewire 4 bundles Alpine.js, so you do not install Alpine separately.

### Which Laravel versions are supported?

Laravel **12 and 13**. The full requirement set is:

| Dependency | Constraint |
|---|---|
| PHP | `^8.2` |
| Laravel | `^12` or `^13` |
| Livewire | `^4` |
| Orchestra Testbench (dev) | `^10` or `^11` |

The fork is not on Packagist — add it as a VCS repository and require the `4.0` branch (see the
[installation guide](../04-reference/01-getting-started/installation.md)):

```bash
composer require rappasoft/laravel-livewire-tables:dev-4.0
```

Note the release is currently **held** — no `v4.0.0` tag has been published yet pending a maintainer decision — even
though the suite is green (1535 tests passing).

### How do I enable the Flux theme?

Set the theme inside your table's `configure()` method:

```php
public function configure(): void
{
    $this->setTheme('flux');
}
```

The Flux theme requires the `livewire/flux` package. Flux v2 is **free** (its components are directory-based), so no
paid licence is needed for the theme to work. The four supported themes are `tailwind` (default), `bootstrap-4`,
`bootstrap-5`, and the new `flux`.

The Flux theme is Tailwind-based: `HasTheme::isFlux()` returns `true` when the theme is `flux`, while `isTailwind()`
stays `true` for Flux so the table body still renders. Views branch on `$this->isFlux()` (component views) or
`$isFlux ?? false` (filter views under `components/tools/filters/*`). Flux swaps the controls for native components —
search becomes `flux:input`, per-page becomes `flux:select`, the boolean filter becomes `flux:switch`, filter and
sorting pills become `flux:badge` with `flux:badge.close`, and the empty state becomes a `flux:table` row with an icon
badge and heading.

### Why does my `flux:table` fall back to a plain table?

The native `flux:table` body cannot preserve every table feature, so the package renders it only when it is safe to do
so. `HasTheme::useFluxTable()` returns `true` (native `flux:table`) **only when none** of the following is active:

- reordering (`reorderIsEnabled()`)
- a clickable row URL (`hasTableRowUrl()`)
- bulk actions (`showBulkActionsSections()`)
- collapsing columns (`showCollapsingColumnSections()`)
- the loading placeholder (`hasDisplayLoadingPlaceholder()`)
- a secondary header with columns (`secondaryHeaderIsEnabled()` and `hasColumnsWithSecondaryHeader()`)
- a footer with columns (`footerIsEnabled()` and `hasColumnsWithFooter()`)

If any of those is active, the table falls back to a **Flux-zinc-styled version of the package's own raw table** so drag
reorder, row navigation, column collapsing, bulk-action columns, the loading row, and secondary header/footer rows keep
working. This is expected behaviour, not a bug — disable the feature that triggers the fallback if you specifically need
the native `flux:table` markup. The `/features` demo page in the workbench exists to show this fallback in action.

### Where is the demo?

In the **workbench** — an Orchestra Testbench app shipped in `workbench/` for package development. It shows every column,
filter, and feature across all themes, with a Flux sidebar and light/dark toggle. See
[Workbench](../02-development/02-workbench.md) for how to run and reseed it. The short version:

```bash
composer serve
```

That runs `testbench serve` on port 8000 and `vite build --watch` concurrently. Reseed the demo database with
`vendor/bin/testbench migrate:fresh` — it auto-seeds the configured seeder, so do **not** also run `db:seed` (that
double-runs the seeder and fails on a UNIQUE constraint).

### Contributor note: Blade gotchas inside paired Flux tags

When editing the Flux theme views, do **not** place a `wire:key` attribute or a `{{ }}` / `{!! !!}` echo in the **opening
tag** of a paired Flux component (for example on `<flux:table.row ...>` or `<flux:badge ...>`). Livewire injects a stray
`@endif` for a `wire:key` on a component, which breaks the enclosing `@if`/`@elseif` and fails compilation with
"unexpected token elseif". Put the `wire:key` and `x-data` on a plain wrapper element you control; self-closing Flux tags
tolerate echoes in their attributes. The
test suite registers `Flux\FluxServiceProvider` so these `<flux:*>` tags compile as real components under test, which
means such mistakes surface in `composer test` rather than only at runtime.
