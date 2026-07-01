<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Http\Livewire;

/**
 * A table with a configurable area set, used to guard against the
 * "Call to getTableName() on null" regression in ConfigurableAreas.
 */
class PetsTableConfigurableAreas extends PetsTable
{
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setConfigurableAreas([
                'before-toolbar' => 'test',
            ]);
    }
}
