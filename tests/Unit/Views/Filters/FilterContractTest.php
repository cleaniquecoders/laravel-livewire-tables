<?php

use Rappasoft\LaravelLivewireTables\Views\Filters\LivewireComponentFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

/*
| #34 — every Filter now answers isAnExternalLivewireFilter() and
| getPillsSeparator() via base defaults, so callers no longer probe with
| method_exists().
*/

it('answers isAnExternalLivewireFilter() on every filter without probing', function () {
    expect(TextFilter::make('Name')->isAnExternalLivewireFilter())->toBeFalse();
    expect(MultiSelectFilter::make('Breed')->isAnExternalLivewireFilter())->toBeFalse();
    expect(LivewireComponentFilter::make('External')->isAnExternalLivewireFilter())->toBeTrue();
});

it('provides a pills separator on every filter', function () {
    expect(TextFilter::make('Name')->getPillsSeparator())->toBe(', ');
    expect(MultiSelectFilter::make('Breed')->getPillsSeparator())->toBeString();
});
