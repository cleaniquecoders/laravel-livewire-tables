<?php

namespace Rappasoft\LaravelLivewireTables\Views\Filters;

use Rappasoft\LaravelLivewireTables\Views\Filter;
use Rappasoft\LaravelLivewireTables\Views\Filters\Traits\{HandlesDateFilterFormatting, HandlesDates, HasConfig, HasWireables, IsStringFilter};

class DateTimeFilter extends Filter
{
    use HandlesDateFilterFormatting;
    use HandlesDates,
        HasConfig,
        IsStringFilter;
    use HasWireables;

    public string $wireMethod = 'live';

    protected string $view = 'livewire-tables::components.tools.filters.datetime';

    protected string $configPath = 'livewire-tables.dateTimeFilter.defaultConfig';

    protected function inputDateFormat(): string
    {
        return 'Y-m-d\TH:i';
    }

    protected function inputType(): string
    {
        return 'datetime-local';
    }

    protected function wireKeyIdentifier(): string
    {
        return 'datetime';
    }
}
