<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

trait WithDebugging
{
    /**
     * Dump table properties for debugging
     */
    protected bool $debugStatus = false;

    // --- merged from DebuggingConfiguration (#28) ---

    public function setDebugStatus(bool $status): self
    {
        $this->debugStatus = $status;

        return $this;
    }

    public function setDebugEnabled(): self
    {
        $this->setDebugStatus(true);

        return $this;
    }

    public function setDebugDisabled(): self
    {
        $this->setDebugStatus(false);

        return $this;
    }

    // --- merged from DebugHelpers (#28) ---

    public function getDebugStatus(): bool
    {
        return $this->debugStatus;
    }

    public function debugIsEnabled(): bool
    {
        return $this->getDebugStatus() === true;
    }

    public function debugIsDisabled(): bool
    {
        return $this->getDebugStatus() === false;
    }
}
