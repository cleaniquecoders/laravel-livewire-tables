<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Http\Livewire;

class PetsTableCursor extends PetsTable
{
    public function configure(): void
    {
        parent::configure();

        $this->setPaginationMethod('cursor');
    }
}
