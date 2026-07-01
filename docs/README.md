# Documentation

Documentation for the `cleaniquecoders/laravel-livewire-tables` fork (v4.0) — a dynamic, configurable
data-table component for Laravel + Livewire with sorting, searching, filtering, pagination, bulk
actions, reordering, and four themes (Tailwind, Bootstrap 4, Bootstrap 5, and the new Flux theme).

The documentation is organised into two parts: the **project documentation** (below, following the
numbered SDLC structure) and the existing **feature reference** for day-to-day usage.

## Project documentation

| Section | Contents |
|---|---|
| [00 · Product](00-product/README.md) | What the v4 fork is, why it exists, and the roadmap |
| [01 · Architecture](01-architecture/README.md) | Component design, the trait composition, theming, assets |
| [02 · Development](02-development/README.md) | Getting started, the workbench demo, testing, building components |
| [03 · Deployment](03-deployment/README.md) | Release process and checklist |
| [05 · Support](05-support/README.md) | FAQ, troubleshooting, and the v3 → v4 upgrade guide |

The Flux theme is the headline feature of v4.0 — see
[Architecture · Theming](01-architecture/02-theming.md) for a visual tour and
[Development · Workbench](02-development/02-workbench.md) for the runnable demo app.

## Feature reference

The full end-user reference for every feature:

- [Getting started](start/_index.md) — requirements, installation, configuration, rendering
- [Usage](usage/_index.md) — creating components, the query, configuration
- [Filters](filters/_index.md) — creating and applying filters, filter pills
- [Search](search/_index.md)
- [Pagination](pagination/_index.md)
- [Rows](rows/_index.md) — clickable rows
- [Bulk actions](bulk-actions/_index.md)
- [Reordering](reordering/_index.md)
- [Footer](footer/_index.md)
- [Miscellaneous](misc/_index.md) — tools, actions, lifecycle hooks, and more

## v4 planning documents

- [Migration guide (v3 → v4)](v4/MIGRATION.md)
- [Implementation plan](v4/IMPLEMENTATION-PLAN.md)
- [Improvement proposal](v4/IMPROVEMENT-PROPOSAL.md)
- [Flux theme plan](v4/FLUX-THEME-PLAN.md)
