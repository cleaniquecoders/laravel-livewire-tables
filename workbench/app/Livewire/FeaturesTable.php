<?php

namespace Workbench\App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\DateColumn;
use Workbench\App\Models\Pet;

/**
 * Showcases table features that flux:table cannot express (reorder, bulk
 * actions, clickable rows, secondary header, footer, responsive collapsing),
 * so the body gracefully falls back to the Flux-styled raw table.
 */
class FeaturesTable extends DataTableComponent
{
    protected $model = Pet::class;

    public array $bulkActions = [
        'markVaccinated' => 'Mark Vaccinated',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTheme('flux')
            ->setSearchEnabled()
            ->setColumnSelectEnabled()
            ->setReorderEnabled()
            ->setDefaultReorderSort('sort_order')
            ->setTableRowUrl(fn ($row) => 'https://rappasoft.com/docs/laravel-livewire-tables')
            ->setTableRowUrlTarget(fn ($row) => '_blank')
            ->setPerPageAccepted([10, 25, 50]);
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable()
                ->secondaryHeader(fn () => 'Drag rows to reorder'),

            Column::make('Age', 'age')
                ->sortable()
                ->footer(fn ($rows) => 'Avg: '.round($rows->avg('age') ?? 0, 1)),

            Column::make('Species', 'species.name')
                ->sortable()
                ->collapseOnTablet(),

            Column::make('Breed', 'breed.name')
                ->collapseOnMobile(),

            BooleanColumn::make('Vaccinated', 'is_vaccinated'),

            DateColumn::make('Last Visit', 'last_visit')
                ->emptyValue('—')
                ->collapseOnMobile(),
        ];
    }

    public function markVaccinated(): void
    {
        Pet::whereIn('id', $this->getSelected())->update(['is_vaccinated' => true]);

        $this->clearSelected();
    }

    public function reorder($items): void
    {
        foreach ($items as $item) {
            Pet::where('id', $item['value'])->update(['sort_order' => $item['order']]);
        }
    }
}
