<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Closure;
use Rappasoft\LaravelLivewireTables\Views\Column;

trait WithFooter
{
    protected bool $footerStatus = true;

    protected bool $useHeaderAsFooterStatus = false;

    protected bool $columnsWithFooter = false;

    // --- merged from FooterConfiguration (#28) ---

    public function setFooterStatus(bool $status): self
    {
        $this->footerStatus = $status;

        return $this;
    }

    public function setFooterEnabled(): self
    {
        $this->setFooterStatus(true);

        return $this;
    }

    public function setFooterDisabled(): self
    {
        $this->setFooterStatus(false);

        return $this;
    }

    public function setUseHeaderAsFooterStatus(bool $status): self
    {
        $this->useHeaderAsFooterStatus = $status;

        return $this;
    }

    public function setUseHeaderAsFooterEnabled(): self
    {
        $this->setUseHeaderAsFooterStatus(true);

        return $this;
    }

    public function setUseHeaderAsFooterDisabled(): self
    {
        $this->setUseHeaderAsFooterStatus(false);

        return $this;
    }

    // --- merged from FooterHelpers (#28) ---

    public function hasColumnsWithFooter(): bool
    {
        return $this->columnsWithFooter === true;
    }

    public function getFooterStatus(): bool
    {
        return $this->footerStatus;
    }

    public function footerIsEnabled(): bool
    {
        return $this->getFooterStatus() === true;
    }

    public function footerIsDisabled(): bool
    {
        return $this->getFooterStatus() === false;
    }

    public function getUseHeaderAsFooterStatus(): bool
    {
        return $this->useHeaderAsFooterStatus;
    }

    public function useHeaderAsFooterIsEnabled(): bool
    {
        return $this->getUseHeaderAsFooterStatus() === true;
    }

    public function useHeaderAsFooterIsDisabled(): bool
    {
        return $this->getUseHeaderAsFooterStatus() === false;
    }

    // --- merged from HasFooterStyling (#28) ---

    protected ?Closure $footerTrAttributesCallback;

    protected ?Closure $footerTdAttributesCallback;

    /**
     * @param  mixed  $rows
     * @return array<mixed>
     */
    public function getFooterTrAttributes($rows): array
    {
        return isset($this->footerTrAttributesCallback) ? call_user_func($this->footerTrAttributesCallback, $rows) : ['default' => true];
    }

    /**
     * @param  mixed  $rows
     * @return array<mixed>
     */
    public function getFooterTdAttributes(Column $column, $rows, int $index): array
    {
        return isset($this->footerTdAttributesCallback) ? call_user_func($this->footerTdAttributesCallback, $column, $rows, $index) : ['default' => true];
    }

    public function setFooterTrAttributes(Closure $callback): self
    {
        $this->footerTrAttributesCallback = $callback;

        return $this;
    }

    public function setFooterTdAttributes(Closure $callback): self
    {
        $this->footerTdAttributesCallback = $callback;

        return $this;
    }
}
