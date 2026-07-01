<x-workbench::layouts.app
    title="Empty state"
    current="empty"
    description="A table whose query returns no rows, previewing the Flux empty-state row."
>
    <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
        <livewire:empty-state-table />
    </div>
</x-workbench::layouts.app>
