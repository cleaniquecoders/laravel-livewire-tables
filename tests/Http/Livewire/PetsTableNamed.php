<?php

namespace Rappasoft\LaravelLivewireTables\Tests\Http\Livewire;

/**
 * A table with an explicit, non-default tableName. Used to assert DOM ids are
 * namespaced by tableName so several tables can coexist on one page without the
 * reorder/DOM-id collision that a shared default 'table' name causes.
 */
class PetsTableNamed extends PetsTable
{
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableName('custom_pets');
    }
}
