<?php

namespace Rappasoft\LaravelLivewireTables\Views\Columns;

/**
 * Thin alias for AggregateColumn::make(...)->using('sum').
 * The IsAggregateColumn trait and constructor are inherited from AggregateColumn.
 */
class SumColumn extends AggregateColumn
{
    public string $aggregateMethod = 'sum';
}
