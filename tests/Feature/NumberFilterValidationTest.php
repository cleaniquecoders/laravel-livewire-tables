<?php

use Rappasoft\LaravelLivewireTables\Views\Filters\NumberFilter;

/*
| Regression: #2229 / #2030 / #1999 — NumberFilter must validate numeric
| strings (as they arrive from an <input type="number">) and reject
| non-numeric values. Confirmed fixed in this codebase; locked here.
*/

it('validates numeric strings and rejects non-numeric values', function () {
    $filter = NumberFilter::make('Breed ID', 'breed_id_filter');

    expect($filter->validate('20'))->toBe(20)
        ->and($filter->validate('20.5'))->toBe(20.5)
        ->and($filter->validate('abc'))->toBeFalse()
        ->and($filter->validate(''))->toBeFalse()
        ->and($filter->isEmpty('20'))->toBeFalse()
        ->and($filter->isEmpty('abc'))->toBeTrue();
});
