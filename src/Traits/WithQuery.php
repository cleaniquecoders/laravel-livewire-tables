<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;

trait WithQuery
{
    protected Builder $builder;

    protected ?string $primaryKey;

    protected array $relationships = [];

    protected array $additionalSelects = [];

    protected array $extraWiths = [];

    protected array $extraWithCounts = [];

    protected array $extraWithSums = [];

    protected array $extraWithAvgs = [];

    protected bool $eagerLoadAllRelationsStatus = false;

    // --- merged from QueryConfiguration (#28) ---

    public function setBuilder(Builder $builder): void
    {
        $this->builder = $builder;
    }

    public function setPrimaryKey(?string $key): self
    {
        $this->primaryKey = $key;

        return $this;
    }

    /**
     * Allows adding a single set of additional selects to the query
     */
    public function setAdditionalSelects(string|array $selects): self
    {
        if (! is_array($selects)) {
            $selects = [$selects];
        }

        $this->additionalSelects = $selects;

        return $this;
    }

    /**
     * Allows appending more additional selects
     */
    public function addAdditionalSelects(string|array $selects): self
    {
        if (! is_array($selects)) {
            $selects = [$selects];
        }
        $this->additionalSelects = [...$this->additionalSelects, ...$selects];

        return $this;
    }

    public function setExtraWiths(array $extraWiths): self
    {
        $this->extraWiths = $extraWiths;

        return $this;
    }

    public function addExtraWith(string $extraWith): self
    {
        $this->extraWiths[] = $extraWith;

        return $this;
    }

    public function addExtraWiths(array $extraWiths): self
    {
        $this->extraWiths = [...$this->extraWiths, ...$extraWiths];

        return $this;
    }

    public function setExtraWithCounts(array $extraWithCounts): self
    {
        $this->extraWithCounts = $extraWithCounts;

        return $this;
    }

    public function addExtraWithCount(string $extraWithCount): self
    {
        $this->extraWithCounts[] = $extraWithCount;

        return $this;
    }

    public function addExtraWithCounts(array $extraWithCounts): self
    {
        $this->extraWithCounts = [...$this->extraWithCounts, ...$extraWithCounts];

        return $this;
    }

    public function addExtraWithSum(string $relationship, string $column): self
    {
        $this->extraWithSums[] = ['table' => $relationship, 'field' => $column];

        return $this;
    }

    public function addExtraWithAvg(string $relationship, string $column): self
    {
        $this->extraWithAvgs[] = ['table' => $relationship, 'field' => $column];

        return $this;
    }

    public function setEagerLoadAllRelationsStatus(bool $status): self
    {
        $this->eagerLoadAllRelationsStatus = $status;

        return $this;
    }

    public function setEagerLoadAllRelationsEnabled(): self
    {
        $this->setEagerLoadAllRelationsStatus(true);

        return $this;
    }

    public function setEagerLoadAllRelationsDisabled(): self
    {
        $this->setEagerLoadAllRelationsStatus(false);

        return $this;
    }

    // --- merged from QueryHelpers (#28) ---

    public function getBuilder(): Builder
    {
        if (! isset($this->builder)) {
            $this->setBuilder($this->builder());
        }

        return $this->builder;
    }

    public function hasPrimaryKey(): bool
    {
        return isset($this->primaryKey);
    }

    /**
     * @return mixed
     */
    #[Computed]
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @return array<mixed>
     */
    public function getRelationships(): array
    {
        return $this->relationships;
    }

    /**
     * @return array<mixed>
     */
    public function getAdditionalSelects(): array
    {
        return $this->additionalSelects;
    }

    public function hasExtraWiths(): bool
    {
        return ! empty($this->extraWiths);
    }

    public function getExtraWiths(): array
    {
        return $this->extraWiths;
    }

    public function hasExtraWithCounts(): bool
    {
        return ! empty($this->extraWithCounts);
    }

    public function getExtraWithCounts(): array
    {
        return $this->extraWithCounts;
    }

    public function hasExtraWithSums(): bool
    {
        return ! empty($this->extraWithSums);
    }

    public function getExtraWithSums(): array
    {
        return $this->extraWithSums;
    }

    public function hasExtraWithAvgs(): bool
    {
        return ! empty($this->extraWithAvgs);
    }

    public function getExtraWithAvgs(): array
    {
        return $this->extraWithAvgs;
    }

    public function getEagerLoadAllRelationsStatus(): bool
    {
        return $this->eagerLoadAllRelationsStatus;
    }

    public function eagerLoadAllRelationsIsEnabled(): bool
    {
        return $this->getEagerLoadAllRelationsStatus() === true;
    }

    public function eagerLoadAllRelationsIsDisabled(): bool
    {
        return $this->getEagerLoadAllRelationsStatus() === false;
    }
}
