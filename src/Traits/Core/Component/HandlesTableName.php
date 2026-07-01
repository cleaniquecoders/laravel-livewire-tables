<?php

namespace Rappasoft\LaravelLivewireTables\Traits\Core\Component;

use Livewire\Attributes\{Computed,Locked};

trait HandlesTableName
{
    #[Locked]
    public string $tableName = 'table';

    public function setTableName(string $name): self
    {
        $this->tableName = $name;

        return $this;
    }

    #[Computed]
    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function isTableNamed(string $name): bool
    {
        return $this->tableName === $name;
    }
}
