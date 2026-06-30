# CLAUDE.md

Guidance for working in this repository. Read this before making changes.

## What this is

A fork of [`rappasoft/laravel-livewire-tables`](https://github.com/rappasoft/laravel-livewire-tables) — a dynamic, configurable data-table component for Laravel + Livewire (sorting, searching, filtering, pagination, bulk actions, reordering, themeable across Tailwind / Bootstrap 4 / Bootstrap 5).

### Why this fork exists

Upstream **declined Livewire 4 support** (issue [#2315](https://github.com/rappasoft/laravel-livewire-tables/issues/2315) was marked `wontfix`) and had not shipped Laravel 13 support. This fork's goal is a **v4.0** that:

- Targets **Laravel 13** (keeping Laravel 12 compatibility).
- Uses **Livewire 4** and **drops Livewire 3** entirely.
- Improves UX/UI, performance, simplicity of usage, internal architecture, and docs.
- Becomes the package used for future projects instead of upstream.

The roadmap lives in GitHub **milestones M1–M8** and the planning docs under `docs/v4/`.

## Architecture (current, pre-v4)

- **Entry point:** `src/DataTableComponent.php` — a thin `abstract class extends Livewire\Component`. Almost all behaviour is composed in via `src/Traits/HasAllTraits.php`, which pulls in ~26 `With*` traits **in a load-order-dependent sequence** (flagged "Specific Order Below!").
- **Traits (`src/Traits/`):** heavy fan-out — ~26 root `With*` + 22 `*Configuration` + 22 `*Helpers` + 11 `*Styling` traits. Each feature (Columns, Sorting, Filters, Pagination, BulkActions, Reordering, SecondaryHeader, Tools, Footer) is typically split across a `With*` + `*Configuration` (setters/flags) + `*Helpers` (getters/logic) + `*Styling` triplet. Treat this sprawl as the central refactor target (M6) — but keep changes **behaviour-preserving and test-guarded**.
- **Columns (`src/Views/Columns/`):** 17 types, base `src/Views/Column.php` (`Column::make($title, $from)`), behaviour via `Views/Columns/Traits/` (`IsSortable`, `IsSearchable`, `HasView`, `HasRelations`, …). `Aggregate`/`Avg`/`Count`/`Sum` are near-duplicates.
- **Filters (`src/Views/Filters/`):** 12 types, same base+traits pattern. Date and Select families overlap.
- **Views (`resources/views/components/`):** Blade components registered via `Blade::componentNamespace`. **Themes are inline `@if($isTailwind)/@elseif($isBootstrap)` branches across ~59 blade files** — adding/altering a theme touches all of them.
- **Frontend assets:** committed raw **and** pre-minified into `resources/`; "build" is a hand-rolled `minifyJs` shell script (no `package.json`/Vite). Auto-injected at runtime via `src/Mechanisms/RappasoftFrontendAssets` + `src/Features/AutoInjectRappasoftAssets` (a Livewire `ComponentHook`). Uses Alpine.js (bundled by Livewire).
- **Service provider:** `src/LaravelLivewireTablesServiceProvider.php` — registers config (merged in both `register()` and `boot()` — redundant), translations (PHP or JSON via `use_json_translations`), `@tableloop` Blade directives, the view + Blade component namespace, the asset hook, and the `make:datatable` command. Publish tags: `livewire-tables-{translations,translations-json,config,views,public}`.
- **Config:** `config/livewire-tables.php` — `theme`, asset toggles (`cache_assets`, `inject_core_assets_enabled`, `inject_third_party_assets_enabled`, `enable_blade_directives`), `script_base_path` (hardcoded `/rappasoft/...`), `use_json_translations`, per-filter defaults, `events`.
- **Namespace:** still `Rappasoft\LaravelLivewireTables\`; composer package still `rappasoft/laravel-livewire-tables`. Rebrand decision is tracked in M6 (issue: "Neutralize vendor/namespace") and needs maintainer sign-off.

## Testing

- Currently **PHPUnit** on **Orchestra Testbench**; v4.0 **migrates to Pest** (early, in M2 — write all new tests in Pest). Base: `tests/TestCase.php` — self-seeds an SQLite DB from `database/migrations/create_test_tables.php.stub` and inserts Owner/Species/Breed/Pet/Veterinary fixtures in `setUp()`. **No `testbench.yaml` / `workbench/` yet** (added for v4 — see below).
- Test table components: `tests/Http/Livewire/` (`PetsTable`, `BreedsTable`, `SpeciesTable`, variants, `FailingTables/`). Parallel "visuals" suite under `tests/Visuals/`. Localisation suite under `tests/Localisations/`.
- Static analysis: Larastan/PHPStan (`phpstan.neon` + `phpstan-baseline.neon`), Psalm. Style: Pint (`pint.json`).

### Commands

```bash
composer install
composer test            # phpunit
composer format          # pint
vendor/bin/phpstan analyse
# v4 workbench demo (after M1 upgrade + composer install):
vendor/bin/testbench serve
```

## Workbench (v4)

A `workbench/` demo app + `testbench.yaml` are being introduced (milestone M2) so the package ships a runnable showcase of **every** column, filter, and feature across all three themes. It activates once dependencies are installed on the upgraded stack.

## Conventions & guardrails

- **Livewire 4 only.** Do not reintroduce LW3 constraints or LW3-internal classes (`ComponentParser`, `Livewire\...\MakeCommand` — removed in LW4). `wire:model` modifier bindings use `.live.blur` (LW4 changed modifier semantics so `.blur` alone also gates client-side sync).
- **PHP `^8.2`**, Laravel `^12|^13` (12 kept), Livewire `^4`, Testbench `^10|^11`. Namespace stays `Rappasoft\` for v4.0 (rebrand deferred). Tests are Pest. Workbench is package-dev only.
- Keep refactors behaviour-preserving; add/extend tests (and workbench demos) for every bug fixed.
- Match existing code style; run Pint before committing. Don't commit built/minified assets by hand once the Vite pipeline lands (M4).
- Don't run `composer update` / publish / push unless asked.

## Where to look

- Roadmap & rationale: `docs/v4/IMPLEMENTATION-PLAN.md`, `docs/v4/IMPROVEMENT-PROPOSAL.md`.
- Work items: GitHub issues, grouped by milestones **M1–M8**.
- Upgrade reference: upstream PR [#2324](https://github.com/rappasoft/laravel-livewire-tables/pull/2324) prototypes the L13/LW4 dependency + `MakeCommand` + `.live.blur` changes (we go further by dropping LW3).
