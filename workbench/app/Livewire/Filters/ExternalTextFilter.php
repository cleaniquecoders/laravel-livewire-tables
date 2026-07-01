<?php

namespace Workbench\App\Livewire\Filters;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\Views\Filters\Traits\IsExternalFilter;

/**
 * Backing component for a LivewireComponentFilter demo. The IsExternalFilter
 * trait exposes a Modelable `$value` that the table binds to, so updating it
 * here flows the value back into the table's filterComponents.
 */
class ExternalTextFilter extends Component
{
    use IsExternalFilter;

    public function render(): View
    {
        return view('workbench::livewire.filters.external-text-filter');
    }
}
