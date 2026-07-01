# Flagship refactor plan (#23 theme strategy, #28 trait sprawl)

These two are the largest remaining v4 refactors. Both are **behaviour-preserving** and must be
done **incrementally, one suite-guarded slice per PR** — never big-bang. This doc is the roadmap so
each dedicated session starts with a plan.

Guardrails for both:

- Keep every slice green: `vendor/bin/pest` (1560+ tests, incl. the `tests/Visuals` per-theme suite)
  and `vendor/bin/phpstan analyse` after each change.
- One cohesive slice per commit; never leave the tree half-migrated.
- No behaviour change — if rendered output or public API shifts, the slice is wrong.

---

## #23 — Theme strategy: replace the 59-file inline `@if($isTailwind)` branching

**Problem.** Themes are inline `@if($isTailwind)/@elseif($isBootstrap)` branches across ~59 blades.
Adding or altering a theme touches all of them; Flux support was bolted on as a further branch.

**Target.** A theme *driver*: one class per theme implementing a `ThemeContract`, each exposing named
class strings. Blades ask the driver for classes instead of branching.

```
src/Themes/ThemeContract.php          // classesFor(string $key, array $ctx = []): string
src/Themes/TailwindTheme.php
src/Themes/Bootstrap4Theme.php
src/Themes/Bootstrap5Theme.php
src/Themes/FluxTheme.php               // extends TailwindTheme, overrides the Flux-specific keys
```

**Seam.** Add `$this->themeClasses(string $key, array $ctx = [])` on the component (a `HasTheme`
helper) that resolves the active driver via the existing theme detection and returns the class string.
A blade goes from:

```blade
@if ($isTailwind) <td class="px-6 py-4 …"> @elseif ($isBootstrap) <td class="…"> @endif
```

to:

```blade
<td class="{{ $this->themeClasses('table.td', ['collapse' => $column?->shouldCollapseAlways()]) }}">
```

**Class source.** Move the per-theme strings out of the blades into the driver classes (state-dependent
bits, e.g. collapse/clickable, become `$ctx` handled inside the driver). Keep the existing default
`@class` state keys (`default-styling`, `default-colors`) working.

**Migration order (one group per PR, smallest/safest first):**

1. Leaf column includes — `includes/columns/{boolean,color,icon,link,date}.blade.php`.
2. Cells & rows — `table/{td,tr,th}` and their `td/*`, `tr/*` partials.
3. Toolbar items — `tools/toolbar/items/{search-field,filter-button,column-select,bulk-actions,pagination-dropdown}`.
4. Filter views — `tools/filters/*`.
5. Table shell — `table.blade.php`, `thead`, `tbody`, `wrapper`.

**Tests.** The `tests/Visuals` suite asserts rendered HTML per theme — run after each blade. Add a
snapshot for any blade that lacks one *before* migrating it. Output must match byte-for-byte.

**BC.** Keep the `$isTailwind`/`$isBootstrap*` props available until the last blade is migrated; drop
them only in the final PR.

**Done when:** no `@if($isTailwind)` remains in blades, and adding a theme = adding one driver class.
This unblocks **#24** (the `ring-opacity-*` → color-alpha focus-ring fix lands in the drivers).

---

## #28 — Collapse trait sprawl & remove order-dependent `HasAllTraits`

**Problem.** `HasAllTraits` pulls ~26 `With*` traits in a **load-order-dependent** sequence (flagged
"Specific Order Below!"), on top of ~22 `*Configuration` + ~22 `*Helpers` + ~11 `*Styling` traits.
Each feature is smeared across a `With* + *Configuration + *Helpers + *Styling` quadruplet.

**Target.** One cohesive unit per feature; `HasAllTraits` composition is order-independent.

**Steps (in order):**

1. **Pin the surface first.** Add a characterization test asserting the full public method list of
   `DataTableComponent` (reflect over the composed class). This guards every later slice.
2. **Find the real order dependencies.** The "Specific Order" comment predates the current code —
   audit whether ordering still matters (usually it's property-default init or trait-method conflict
   resolution). Document each genuine dependency; most are likely spurious.
3. **Consolidate per feature.** For one feature at a time, merge its `With* + Configuration + Helpers
   + Styling` into a single trait (or a small Feature object). Start with the most self-contained:
   `Footer` → `SecondaryHeader` → `Search` → `Sorting` → `Pagination` → `Reordering` → `BulkActions`
   → `Columns`/`Filters` (most interdependent) last.
4. **Remove the ordering constraint.** Replace any real order dependency with an explicit boot step
   (a `bootedTables()` sequence) rather than relying on `use` order, then delete the
   "Specific Order Below!" comment.

**Tests.** Existing 1560-test suite + the new API-surface characterization test after every slice.

**Done when:** `HasAllTraits` has no order-dependency comment and each feature is one cohesive unit.
