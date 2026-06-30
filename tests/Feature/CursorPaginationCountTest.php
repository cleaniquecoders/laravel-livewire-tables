<?php

use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTableCursor;
use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTableCursorNoCount;

use function Pest\Livewire\livewire;

/*
| Regression: #2186 — cursor pagination should not run a COUNT query when the
| total item count is not needed (it is irrelevant to cursor pagination).
*/

$ranCount = fn (): bool => collect(DB::getQueryLog())
    ->pluck('query')
    ->contains(fn ($q) => str_contains(strtolower($q), 'count('));

it('skips the count query on cursor pagination when totals are disabled', function () use ($ranCount) {
    DB::flushQueryLog();
    DB::enableQueryLog();

    livewire(PetsTableCursorNoCount::class);

    expect($ranCount())->toBeFalse();
});

it('still runs the count query on cursor pagination by default', function () use ($ranCount) {
    DB::flushQueryLog();
    DB::enableQueryLog();

    livewire(PetsTableCursor::class);

    expect($ranCount())->toBeTrue();
});
