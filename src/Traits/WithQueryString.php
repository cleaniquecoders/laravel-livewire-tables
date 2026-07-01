<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Livewire\Attributes\Locked;

trait WithQueryString
{
    #[Locked]
    public array $queryStringConfig = [
        'columns' => ['status' => false, 'alias' => null],
        'filters' => ['status' => true, 'alias' => null],
        'search' => ['status' => true, 'alias' => null],
        'sorts' => ['status' => true, 'alias' => null],
    ];

    #[Locked]
    public ?bool $queryStringStatus;

    protected ?string $queryStringAlias;

    /**
     * Set the custom query string array for this specific table
     *
     * @return array<mixed>
     */
    protected function queryStringWithQueryString(): array
    {

        if ($this->queryStringIsEnabled()) {
            return [
                $this->getTableName() => ['except' => null, 'history' => false, 'keep' => false, 'as' => $this->getQueryStringAlias()],
            ];
        }

        return [];
    }

    // --- merged from QueryStringConfiguration (#28) ---

    public function setupQueryStringStatus(): void
    {
        if (! $this->hasQueryStringStatus()) {
            $this->runCoreConfiguration();
            if (! $this->hasQueryStringStatus()) {
                $this->setQueryStringEnabled();
            }
        }
    }

    public function setQueryStringStatus(bool $status): self
    {
        $this->queryStringStatus = $status;

        return $this;
    }

    public function setQueryStringEnabled(): self
    {
        $this->setQueryStringStatus(true);

        return $this;
    }

    public function setQueryStringDisabled(): self
    {
        $this->setQueryStringStatus(false);

        return $this;
    }

    public function setQueryStringAlias(string $queryStringAlias): self
    {
        $this->queryStringAlias = $queryStringAlias;

        return $this;
    }

    protected function setQueryStringConfig(string $type, array $config): self
    {
        $this->queryStringConfig[$type] = array_merge($this->getQueryStringConfig($type), $config);

        return $this;
    }

    protected function setQueryStringConfigStatus(string $type, bool $status): self
    {
        return $this->setQueryStringConfig($type, ['status' => $status]);

    }

    protected function setQueryStringConfigAlias(string $type, string $alias): self
    {
        return $this->setQueryStringConfig($type, ['alias' => $alias]);
    }

    // --- merged from QueryStringHelpers (#28) ---

    public function hasQueryStringStatus(): bool
    {
        return isset($this->queryStringStatus);
    }

    public function getQueryStringStatus(): bool
    {
        return $this->queryStringStatus ?? true;
    }

    public function queryStringIsEnabled(): bool
    {
        $this->setupQueryStringStatus();

        return $this->getQueryStringStatus() === true;
    }

    public function queryStringIsDisabled(): bool
    {
        return $this->getQueryStringStatus() === false;
    }

    public function hasQueryStringAlias(): bool
    {
        return isset($this->queryStringAlias);
    }

    public function getQueryStringAlias(): string
    {
        return $this->queryStringAlias ?? $this->getTableName();
    }

    protected function getQueryStringConfig(string $type): array
    {
        return array_merge(['status' => null, 'alias' => null], ($this->queryStringConfig[$type] ?? []));
    }

    protected function hasQueryStringConfigStatus(string $type): bool
    {
        return isset($this->getQueryStringConfig($type)['status']);
    }

    protected function getQueryStringConfigStatus(string $type): bool
    {
        return $this->getQueryStringConfig($type)['status'] ?? $this->getQueryStringStatus();
    }

    protected function hasQueryStringConfigAlias(string $type): bool
    {
        return isset($this->getQueryStringConfig($type)['alias']);
    }

    protected function getQueryStringConfigAlias(string $type): string
    {
        return $this->getQueryStringConfig($type)['alias'] ?? $this->getQueryStringAlias().'-'.$type;
    }
}
