<x-workbench::layouts.app
    title="Filter types"
    current="filters"
    description="Text, number, boolean, select, multi-select, multi-select dropdown, date, and date-time filters in the popover layout. Open “Filters” to try them."
>
    <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
        <livewire:filter-types-table />
    </div>
</x-workbench::layouts.app>
