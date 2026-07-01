# Product Specification

The v4.0 product specification for this fork of `rappasoft/laravel-livewire-tables`: a dynamic, configurable
data-table component for Laravel and Livewire.

## Overview

`laravel-livewire-tables` is a data-table component for Laravel applications built on Livewire. It provides sorting,
searching, filtering, pagination, bulk actions, row reordering, secondary headers, and footers, and is themeable across
Tailwind, Bootstrap 4, Bootstrap 5, and the new Flux theme.

This documentation describes the **cleaniquecoders/laravel-livewire-tables** fork targeting **v4.0**. The Composer
package name is still `rappasoft/laravel-livewire-tables` (the namespace and package rebrand is deferred to milestone
M6). The GitHub repository is `cleaniquecoders/laravel-livewire-tables`.

Architecturally, the entry point `src/DataTableComponent.php` is a thin abstract class extending
`Livewire\Component`; behaviour is composed via `src/Traits/HasAllTraits.php`, which pulls in roughly 26 `With*`
traits in a load-order-dependent sequence. Columns live under `src/Views/Columns/` (17 types, built from
`Column::make($title, $from)`) and filters under `src/Views/Filters/` (12 types). Blade views under
`resources/views/components/` are registered via `Blade::componentNamespace`.

## Problem it solves and why the fork exists

Building interactive tables in Laravel — sorting, filtering, pagination, bulk actions, reordering, and consistent
theming — is repetitive and error-prone. This package removes that boilerplate with a declarative, configurable
component.

The fork exists because upstream **declined Livewire 4 support**: issue `rappasoft#2315` was marked `wontfix`, and
upstream had not shipped Laravel 13 support. This fork delivers **v4.0**: Laravel 12/13 with Livewire 4, and it
**drops Livewire 3 entirely**. The goal is to become the data-table package used for future projects instead of
upstream.

## Target users

- Laravel developers who need production-ready data tables without hand-rolling sorting, filtering, and pagination.
- Teams standardising on **Livewire 4** and **Laravel 12/13** who cannot use the upstream package.
- Projects using the **Flux** UI toolkit that want a native-feeling Flux-themed table.
- Maintainers who value a test-guarded, incrementally refactorable codebase with a runnable demo workbench.

## In scope for v4.0

- **Laravel 12 and Laravel 13** support (`illuminate/* ^12|^13`).
- **Livewire 4** as the only supported Livewire version.
- **Drop Livewire 3** entirely, including LW3-internal classes and compatibility shims.
- A **new Flux theme** alongside Tailwind, Bootstrap 4, and Bootstrap 5.
- A **workbench demo app** (package-dev only) showcasing every column, filter, and feature across the themes.
- **Migration to Pest** for the test suite (done early, so all new tests are Pest-native).
- A **Vite pipeline** for building workbench assets (dev-only; not shipped in the published package).

## Out of scope

- **Namespace and package rebrand** — deferred to M6. The `Rappasoft\` namespace and `rappasoft/laravel-livewire-tables`
  package name are retained for v4.0 to keep drop-in backward compatibility.
- **Livewire 3 support** — removed and not reintroduced.

## Constraints

- Minimum **PHP 8.2**.
- **Livewire 4** only (no Livewire 3 constraints or internals).
- Test suite is **Pest 4** (PHPUnit 12 under the hood) on **Orchestra Testbench**.
- Code style enforced with **Pint**; static analysis with **Larastan/PHPStan (level 6)** and **Psalm**.

## Version and stack matrix

| Component | Requirement |
|---|---|
| PHP | `^8.2` (8.2, 8.3, 8.4) |
| Laravel (`illuminate/*`) | `^12` \| `^13` |
| Livewire | `^4` only (drops Livewire 3) |
| Orchestra Testbench | `^10` \| `^11` |
| Tests | Pest 4 (PHPUnit 12 under the hood) |
| Static analysis | Larastan / PHPStan (level 6) + Psalm |
| Code style | Pint |
| Themes | tailwind (default), bootstrap-4, bootstrap-5, flux |

## Success criteria

- **Green test suite** — all 1,535 tests passing on the v4.0 stack.
- **CI across PHP versions** — the matrix runs on PHP 8.2–8.4 with Laravel 12/13 and Livewire 4.
- **Feature parity plus the Flux theme** — every existing column, filter, and feature works under Livewire 4, and the
  new Flux theme renders correctly.

## Release status

The v4.0 release is **HELD**: no `v4.0.0` tag or Packagist publish yet, pending a maintainer decision.
