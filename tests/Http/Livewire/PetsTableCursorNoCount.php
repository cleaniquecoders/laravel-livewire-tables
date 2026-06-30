<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Http\Livewire;

class PetsTableCursorNoCount extends PetsTable
{
    public function configure(): void
    {
        parent::configure();

        $this->setPaginationMethod('cursor');
        $this->setShouldRetrieveTotalItemCountDisabled();
    }
}
