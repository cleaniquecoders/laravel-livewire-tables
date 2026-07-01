<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTable;

/*
| #28 — pins the ONE load-bearing ordering constraint in HasAllTraits so it can
| never be reordered by accident. Livewire fires boot{Trait}() in trait
| declaration order, and the setup chain configure() -> setColumns() ->
| setupColumnSelect() depends on that order. Reordering these three traits would
| otherwise fail ~174 tests with opaque errors; this test fails first, loudly,
| explaining exactly what broke.
*/

/**
 * The relative declaration order of the three boot-order-critical traits, read
 * from the HasAllTraits source (the order Livewire boots them in).
 */
function bootCriticalTraitPositions(): array
{
    $source = file_get_contents(
        dirname(__DIR__, 2).'/src/Traits/HasAllTraits.php'
    );

    return [
        'ComponentUtilities' => strpos($source, 'ComponentUtilities,'),
        'WithColumns' => strpos($source, 'WithColumns,'),
        'WithColumnSelect' => strpos($source, 'WithColumnSelect,'),
    ];
}

it('declares ComponentUtilities before WithColumns before WithColumnSelect', function () {
    $pos = bootCriticalTraitPositions();

    foreach ($pos as $trait => $offset) {
        expect($offset)->not->toBeFalse("HasAllTraits no longer declares {$trait} — the boot-order guard needs updating.");
    }

    expect($pos['ComponentUtilities'])
        ->toBeLessThan($pos['WithColumns'], 'ComponentUtilities must be declared before WithColumns: bootedComponentUtilities() runs configure(), which WithColumns::bootedWithColumns() depends on.');

    expect($pos['WithColumns'])
        ->toBeLessThan($pos['WithColumnSelect'], 'WithColumns must be declared before WithColumnSelect: setupColumnSelect() reads the columns built by bootedWithColumns().');
});

it('actually boots the chain in that order (configure -> columns -> column select)', function () {
    // A fully-booted table has columns built (WithColumns) and column-select
    // configured off them (WithColumnSelect) — both of which require configure()
    // (ComponentUtilities) to have run first. If the order were wrong, this state
    // could not be produced.
    $component = Livewire\Livewire::test(PetsTable::class)->assertOk();

    expect($component->instance()->getColumns()->count())->toBeGreaterThan(0);
});
