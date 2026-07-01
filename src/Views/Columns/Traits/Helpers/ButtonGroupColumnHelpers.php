<?php

namespace Rappasoft\LaravelLivewireTables\Views\Columns\Traits\Helpers;

use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\WireLinkColumn;

trait ButtonGroupColumnHelpers
{
    public function getButtons(): array
    {
        return collect($this->buttons)
            ->reject(fn ($button) => ! ($button instanceof LinkColumn || $button instanceof WireLinkColumn))
            ->toArray();
    }
}
