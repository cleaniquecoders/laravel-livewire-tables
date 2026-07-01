<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

trait WithEvents
{
    protected array $eventStatuses = ['columnSelected' => true, 'searchApplied' => false, 'filterApplied' => false];

    // No Longer Used
    /**
     * @codeCoverageIgnore
     */
    public function setSortEvent(string $field, string $direction): void
    {
        $this->setSort($field, $direction);
    }

    // No Longer Used
    /**
     * @codeCoverageIgnore
     */
    public function clearSortEvent(): void
    {
        $this->clearSorts();
    }

    // No Longer Used
    /**
     * @codeCoverageIgnore
     */
    public function setFilterEvent(string $filter, string|array|null $value): void
    {
        $this->setFilter($filter, $value);
    }

    // No Longer Used
    /**
     * @codeCoverageIgnore
     */
    public function clearFilterEvent(): void
    {
        $this->setFilterDefaults();
    }

    // --- merged from EventConfiguration (#28) ---

    public function setEventStatus(string $event, bool $status): self
    {
        $this->eventStatuses[$event] = $status;

        return $this;
    }

    public function enableEvent(string $event): self
    {
        $this->setEventStatus($event, true);

        return $this;
    }

    public function disableEvent(string $event): self
    {
        $this->setEventStatus($event, false);

        return $this;
    }

    public function enableColumnSelectEvent(): self
    {
        $this->enableEvent('columnSelected');

        return $this;
    }

    public function disableColumnSelectEvent(): self
    {
        $this->disableEvent('columnSelected');

        return $this;
    }

    public function enableSearchAppliedEvent(): self
    {
        $this->enableEvent('searchApplied');

        return $this;
    }

    public function disableSearchAppliedEvent(): self
    {
        $this->disableEvent('searchApplied');

        return $this;
    }

    public function enableFilterAppliedEvent(): self
    {
        $this->enableEvent('filterApplied');

        return $this;
    }

    public function disableFilterAppliedEvent(): self
    {
        $this->disableEvent('filterApplied');

        return $this;
    }

    public function enableAllEvents(): self
    {
        foreach ($this->getEventNames() as $eventName) {
            $this->enableEvent($eventName);
        }

        return $this;
    }

    public function disableAllEvents(): self
    {
        foreach ($this->getEventNames() as $eventName) {
            $this->disableEvent($eventName);
        }

        return $this;
    }

    // --- merged from EventHelpers (#28) ---

    public function getEventStatus(string $event): bool
    {
        return $this->eventStatuses[$event] ?? false;
    }

    public function getEventStatusColumnSelect(): bool
    {
        return $this->getEventStatus('columnSelected');
    }

    public function getEventStatusSearchApplied(): bool
    {
        return $this->getEventStatus('searchApplied');
    }

    public function getEventStatusFilterApplied(): bool
    {
        return $this->getEventStatus('filterApplied');
    }

    public function getEventNames(): array
    {
        return ['columnSelected', 'searchApplied', 'filterApplied'];
    }

    public function getEventStatuses(): array
    {
        return [...['columnSelected' => true, 'searchApplied' => false, 'filterApplied' => false], ...$this->eventStatuses];
    }
}
