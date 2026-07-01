<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Closure;
use Rappasoft\LaravelLivewireTables\Views\Column;

trait WithSecondaryHeader
{
    protected bool $secondaryHeaderStatus = true;

    protected bool $columnsWithSecondaryHeader = false;

    // --- merged from SecondaryHeaderConfiguration (#28) ---

    public function setSecondaryHeaderStatus(bool $status): self
    {
        $this->secondaryHeaderStatus = $status;

        return $this;
    }

    public function setSecondaryHeaderEnabled(): self
    {
        $this->setSecondaryHeaderStatus(true);

        return $this;
    }

    public function setSecondaryHeaderDisabled(): self
    {
        $this->setSecondaryHeaderStatus(false);

        return $this;
    }

    // --- merged from SecondaryHeaderHelpers (#28) ---

    public function hasColumnsWithSecondaryHeader(): bool
    {
        return $this->columnsWithSecondaryHeader === true;
    }

    public function getSecondaryHeaderStatus(): bool
    {
        return $this->secondaryHeaderStatus;
    }

    public function secondaryHeaderIsEnabled(): bool
    {
        return $this->getSecondaryHeaderStatus() === true;
    }

    public function secondaryHeaderIsDisabled(): bool
    {
        return $this->getSecondaryHeaderStatus() === false;
    }

    // --- merged from HasSecondaryHeaderStyling (#28) ---

    protected ?Closure $secondaryHeaderTrAttributesCallback;

    protected ?Closure $secondaryHeaderTdAttributesCallback;

    /**
     * @param  mixed  $rows
     * @return array<mixed>
     */
    public function getSecondaryHeaderTrAttributes($rows): array
    {
        return isset($this->secondaryHeaderTrAttributesCallback) ? call_user_func($this->secondaryHeaderTrAttributesCallback, $rows) : ['default' => true];
    }

    /**
     * @param  mixed  $rows
     * @return array<mixed>
     */
    public function getSecondaryHeaderTdAttributes(Column $column, $rows, int $index): array
    {
        return isset($this->secondaryHeaderTdAttributesCallback) ? call_user_func($this->secondaryHeaderTdAttributesCallback, $column, $rows, $index) : ['default' => true];
    }

    public function setSecondaryHeaderTrAttributes(Closure $callback): self
    {
        $this->secondaryHeaderTrAttributesCallback = $callback;

        return $this;
    }

    public function setSecondaryHeaderTdAttributes(Closure $callback): self
    {
        $this->secondaryHeaderTdAttributesCallback = $callback;

        return $this;
    }
}
