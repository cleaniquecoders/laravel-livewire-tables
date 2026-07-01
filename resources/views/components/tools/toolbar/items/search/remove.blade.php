
@aware(['isTailwind', 'isBootstrap'])
@php($lwtTheme = ($isTailwind ?? true) ? 'tailwind' : 'bootstrap-5')

<div @class([lwtThemeClasses($lwtTheme,'searchremove.wrapper')])>
    <div
        wire:click="clearSearch"

        @class([lwtThemeClasses($lwtTheme,'searchremove.button')])
    >
        @if($isTailwind)
        <x-heroicon-m-x-mark class='w-4 h-4' />
        @else
        <x-heroicon-m-x-mark class="laravel-livewire-tables-btn-smaller" />
        @endif
    </div>
</div>
