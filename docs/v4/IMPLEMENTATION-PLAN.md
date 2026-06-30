# v4.0 Implementation Plan — Laravel 13 + Livewire 4

> Status: **proposal for review** (no implementation started). Tracked as GitHub milestones **M1–M8** and 43 issues in `cleaniquecoders/laravel-livewire-tables`.

## Goal

Ship **v4.0** of this fork as the go-to data-table package for new projects: Laravel 13 (+ 12), Livewire 4, **no Livewire 3**, with meaningful UX/UI, performance, simplicity, refactoring, and documentation improvements. Upstream marked Livewire 4 support `wontfix` ([#2315](https://github.com/rappasoft/laravel-livewire-tables/issues/2315)); this fork delivers it.

## Target support matrix

| Dependency | v3 (current) | **v4.0 (target)** |
|---|---|---|
| PHP | `^8.1–8.4` | `^8.2 | ^8.3 | ^8.4` |
| Laravel (`illuminate/*`) | `^10 | ^11 | ^12` | `^12 | ^13` |
| Livewire | `^3.0 | dev-main` | **`^4.0` only** |
| Testbench | `^7–^10` | `^10 | ^11` |
| PHPUnit | `^9–^12` | `^11 | ^12` |

> **Confirmed decisions (2026-06-30):** keep Laravel 12 alongside 13 · keep `Rappasoft\` namespace for v4.0 (rebrand deferred) · **migrate to Pest now** (early, in M2) · workbench is package-dev only (not published).

## Milestones

### M1 — Foundation: Laravel 13 + Livewire 4 (drop LW3) — *blocks everything*
The hard upgrade. Reference: upstream PR [#2324](https://github.com/rappasoft/laravel-livewire-tables/pull/2324).
1. Bump `composer.json` deps (matrix above); remove `^3.0|dev-main`.
2. `MakeCommand` — replace removed LW3 internals (`ComponentParser`, `LivewireMakeCommand`) with manual namespace/path resolution.
3. `wire:model` → `.live.blur` across search + all filters (`HandlesSearchModifiers`, `HasWireables`, 6 filter classes).
4. Audit asset auto-injection against LW4 `ComponentHook` API.
5. Re-validate Alpine/JS partials & morphing under LW4 (select-all, reorder, x-cloak, lazy placeholder).
6. Remove LW3 compat shims / version branches / `method_exists` bridges.

**Exit:** package installs and boots on a fresh Laravel 13 + Livewire 4 app; existing PHPUnit suite passes; PHPStan green.

### M2 — Testbench & Demo Workbench — *enables visual QA for all later work*
1. Add `testbench.yaml` + `workbench/` skeleton (app, routes, migrations, factories, seeders, layout).
2. **Migrate the test suite PHPUnit → Pest** (do this before M3/M5 add new tests so everything new is Pest-native).
3. Demo every column type (17).
4. Demo every filter type (12).
5. Demo all features × all 3 themes with a theme switcher.

**Exit:** `vendor/bin/testbench serve` renders a showcase of every component in Tailwind/BS4/BS5.

### M3 — Bug fixes from upstream backlog
Synthesized from the rappasoft tracker (every issue cross-referenced in the GitHub issue bodies):
- Sorting / `setDefaultSort` / multi-column sort / sort pills (#2313, #2225, #2184, #2268, #1998, #2276).
- Relations: BelongsTo/BelongsToMany/pivot returning null/empty (#2213, #2176, #2285, #2275, #2142).
- Filters: NumberFilter, MultiSelect "All", custom-filter snapshot, query-string persistence (#2229, #2030, #1999, #1992, #2309, #2299, #2033, #2187).
- Boolean filter + bulk-action dropdown rendering in Bootstrap (#2262, #2261, #2242, #2264, #2237).
- Translations not applying / custom override (#2167, #2029, #2070).
- Reorder loads wrong table (#2328, open).
- Lazy-load / Octane / `optimize` / init order (#2306, #2155, #2233, #2301, #2166, #2226).
- Collapsible columns on mobile (#2194, #2232).

**Exit:** each cluster reproduced in workbench + covered by regression tests; several may resolve naturally under LW4.

### M4 — Performance
- Skip COUNT on cursor pagination (#2186).
- Eager-loading / N+1 audit for relation & aggregate columns (#2220).
- Modernize asset pipeline (Vite, tree-shaking, dedupe, drop committed blobs).
- Large-dataset render & query-string footprint review.

### M5 — UX / UI
- Theme strategy refactor (replace 59-file inline branching).
- Tailwind 4 support (#2211, #2287, #2234).
- Accessibility pass (ARIA/`aria-sort`, keyboard nav, focus).
- Mobile responsiveness + loading/empty/pagination polish (#2251).
- Filter UX requests (enable/disable, inline markup, nullable row URL, etc.) (#2134, #2000, #2214, #2110, #2297, #2260).

### M6 — Refactoring & Developer Experience
- Collapse trait sprawl; remove order-dependent `HasAllTraits` (flagship refactor).
- Dedupe aggregate columns; rationalize date/select filter families.
- Service-provider cleanup (duplicate `mergeConfigFrom`, asset config block).
- Neutralize vendor/namespace + hardcoded paths (**maintainer decision**).
- Feature contracts; reduce `method_exists` probing.
- Optional: migrate PHPUnit → Pest.

### M7 — Documentation
- v4.0 migration guide (from v3 / from upstream).
- Rewrite `docs/` for LW4 + L13.
- Live examples powered by the workbench.
- Fix docs readability/dark-mode/blurry titles (#2281, #2311, #2323, #2294).
- README / CHANGELOG / CONTRIBUTING / rebrand + attribution notes.

### M8 — Release & CI
- CI matrix → PHP 8.2–8.4 × Laravel 12/13 × LW4.
- PHPStan/Larastan green; refresh baseline.
- Build assets in CI (Vite).
- v4.0.0 release process & Packagist.

## Sequencing & dependencies

```
M1 (Foundation) ──▶ M2 (Workbench) ──▶ M3 (Bugs)  ──┐
                                   └──▶ M5 (UX)   ──┤
M1 ──▶ M6 (Refactor) ───────────────────────────────┤──▶ M7 (Docs) ──▶ M8 (Release)
M1 ──▶ M4 (Performance) ─────────────────────────────┘
```

- **M1 first and alone** — nothing else is safe until the stack compiles on LW4.
- **M2 immediately after** — the workbench is the QA harness for M3/M5.
- M3/M4/M5/M6 proceed in parallel once M1+M2 land, each test- and workbench-guarded.
- M7 runs continuously but is finalized late; M8 closes the release.

## Risks

- **LW4 morphing/Alpine changes** can silently break interactive JS (reorder, select-all, popovers) — mitigated by the workbench + visuals suite.
- **Trait refactor (M6)** is high-blast-radius — do it incrementally behind a green test suite, not as a big-bang rewrite.
- **Namespace/rebrand** affects every consumer's `use` statements — needs an explicit BC decision before M6 starts.
