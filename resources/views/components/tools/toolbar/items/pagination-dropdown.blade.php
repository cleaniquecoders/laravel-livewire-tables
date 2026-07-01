@aware(['tableName', 'isTailwind', 'isBootstrap', 'isBootstrap4', 'isBootstrap5', 'localisationPath'])
@if ($this->isFlux())
    <flux:select wire:model.live="perPage" class="w-auto">
        @foreach ($this->getPerPageAccepted() as $item)
            <flux:select.option :value="$item">{{ $item === -1 ? __($localisationPath.'All') : $item }}</flux:select.option>
        @endforeach
    </flux:select>
@else
    <div @class([$this->themeClasses('toolbar.perpage.margin')])>
        <select wire:model.live="perPage" id="{{ $tableName }}-perPage"
            {{ $attributes->merge($this->getPerPageFieldAttributes())->class([
                    $this->themeClasses('toolbar.perpage.styling') => $this->getPerPageFieldAttributes()['default-styling'],
                    $this->themeClasses('toolbar.perpage.colors') => $isTailwind && $this->getPerPageFieldAttributes()['default-colors'],
                ])->except(['default', 'default-styling', 'default-colors']) }}>
            @foreach ($this->getPerPageAccepted() as $item)
                <option value="{{ $item }}" wire:key="{{ $tableName }}-per-page-{{ $item }}">
                    {{ $item === -1 ? __($localisationPath . 'All') : $item }}
                </option>
            @endforeach
        </select>
    </div>
@endif
