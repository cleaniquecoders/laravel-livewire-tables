<?php

namespace Workbench\App\Livewire\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\BooleanFilter;
use Workbench\App\Models\Pet;

/**
 * Adds a BooleanFilter and a bulk action to the Bootstrap theme demo tables so
 * their rendering (boolean filter markup, bulk-action dropdown) can be QA'd
 * across Bootstrap 4 and Bootstrap 5.
 */
trait BootstrapDemoFeatures
{
    public array $bulkActions = [
        'markVaccinated' => 'Mark Vaccinated',
    ];

    public function filters(): array
    {
        return [
            BooleanFilter::make('Vaccinated', 'vaccinated_filter')
                ->filter(fn (Builder $builder, string $value) => $builder->where('pets.is_vaccinated', (bool) $value)),
        ];
    }

    public function markVaccinated(): void
    {
        Pet::whereIn('id', $this->getSelected())->update(['is_vaccinated' => true]);

        $this->clearSelected();
    }
}
