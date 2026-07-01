<?php

namespace Rappasoft\LaravelLivewireTables\Views;

use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\Views\Filters\Traits\IsFilter;

abstract class Filter
{
    use IsFilter;

    protected string $view = '';

    public function __construct(string $name, ?string $key = null)
    {
        $this->name = $name;

        if ($key) {
            $this->key = $key;
        } else {
            $this->key = Str::snake($name);
        }
        $this->config([]);
    }

    /**
     * @return static
     */
    public static function make(string $name, ?string $key = null): Filter
    {
        return new static($name, $key);
    }

    /**
     * Default for every filter. External (Livewire-component) filters override
     * this via IsLivewireComponentFilter, so callers no longer need to probe
     * with method_exists().
     */
    public function isAnExternalLivewireFilter(): bool
    {
        return false;
    }

    /**
     * Default pill-value separator. Array filters override this via
     * IsArrayFilter; keeping a base default removes the method_exists() probe.
     */
    public function getPillsSeparator(): string
    {
        return ', ';
    }
}
