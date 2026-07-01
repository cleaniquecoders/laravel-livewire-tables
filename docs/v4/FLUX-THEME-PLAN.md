# Flux UI Theme — Conversion Plan (`resources/views`)

Goal: a first-class `flux` theme where the package's controls and table render with **free** Flux UI components. `HasTheme::isFlux()` gates it; `isTailwind()` stays true so shared logic keeps working.

## How `isFlux` reaches a view (pick the right form)
- **`@if ($this->isFlux())`** — any view under `components/` (rendered in the DataTableComponent context). Table body, toolbar, pills, column-select, etc.
- **`@if ($isFlux ?? false)`** — filter views only (`components/tools/filters/*`), rendered via `$filter->render()`. Supplied by `FilterGenericData` → `FilterConfiguration`.
- `tools/filter-label` gets neither today — must add `$isFlux` to its `@props` + pass from each filter call-site if we Flux-ify labels.

## Blade gotchas (learned)
- **No `wire:key` on a paired Flux tag inside a loop** (`flux:select.option`, `flux:checkbox`, `flux:table.cell`) — breaks Blade's component-tag compiler.
- **No `{!! ... !!}` raw echo inside a paired Flux opening tag** — same. Use clean `wire:model="..."` attributes.

## Phases

**Phase 1 — form controls · S · LOW (mostly done)**
Done: search (`flux:input`), per-page (`flux:select`), filters text/number (`flux:input`), select (`flux:select`), multi-select + column-select checkboxes (`flux:checkbox.group`).
Remaining: `filters/date`,`datetime` → `flux:input` date/datetime-local; `multi-select-dropdown` → `flux:select multiple`; `filter-label` → `flux:label`.

**Phase 2 — table body via `flux:table` · L · HIGH**
`table`→`flux:table`, `th`→`flux:table.column` (sortable), `tr`→`flux:table.row`, `td`→`flux:table.cell`.
Risk: reorder drag, even/odd striping, clickable-row `wire:navigate`, and responsive column-collapse all depend on the raw `<table>` DOM (ids, `rowpk`, `.rows[i]`, class diffing in `resources/js`). **Decision: render `flux:table` only when reorder + collapsing + clickable-rows are all disabled; otherwise keep the raw table with Flux-matching classes.** Resolve the `td` `wire:key`+`{!! !!}` gotcha first.

**Phase 3 — pills / loading / empty / pagination · M · MED**
`filter-pills`/`sorting-pills`/`filter-pill` → `flux:badge`; reset buttons → `flux:button`; `empty` → `flux:callout`; `loading` → `flux:skeleton`; pagination result text → `flux:text`.

**Phase 4 — dropdowns / buttons / boolean / edge columns · L · HIGH**
Toolbar `bulk-actions`/`filter-button`/`column-select` shells → `flux:dropdown`+`flux:menu`; `reorder-buttons`/`clear`/`actions` → `flux:button`; `boolean` filter → `flux:switch`; bulk header checkbox stays raw (Flux checkbox has no indeterminate); collapse toggles → `flux:icon`/`flux:button`.

## Leave custom (no free Flux equivalent)
`number-range` (dual range slider), `date-range`/`datetime` flatpickr filters.

## Behaviour that must survive every conversion
reorder drag+drop · even/odd striping · clickable-row URLs · collapsing columns · bulk-actions indeterminate + select-all banner + `wire:confirm` · boolean filter Alpine + reset · `wire:loading` guards · Alpine popover open/away/escape · all `wire:model` bindings (`perPage`,`search`,`selectedColumns`,`filterComponents.*`,`selected`).
