<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Illuminate\View\View;

trait WithCustomisations
{
    protected ?string $layout = null;

    protected ?string $slot = null;

    protected ?string $extends = null;

    protected ?string $section = null;

    public function renderingWithCustomisations(View $view, array $data = []): void
    {
        if ($this->hasLayout()) {
            $view->layout($this->getLayout());
        }

        if ($this->hasExtends()) {
            $view->extends($this->getExtends());
        }

        if ($this->hasSection()) {
            $view->section($this->getSection());
        }

        if ($this->hasSlot()) {
            $view->slot($this->getSlot());
        }

        $view = $view->with([
            'customView' => method_exists($this, 'customView') ? $this->customView() : '',
        ]);

    }

    // --- merged from CustomisationsConfiguration (#28) ---

    /**
     * Used to set a Custom Layout if using a Full Page Component approach.
     */
    public function setLayout(string $layout): self
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * Used to set a Custom Slot if using a Full Page Component approach
     */
    public function setSlot(string $slot): self
    {
        $this->slot = $slot;

        return $this;
    }

    /**
     * Used to set a Custom Extends Layout if using a Full Page Component approach
     */
    public function setExtends(string $extends): self
    {
        $this->extends = $extends;

        return $this;
    }

    /**
     * Used to set a Custom Layout Section if using a Full Page Component approach
     */
    public function setSection(string $section): self
    {
        $this->section = $section;

        return $this;
    }

    // --- merged from CustomisationsHelpers (#28) ---

    /**
     * Used to determine if a Layout Extends has been defined - used when using as a Full Page Component
     */
    public function hasExtends(): bool
    {
        return isset($this->extends);
    }

    public function getExtends(): ?string
    {
        return $this->extends;
    }

    /**
     * Used to determine if a Layout Section has been defined - used when using as a Full Page Component
     */
    public function hasSection(): bool
    {
        return isset($this->section);
    }

    public function getSection(): ?string
    {
        return $this->section;
    }

    /**
     * Used to determine if a Layout Slot has been defined - used when using as a Full Page Component
     */
    public function hasSlot(): bool
    {
        return isset($this->slot);
    }

    public function getSlot(): ?string
    {
        return $this->slot;
    }

    /**
     * Used to determine if a $layout has been defined - used when using as a Full Page Component
     */
    public function hasLayout(): bool
    {
        return isset($this->layout);
    }

    public function getLayout(): ?string
    {
        return $this->layout;
    }
}
