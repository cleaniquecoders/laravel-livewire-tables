<?php

use Rappasoft\LaravelLivewireTables\Views\Columns\AggregateColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\AvgColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\CountColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\SumColumn;

it('sets the aggregate method via the parameterized using() alias', function () {
    expect(AggregateColumn::make('Total')->using('sum')->getAggregateMethod())->toBe('sum');
    expect(AggregateColumn::make('Average')->using('avg')->getAggregateMethod())->toBe('avg');
    expect(AggregateColumn::make('Total')->using('count')->getAggregateMethod())->toBe('count');
});

it('keeps the thin alias columns carrying their aggregate method', function () {
    expect(AvgColumn::make('Average')->getAggregateMethod())->toBe('avg');
    expect(CountColumn::make('Count')->getAggregateMethod())->toBe('count');
    expect(SumColumn::make('Total')->getAggregateMethod())->toBe('sum');
});

it('keeps the alias columns as AggregateColumn instances', function () {
    expect(AvgColumn::make('Average'))->toBeInstanceOf(AggregateColumn::class);
    expect(CountColumn::make('Count'))->toBeInstanceOf(AggregateColumn::class);
    expect(SumColumn::make('Total'))->toBeInstanceOf(AggregateColumn::class);
});
