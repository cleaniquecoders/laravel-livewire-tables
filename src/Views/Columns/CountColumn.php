<?php

namespace Rappasoft\LaravelLivewireTables\Views\Columns;

/**
 * Thin alias for AggregateColumn::make(...)->using('count').
 * The IsAggregateColumn trait and constructor are inherited from AggregateColumn.
 */
class CountColumn extends AggregateColumn
{
    public string $aggregateMethod = 'count';
}
