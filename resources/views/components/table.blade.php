@aware([ 'tableName','isTailwind','isBootstrap'])

@php
    $customAttributes = [
        'wrapper' => $this->getTableWrapperAttributes(),
        'table' => $this->getTableAttributes(),
        'thead' => $this->getTheadAttributes(),
        'tbody' => $this->getTbodyAttributes(),
    ];
@endphp

@if ($this->useFluxTable())
    <flux:table>
        <flux:table.columns>
            {{ $thead }}
        </flux:table.columns>
        <flux:table.rows>
            {{ $slot }}
        </flux:table.rows>
    </flux:table>
@else
    {{-- #23: Tailwind + Bootstrap share one structure; class strings come from the
         active theme via themeClasses() instead of @if($isTailwind) branches. --}}
    <div
        wire:key="{{ $tableName }}-twrap"
        {{ $attributes->merge($customAttributes['wrapper'])
            ->class([$this->themeClasses('table.wrapper') => $customAttributes['wrapper']['default'] ?? true])
            ->except(['default','default-styling','default-colors']) }}
    >
        <table
            wire:key="{{ $tableName }}-table"
            {{ $attributes->merge($customAttributes['table'])
                ->class([$this->themeClasses('table.element') => $customAttributes['table']['default'] ?? true])
                ->except(['default','default-styling','default-colors']) }}
        >
            <thead wire:key="{{ $tableName }}-thead"
                {{ $attributes->merge($customAttributes['thead'])
                    ->class([$this->themeClasses('table.thead') => $customAttributes['thead']['default'] ?? true])
                    ->except(['default','default-styling','default-colors']) }}
            >
                <tr>
                    {{ $thead }}
                </tr>
            </thead>

            <tbody
                wire:key="{{ $tableName }}-tbody"
                id="{{ $tableName }}-tbody"
                {{ $attributes->merge($customAttributes['tbody'])
                        ->class([$this->themeClasses('table.tbody') => $customAttributes['tbody']['default'] ?? true])
                        ->except(['default','default-styling','default-colors']) }}
            >
                {{ $slot }}
            </tbody>

            @isset($tfoot)
                <tfoot wire:key="{{ $tableName }}-tfoot">
                    {{ $tfoot }}
                </tfoot>
            @endisset
        </table>
    </div>
@endif
