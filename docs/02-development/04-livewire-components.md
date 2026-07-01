# Livewire components

A datatable is a Livewire component that extends
`Rappasoft\LaravelLivewireTables\DataTableComponent` — a thin abstract class that composes all behaviour
from the `With*` traits in `src/Traits/HasAllTraits.php`. At minimum you implement two methods:
`configure()` (component-wide setup, run once) and `columns()` (the column definitions).

## A minimal component

```php
<?php

namespace App\Livewire;

use App\Models\Pet;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class PetsTable extends DataTableComponent
{
    protected $model = Pet::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable(),

            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            Column::make('Species', 'species.name')
                ->sortable(),
        ];
    }
}
```

The second argument to `Column::make($title, $from)` is the attribute (or dot-notated relationship path)
the column reads from. Beyond the base `Column`, the package ships typed columns such as `BooleanColumn`,
`ColorColumn`, `DateColumn`, `ImageColumn`, `LinkColumn`, and the `Count` / `Sum` / `Avg` aggregate
columns. See [Creating columns](../04-reference/03-columns/creating-columns.md) and the
[Column types reference](../04-reference/04-column-types/README.md) for the full list.

## Adding filters

Declare a `filters()` method returning filter objects from
`Rappasoft\LaravelLivewireTables\Views\Filters`. Each filter's `filter()` closure receives the query
builder and the selected value(s) and returns a constrained builder:

```php
<?php

use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

public function filters(): array
{
    return [
        TextFilter::make('Name')
            ->filter(fn ($builder, string $value) => $builder->where('pets.name', 'like', "%{$value}%")),

        SelectFilter::make('Species')
            ->options(['' => 'All'] + Species::pluck('name', 'id')->toArray())
            ->filter(fn ($builder, string $value) => $builder->where('pets.species_id', $value)),
    ];
}
```

The available filter types include `TextFilter`, `NumberFilter`, `SelectFilter`, `MultiSelectFilter`,
`MultiSelectDropdownFilter`, `BooleanFilter`, `DateFilter`, `DateTimeFilter`, and `DateRangeFilter`. See
[Creating filters](../04-reference/05-filters/creating-filters.md) and
[Applying filters](../04-reference/05-filters/applying-filters.md).

## Search, pagination, and column select

These features are toggled inside `configure()` by chaining setters. Mark individual columns
`->searchable()` to make them participate in search:

```php
public function configure(): void
{
    $this->setPrimaryKey('id')
        ->setSearchEnabled()
        ->setColumnSelectEnabled()
        ->setPaginationEnabled()
        ->setPerPageAccepted([10, 25, 50])
        ->setPerPage(25);
}
```

For deeper options, see [Search](../04-reference/07-search/README.md),
[Column selection](../04-reference/03-columns/column-selection.md), and [Pagination](../04-reference/09-pagination/README.md). Related
row and interaction features are documented under [Rows](../04-reference/10-rows/clickable-rows.md).

## Switching themes

The table supports four themes: `tailwind` (default), `bootstrap-4`, `bootstrap-5`, and the new `flux`
theme. Set the theme in `configure()` with `setTheme()`:

```php
public function configure(): void
{
    $this->setPrimaryKey('id')
        ->setTheme('flux');
}
```

The `flux` theme is Tailwind-based: `isFlux()` returns true while `isTailwind()` also stays true so the
table body keeps rendering, with Flux UI components layered over the controls (search becomes
`flux:input`, per-page becomes `flux:select`, filter and sorting pills become `flux:badge`, and so on).

The native `flux:table` body is used only when none of the following is active: reordering, a clickable
row URL, bulk actions, collapsing columns, the loading placeholder, a secondary header (with columns), or
a footer (with columns). When any of those is present, the theme falls back to a Flux-zinc-styled version
of the package's own table. This decision is exposed by the computed `useFluxTable()` method on
`HasTheme`.

The `flux` theme uses `livewire/flux` v2 — the free, directory-based component package — which is already
pulled in as a dev dependency for the workbench and tests.
