<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Http\Livewire;

class PetsTableDefaultPerPage extends PetsTable
{
    public function configure(): void
    {
        parent::configure();

        $this->setDefaultPerPage(25);
    }
}
