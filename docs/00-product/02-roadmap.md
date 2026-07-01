# Roadmap

The v4.0 roadmap for the `cleaniquecoders/laravel-livewire-tables` fork, organised as GitHub milestones M1–M8. This
page summarises the milestones and phases from the [implementation plan](03-implementation-plan.md). The release
milestone (M8) is currently **HELD** — no `v4.0.0` tag or Packagist publish yet.

## Milestones

| Milestone | Focus | Status |
|---|---|---|
| M1 | Foundation — Laravel 13 (+ 12) and Livewire 4, drop Livewire 3; blocks everything | Done |
| M2 | Testbench and demo workbench; migrate the test suite PHPUnit to Pest | Done |
| M3 | Bug fixes from the upstream backlog (sorting, relations, filters, translations, reorder) | Planned |
| M4 | Performance — skip COUNT on cursor pagination, N+1 audit, Vite asset pipeline | Planned |
| M5 | UX / UI — theme strategy refactor, Tailwind 4, accessibility, mobile, polish | In progress |
| M6 | Refactoring and developer experience — collapse trait sprawl, dedupe classes, contracts | Planned |
| M7 | Documentation — v4 migration guide, docs rewrite, live workbench examples | In progress |
| M8 | Release and CI — CI matrix, PHPStan green, build assets, v4.0.0 release | Held |

## Phase summary

The roadmap is sequenced around a single hard dependency: nothing is safe until the stack compiles on Livewire 4.

- **Foundation (M1).** The hard upgrade: bump dependencies to Laravel 12/13 and Livewire 4, remove Livewire 3
  internals, rework `make:datatable`, switch `wire:model` bindings to `.live.blur`, and re-validate asset injection and
  Alpine/JS partials under Livewire 4. This milestone runs first and alone.
- **Workbench (M2).** Add `testbench.yaml` and a `workbench/` demo app, migrate the test suite from PHPUnit to Pest
  (early, before later milestones add new tests), and demonstrate every column, filter, and feature across the themes.
  The workbench is the QA harness for the parallel milestones that follow.
- **Parallel work (M3–M6).** Once M1 and M2 land, bug fixes (M3), performance (M4), UX/UI (M5), and refactoring (M6)
  proceed in parallel, each test- and workbench-guarded. M5 includes the theme strategy refactor that replaces the
  inline per-theme branching across roughly 59 Blade files. M6 targets the trait sprawl and near-duplicate columns and
  filters, done incrementally behind a green suite rather than as a big-bang rewrite.
- **Documentation (M7).** Runs continuously and is finalised late: a v4 migration guide (Livewire 3 to 4, `.live.blur`,
  `make:datatable`, namespace and paths), a docs rewrite for Livewire 4 and Laravel 13, and live examples backed by the
  workbench.
- **Release (M8) — HELD.** Closes the release: the CI matrix across PHP 8.2–8.4 with Laravel 12/13 and Livewire 4,
  green PHPStan/Larastan with a refreshed baseline, Vite asset builds in CI, and the v4.0.0 release to Packagist. This
  milestone is held pending a maintainer decision — no tag or publish has happened yet.

## Confirmed decisions

- Keep **Laravel 12** alongside Laravel 13 (`illuminate/* ^12|^13`).
- Keep the **`Rappasoft\` namespace** for v4.0; the rebrand is deferred to a later major.
- **Migrate to Pest now**, folded into M2, so all new tests are Pest-native.
- The **workbench is package-dev only** — a local QA and dev harness, not a published demo site.
