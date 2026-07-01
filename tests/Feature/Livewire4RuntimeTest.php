<?php

use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTableConfigurableAreas;

use function Pest\Livewire\livewire;

/*
| #17 — runtime/stability regression coverage. The upstream PHP errors
| ("Call to getTableName() on null" in ConfigurableAreas, "$columns accessed
| before initialization", php artisan optimize) should stay resolved under
| Livewire 4. (Octane and lazy-load browser warnings need a real runtime and
| are validated separately.)
*/

it('renders a table with a configurable area without error', function () {
    livewire(PetsTableConfigurableAreas::class)
        ->assertSee('test');
});

it('ships a config that is safe for config:cache (no closures)', function () {
    // php artisan optimize / config:cache fails when a config value is a Closure.
    $hasClosure = function ($value) use (&$hasClosure): bool {
        if ($value instanceof Closure) {
            return true;
        }

        if (is_array($value)) {
            foreach ($value as $item) {
                if ($hasClosure($item)) {
                    return true;
                }
            }
        }

        return false;
    };

    expect($hasClosure(config('livewire-tables')))->toBeFalse();
});
