<?php

namespace Rappasoft\LaravelLivewireTables\Views\Filters\Traits;

use Carbon\Carbon;

/**
 * Shared validation, pill formatting, and input attributes for the single-value
 * date filters (DateFilter, DateTimeFilter). Each filter supplies only the
 * things that actually differ: the input date format, the HTML input type, and
 * a wire:key identifier.
 */
trait HandlesDateFilterFormatting
{
    abstract protected function inputDateFormat(): string;

    abstract protected function inputType(): string;

    abstract protected function wireKeyIdentifier(): string;

    /**
     * Fallback output (pill) format when none is configured. DateFilter falls
     * back to Y-m-d; DateTimeFilter keeps the previous no-fallback behaviour.
     */
    protected function outputDateFormatFallback(): ?string
    {
        return null;
    }

    public function validate(string $value): string|bool
    {
        $this->setInputDateFormat($this->inputDateFormat())
            ->setOutputDateFormat($this->getConfig('pillFormat') ?? $this->outputDateFormatFallback());

        $carbonDate = $this->createCarbonDate($value);

        if ($carbonDate instanceof Carbon) {
            return $carbonDate->format($this->inputDateFormat());
        }

        return false;
    }

    public function getFilterPillValue($value): ?string
    {
        if ($this->validate($value)) {
            $carbonDate = $this->createCarbonDate($value);

            if ($carbonDate instanceof Carbon) {
                return $this->outputTranslatedDate($carbonDate);
            }
        }

        return null;
    }

    protected function getCoreInputAttributes(): array
    {
        $attributes = array_merge(parent::getCoreInputAttributes(),
            [
                'min' => $this->hasConfig('min') ? $this->getConfig('min') : null,
                'max' => $this->hasConfig('max') ? $this->getConfig('max') : null,
                'placeholder' => $this->hasConfig('placeholder') ? $this->getConfig('placeholder') : null,
                'type' => $this->inputType(),
                'wire:key' => $this->generateWireKey($this->getGenericDisplayData()['tableName'], $this->wireKeyIdentifier()),
            ]);
        ksort($attributes);

        return $attributes;
    }
}
