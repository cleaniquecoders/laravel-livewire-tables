<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Http\Livewire;

/**
 * The row URL callback returns a URL only for pet #1 and null for the rest, to
 * verify that null-URL rows do not render a (broken) clickable link.
 */
class PetsTableNullableRowUrl extends PetsTable
{
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableRowUrl(fn ($row) => $row->id === 1 ? 'https://example.test/pet/1' : null)
            ->setTableRowUrlTarget(fn ($row) => 'navigate');
    }
}
