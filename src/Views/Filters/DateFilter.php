<?php

namespace Rappasoft\LaravelLivewireTables\Views\Filters;

use Rappasoft\LaravelLivewireTables\Views\Filter;
use Rappasoft\LaravelLivewireTables\Views\Filters\Traits\{HandlesDateFilterFormatting, HandlesDates, HasConfig, HasWireables, IsStringFilter};

class DateFilter extends Filter
{
    use HandlesDateFilterFormatting;
    use HandlesDates,
        HasConfig,
        IsStringFilter;
    use HasWireables;

    public string $wireMethod = 'live';

    protected string $view = 'livewire-tables::components.tools.filters.date';

    protected string $configPath = 'livewire-tables.dateFilter.defaultConfig';

    protected function inputDateFormat(): string
    {
        return 'Y-m-d';
    }

    protected function inputType(): string
    {
        return 'date';
    }

    protected function wireKeyIdentifier(): string
    {
        return 'date';
    }

    protected function outputDateFormatFallback(): ?string
    {
        return 'Y-m-d';
    }
}
