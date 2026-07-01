<x-workbench::layouts.app
    title="Multi-table page"
    current="multi-table"
    description="Two data tables on one page. Each sets a unique tableName, so their DOM ids never collide and reordering the top table only affects that table."
>
    <flux:callout icon="information-circle" variant="secondary" class="mb-6">
        <flux:callout.text>
            Regression demo for reordering on a multi-table page. Enable reorder on the top
            (<code>pets_reorderable</code>) table and drag its rows — only that table changes. The bottom
            table (<code>pets_browse</code>) is unaffected because each table has a distinct
            <code>tableName</code>. On a page with several tables, always give each one a unique
            <code>setTableName()</code>.
        </flux:callout.text>
    </flux:callout>

    <div class="space-y-8">
        <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
            <flux:heading size="lg" class="mb-3">Reorderable table</flux:heading>
            <livewire:multi-table-reorderable />
        </div>

        <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
            <flux:heading size="lg" class="mb-3">Sibling table</flux:heading>
            <livewire:multi-table-static />
        </div>
    </div>
</x-workbench::layouts.app>
