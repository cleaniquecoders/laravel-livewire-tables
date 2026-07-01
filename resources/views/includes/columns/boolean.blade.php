@php($lwtTheme = ($isTailwind ?? true) ? 'tailwind' : 'bootstrap-5')
@if($isToggleable && $toggleMethod !== '')
    <button wire:click="{{ $toggleMethod }}('{{ $rowPrimaryKey }}')"
    @if($hasConfirmMessage) wire:confirm="{{ $confirmMessage }}" @endif
>
@endif
    @if ($status)
        @if ($type === 'icons')
            @if ($successValue === true)
                <x-heroicon-o-check-circle
                    @class([lwtThemeClasses($lwtTheme,'column.boolean.success')])
                />
            @else
                <x-heroicon-o-check-circle @class([lwtThemeClasses($lwtTheme,'column.boolean.danger')])
                />
            @endif
        @elseif ($type === 'yes-no')
            @if ($successValue === true)
                <span>Yes</span>
            @else
                <span>No</span>
            @endif
        @endif
    @else
        @if ($type === 'icons')
            @if ($successValue === false)
                <x-heroicon-o-x-circle @class([lwtThemeClasses($lwtTheme,'column.boolean.success')])
                />
            @else
                <x-heroicon-o-x-circle @class([lwtThemeClasses($lwtTheme,'column.boolean.danger')])
                />
            @endif
        @elseif ($type === 'yes-no')
            @if ($successValue === false)
                <span>Yes</span>
            @else
                <span>No</span>
            @endif
        @endif
    @endif
@if($isToggleable && $toggleMethod !== '')
    </button>
@endif
