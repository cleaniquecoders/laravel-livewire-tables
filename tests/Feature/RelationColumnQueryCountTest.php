<?php

use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\Tests\Http\Livewire\PetsTableJoinRelations;

use function Pest\Livewire\livewire;

/*
| #20 — relation columns are resolved with joins, not lazy access, so rendering
| a table with several BelongsTo relation columns must not issue a query per row
| per relation (N+1). With the seeded rows a join resolves in a small constant
| number of queries, whereas lazy access would be roughly rows x relations.
*/

it('renders join-resolved relation columns without N+1 queries', function () {
    DB::flushQueryLog();
    DB::enableQueryLog();

    livewire(PetsTableJoinRelations::class);

    $queries = count(DB::getQueryLog());
    DB::disableQueryLog();

    // Three BelongsTo relations over the seeded rows: a join keeps this to a
    // handful of queries; an N+1 would be roughly rows x relations.
    expect($queries)->toBeLessThan(10);
});
