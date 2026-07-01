<?php

namespace Workbench\App\Livewire\Filters;

use Illuminate\Contracts\View\View;
use Livewire\Component;
use Rappasoft\LaravelLivewireTables\Views\Filters\Traits\IsExternalArrayFilter;
use Workbench\App\Models\Breed;

/**
 * Backing component for a LivewireComponentArrayFilter demo. IsExternalArrayFilter
 * wires the checkbox `$selectedItems` back to the table's array filter value. The
 * component owns its own option list (options passed to the filter are not
 * forwarded to the child), so we load them in mount().
 */
class ExternalBreedFilter extends Component
{
    use IsExternalArrayFilter;

    public function mount(): void
    {
        $this->selectOptions = Breed::orderBy('name')
            ->pluck('name', 'id')
            ->mapWithKeys(fn ($name, $id) => [(string) $id => $name])
            ->toArray();

        $this->selectedItems = array_map('strval', $this->value);
    }

    public function render(): View
    {
        return view('workbench::livewire.filters.external-breed-filter');
    }
}
