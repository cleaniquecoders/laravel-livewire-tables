<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

trait WithRefresh
{
    /**
     * Whether to refresh the table at a certain interval or not
     * false is off
     * If it's an integer it will be treated as milliseconds (2000 = refresh every 2 seconds)
     * If it's a string it will call that function every 5 seconds unless it is 'keep-alive' or 'visible'.
     *
     * @var bool|string
     */
    protected $refresh = false;

    // --- merged from RefreshConfiguration (#28) ---

    public function setRefreshTime(int $time): self
    {
        $this->refresh = (string) $time;

        return $this;
    }

    public function setRefreshKeepAlive(): self
    {
        $this->refresh = 'keep-alive';

        return $this;
    }

    public function setRefreshVisible(): self
    {
        $this->refresh = 'visible';

        return $this;
    }

    public function setRefreshMethod(string $method): self
    {
        $this->refresh = $method;

        return $this;
    }

    // --- merged from RefreshHelpers (#28) ---

    public function hasRefresh(): bool
    {
        return $this->refresh !== false;
    }

    /**
     * @return bool|string
     */
    public function getRefreshStatus()
    {
        return $this->refresh;
    }

    public function getRefreshOptions(): ?string
    {
        if ($this->hasRefresh()) {
            if (is_numeric($this->getRefreshStatus())) {
                return '.'.$this->getRefreshStatus().'ms';
            }

            switch ($this->getRefreshStatus()) {
                case 'keep-alive':
                    return '.keep-alive';
                case 'visible':
                    return '.visible';
                default:
                    return '='.$this->getRefreshStatus();
            }
        }

        return null;
    }
}
