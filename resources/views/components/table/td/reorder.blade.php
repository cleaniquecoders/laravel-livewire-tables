@aware([ 'tableName', 'isTailwind', 'isBootstrap', 'isBootstrap4', 'isBootstrap5', 'localisationPath'])
@props(['rowID', 'rowIndex'])

{{-- The drag handle is also keyboard-operable (#25): focus it (Tab) while
     reordering and move the row with ArrowUp/ArrowDown. --}}
<x-livewire-tables::table.td.plain x-cloak x-show="currentlyReorderingStatus" wire:key="{{ $tableName }}-tbody-reorder-{{ $rowID }}" :displayMinimisedOnReorder="false"
    role="button"
    aria-label="{{ __(($localisationPath ?? 'livewire-tables::core.').'Reorder') }}"
    x-bind:tabindex="currentlyReorderingStatus ? 0 : -1"
    x-on:keydown.arrow-up.prevent.stop="moveRow(event, -1)"
    x-on:keydown.arrow-down.prevent.stop="moveRow(event, 1)">
    <svg
        x-cloak x-show="currentlyReorderingStatus"
        xmlns="http://www.w3.org/2000/svg"
        fill="none" stroke="currentColor"
        viewBox="0 0 24 24"
        @class([$this->themeClasses('td.reorder.svg')])
        @style([
            'width:1em; height:1em;' => ($isBootstrap4 || $isBootstrap5),
        ])
    >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</x-livewire-tables::table.td.plain>
