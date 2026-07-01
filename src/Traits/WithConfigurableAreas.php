<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

trait WithConfigurableAreas
{
    protected bool $hideConfigurableAreasWhenReorderingStatus = true;

    protected array $configurableAreas = [
        'before-tools' => null,
        'toolbar-left-start' => null,
        'toolbar-left-end' => null,
        'toolbar-right-start' => null,
        'toolbar-right-end' => null,
        'before-toolbar' => null,
        'after-toolbar' => null,
        'after-tools' => null,
        'before-pagination' => null,
        'after-pagination' => null,
    ];

    // --- merged from ConfigurableAreasConfiguration (#28) ---

    /**
     * Set all configurable areas to this array of configuration data
     *
     * @param  array<mixed>  $areas
     */
    public function setConfigurableAreas(array $areas): self
    {
        $this->configurableAreas = $areas;

        return $this;
    }

    /**
     * Configure a specific Configurable Area
     *
     * @param  array<mixed>  $config
     */
    public function setConfigurableArea(string $configurableArea, mixed $config): self
    {
        if (array_key_exists($configurableArea, $this->configurableAreas)) {
            $this->configurableAreas[$configurableArea] = $config;
        }

        return $this;
    }

    public function setHideConfigurableAreasWhenReorderingStatus(bool $status): self
    {
        $this->hideConfigurableAreasWhenReorderingStatus = $status;

        return $this;
    }

    public function setHideConfigurableAreasWhenReorderingEnabled(): self
    {
        $this->setHideConfigurableAreasWhenReorderingStatus(true);

        return $this;
    }

    public function setHideConfigurableAreasWhenReorderingDisabled(): self
    {
        $this->setHideConfigurableAreasWhenReorderingStatus(false);

        return $this;
    }

    // --- merged from ConfigurableAreasHelpers (#28) ---

    /**
     * @return array<mixed>
     */
    public function getConfigurableAreas(): array
    {
        return $this->configurableAreas;
    }

    public function hasConfigurableAreaFor(string $area): bool
    {
        if ($this->hideConfigurableAreasWhenReorderingIsEnabled() && $this->reorderIsEnabled() && $this->currentlyReorderingIsEnabled()) {
            return false;
        }

        return isset($this->configurableAreas[$area]) && $this->getConfigurableAreaFor($area) !== null;
    }

    public function getConfigurableAreaFor(string $area): ?string
    {
        $area = array_key_exists($area, $this->configurableAreas) ? $this->configurableAreas[$area] : null;

        if (is_array($area)) {
            return $area[0];
        }

        return $area;
    }

    public function getParametersForConfigurableArea(string $area): array
    {
        $area = array_key_exists($area, $this->configurableAreas) ? $this->configurableAreas[$area] : null;

        if (is_array($area) && isset($area[1]) && is_array($area[1])) {
            return $area[1];
        }

        return [];
    }

    public function getHideConfigurableAreasWhenReorderingStatus(): bool
    {
        return $this->hideConfigurableAreasWhenReorderingStatus;
    }

    public function hideConfigurableAreasWhenReorderingIsEnabled(): bool
    {
        return $this->getHideConfigurableAreasWhenReorderingStatus() === true;
    }

    public function hideConfigurableAreasWhenReorderingIsDisabled(): bool
    {
        return $this->getHideConfigurableAreasWhenReorderingStatus() === false;
    }
}
