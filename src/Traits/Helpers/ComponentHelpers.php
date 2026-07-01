<?php

namespace Rappasoft\LaravelLivewireTables\Traits\Helpers;

use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;

trait ComponentHelpers
{
    public function hasModel(): bool
    {
        return $this->model !== null;
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

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    #[Computed]
    public function getTableId(): string
    {
        return $this->getTableAttributes()['id'] ?? 'table-'.$this->getTableName();
    }
}
