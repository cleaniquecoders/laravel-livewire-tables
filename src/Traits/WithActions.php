<?php

namespace Rappasoft\LaravelLivewireTables\Traits;

use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Rappasoft\LaravelLivewireTables\Views\Action;

trait WithActions
{
    protected bool $displayActionsInToolbar = false;

    protected string $actionsPosition = 'right';

    protected ?Collection $validActions;

    protected function actions(): array
    {
        return [];
    }

    // --- merged from ActionsConfiguration (#28) ---

    public function setActionsInToolbar(bool $status): self
    {
        $this->displayActionsInToolbar = $status;

        return $this;
    }

    public function setActionsInToolbarEnabled(): self
    {
        return $this->setActionsInToolbar(true);
    }

    public function setActionsInToolbarDisabled(): self
    {
        return $this->setActionsInToolbar(false);
    }

    protected function setActionsPosition(string $position): self
    {
        $this->actionsPosition = ($position == 'left' || $position == 'center' || $position == 'right') ? $position : 'right';

        return $this;
    }

    public function setActionsLeft(): self
    {
        return $this->setActionsPosition('left');
    }

    public function setActionsCenter(): self
    {
        return $this->setActionsPosition('center');
    }

    public function setActionsRight(): self
    {
        return $this->setActionsPosition('right');
    }

    // --- merged from ActionsHelpers (#28) ---

    #[Computed]
    public function showActionsInToolbarLeft(): bool
    {
        return $this->hasActions() && $this->showActionsInToolbar() && $this->getActionsPosition() === 'left';
    }

    #[Computed]
    public function showActionsInToolbarRight(): bool
    {
        return $this->hasActions() && $this->showActionsInToolbar() && $this->getActionsPosition() === 'right';
    }

    #[Computed]
    public function showActionsInToolbar(): bool
    {
        return $this->displayActionsInToolbar ?? false;
    }

    #[Computed]
    public function getActionsPosition(): string
    {
        return $this->actionsPosition ?? 'right';
    }

    #[Computed]
    public function hasActions(): bool
    {
        if (! isset($this->validActions)) {
            $this->validActions = $this->getActions();
        }

        return $this->validActions->count() > 0;
    }

    #[Computed]
    public function getActions(): Collection
    {
        if (! isset($this->validActions)) {
            $this->validActions = (new Collection($this->actions()))
                ->filter(fn ($action) => $action instanceof Action)
                ->each(function (Action $action, int $key) {
                    $action->setTheme($this->getTheme());
                });
        }

        return $this->validActions;
    }

    // --- merged from HasActionsStyling (#28) ---

    protected array $actionWrapperAttributes = ['class' => '', 'default-styling' => true, 'default-colors' => true];

    #[Computed]
    public function getActionWrapperAttributes(): array
    {
        return [...['class' => '', 'default-styling' => true, 'default-colors' => true], ...$this->actionWrapperAttributes];
    }

    public function setActionWrapperAttributes(array $actionWrapperAttributes): self
    {
        $this->actionWrapperAttributes = [...$this->actionWrapperAttributes, ...$actionWrapperAttributes];

        return $this;
    }
}
