<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Rappasoft\LaravelLivewireTables\Traits\Core\{HasCustomAttributes, HasLocalisations};
use Rappasoft\LaravelLivewireTables\Views\Traits\Core\HasTheme;

/**
 * Composes every feature trait onto the DataTableComponent.
 *
 * ORDER IS LOAD-BEARING — do not reorder blindly. Livewire fires trait lifecycle
 * hooks (boot{Trait}() / mount{Trait}()) in trait DECLARATION order, so the setup
 * sequence below is a real dependency, not cosmetic. The one hard constraint:
 *
 *   ComponentUtilities  →  WithColumns  →  WithColumnSelect
 *   (booted: configure) →  (setColumns) →  (setupColumnSelect, needs columns)
 *
 *   1. ComponentUtilities::bootedComponentUtilities() runs configure() and
 *      asserts the primary key — everything else assumes configure() has run.
 *   2. WithColumns::bootedWithColumns() builds $this->columns — must run after (1).
 *   3. WithColumnSelect::bootedWithColumnSelect() calls setupColumnSelect(), which
 *      reads the columns built in (2) — must run after (2).
 *
 * The remaining traits are order-independent (pure setters/getters/styling, or
 * updated{Prop}() hooks that fire on interaction rather than boot). The relative
 * order of the three traits above is pinned by tests/Feature/TraitBootOrderTest.php;
 * reordering them fails that test with an explanation instead of ~174 opaque failures.
 */
trait HasAllTraits
{
    use WithTableHooks;
    use HasLocalisations,
        WithLoadingPlaceholder,
        HasTheme,
        WithFilters;

    // --- Boot-order-critical block: keep ComponentUtilities → WithColumns → ...
    //     ... → WithColumnSelect in this relative order (see class docblock). ---
    use WithQuery,
        ComponentUtilities,
        WithActions,
        WithData,
        WithQueryString,
        WithColumns,
        WithSorting,
        WithSearch,
        WithPagination;
    use WithBulkActions,
        HasCustomAttributes,
        WithCollapsingColumns,
        WithColumnSelect,
        WithConfigurableAreas,
        WithCustomisations,
        WithDebugging,
        WithEvents,
        WithFooter,
        WithRefresh,
        WithReordering,
        WithSecondaryHeader,
        WithSessionStorage,
        WithTableAttributes,
        WithTools;
}
