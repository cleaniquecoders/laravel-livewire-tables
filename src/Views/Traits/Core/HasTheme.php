<?php

namespace Rappasoft\LaravelLivewireTables\Views\Traits\Core;

use Livewire\Attributes\{Computed, Locked};

trait HasTheme
{
    #[Locked]
    public ?string $theme;

    public function getTheme(): string
    {
        return $this->theme ?? ($this->theme = config('livewire-tables.theme', 'tailwind'));
    }

    public function setTheme(string $theme): self
    {
        $this->theme = $theme;

        if (($theme === 'bootstrap-4' || $theme === 'bootstrap-5') && method_exists($this, 'setPaginationTheme')) {
            $this->setPaginationTheme('bootstrap');
        }

        return $this;
    }

    #[Computed]
    public function isTailwind(): bool
    {
        return ! $this->isBootstrap4() && ! $this->isBootstrap5();
    }

    /**
     * The "flux" theme is Tailwind-based (isTailwind() stays true so the table
     * body keeps rendering), with Flux UI components layered over the controls.
     */
    #[Computed]
    public function isFlux(): bool
    {
        return $this->getTheme() === 'flux';
    }

    /**
     * Whether to render the table body with real flux:table components.
     * flux:table cannot preserve reorder drag, clickable-row navigation,
     * responsive column collapsing, bulk-action columns, the loading
     * placeholder row, or the secondary header / footer rows, so fall back to
     * the (Flux-styled) raw table whenever any of those actually renders.
     * The secondary-header / footer status flags default to true, so they are
     * gated on the same condition the datatable view uses to emit those rows
     * (status enabled AND at least one column configured for them).
     */
    #[Computed]
    public function useFluxTable(): bool
    {
        return $this->isFlux()
            && ! $this->reorderIsEnabled()
            && ! $this->hasTableRowUrl()
            && ! $this->showBulkActionsSections()
            && ! $this->showCollapsingColumnSections()
            && ! $this->hasDisplayLoadingPlaceholder()
            && ! ($this->secondaryHeaderIsEnabled() && $this->hasColumnsWithSecondaryHeader())
            && ! ($this->footerIsEnabled() && $this->hasColumnsWithFooter());
    }

    #[Computed]
    public function isBootstrap(): bool
    {
        return $this->isBootstrap4() || $this->isBootstrap5();
    }

    #[Computed]
    public function isBootstrap4(): bool
    {
        return $this->getTheme() === 'bootstrap-4';
    }

    #[Computed]
    public function isBootstrap5(): bool
    {
        return $this->getTheme() === 'bootstrap-5';
    }
}
