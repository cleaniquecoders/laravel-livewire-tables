<x-workbench::layouts.app
    title="Features"
    current="features"
    description="Reordering, bulk actions, clickable row URLs, a secondary header, a footer, and responsive column collapsing. flux:table cannot express these, so the body falls back to the Flux-styled raw table."
>
    <flux:callout icon="information-circle" variant="secondary" class="mb-6">
        <flux:callout.text>
            This table intentionally uses features flux:table can't render, so it
            demonstrates the graceful fallback: still zinc-styled, but built on the
            package's own table markup rather than native Flux components.
        </flux:callout.text>
    </flux:callout>

    <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
        <livewire:features-table />
    </div>
</x-workbench::layouts.app>
