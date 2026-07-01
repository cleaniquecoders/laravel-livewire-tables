<x-workbench::layouts.app
    title="Pagination modes"
    current="pagination"
    description="The three pagination strategies plus a non-paginated table, all on the Flux theme."
>
    <div class="space-y-8">
        <section>
            <flux:heading size="lg" class="mb-3">Simple (previous / next)</flux:heading>
            <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                <livewire:simple-pagination-table />
            </div>
        </section>

        <section>
            <flux:heading size="lg" class="mb-3">Cursor</flux:heading>
            <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                <livewire:cursor-pagination-table />
            </div>
        </section>

        <section>
            <flux:heading size="lg" class="mb-3">None (all rows, capped)</flux:heading>
            <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                <livewire:no-pagination-table />
            </div>
        </section>
    </div>
</x-workbench::layouts.app>
