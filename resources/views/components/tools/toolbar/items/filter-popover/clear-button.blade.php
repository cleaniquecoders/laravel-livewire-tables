@aware(['isTailwind','isBootstrap4','isBootstrap5', 'localisationPath'])
@php($lwtTheme = lwtThemeName($isFlux ?? false, $isBootstrap4 ?? false, $isBootstrap5 ?? false))
<button type="button" wire:click.prevent="setFilterDefaults" x-on:click="filterPopoverOpen = false" @class([lwtThemeClasses($lwtTheme,'clearbtn')])>
    {{ __($localisationPath.'Clear') }}
</button>