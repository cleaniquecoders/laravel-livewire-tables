<?php

namespace Rappasoft\LaravelLivewireTables\Views\Columns;

/**
 * Thin alias for AggregateColumn::make(...)->using('avg').
 * The IsAggregateColumn trait and constructor are inherited from AggregateColumn.
 */
class AvgColumn extends AggregateColumn
{
    public string $aggregateMethod = 'avg';
}
