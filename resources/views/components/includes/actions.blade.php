@aware(['isTailwind', 'isBootstrap'])
@php($actionWrapperAttributes = $this->getActionWrapperAttributes())
<div {{ $attributes
            ->merge($this->actionWrapperAttributes)
            ->class([
                $this->themeClasses('actions.wrapper') => ($actionWrapperAttributes['default-styling'] ?? true),
                'justify-start' => $this->getActionsPosition === 'left',
                'justify-center' => $this->getActionsPosition === 'center',
                'justify-end' => $this->getActionsPosition === 'right',
                'pl-2' => $this->showActionsInToolbar && $this->getActionsPosition === 'left',
                'pr-2' => $this->showActionsInToolbar && $this->getActionsPosition === 'right',
            ])
            ->except(['default','default-styling','default-colors'])
        }} >
    @foreach($this->getActions as $action)
        {{ $action->render() }}
    @endforeach
</div>
