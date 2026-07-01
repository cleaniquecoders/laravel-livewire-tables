<x-workbench::layouts.app
    title="Flux theme"
    current="themes"
    description="The table on the Flux theme — this page loads Tailwind + Flux CSS/JS only."
>
    <div class="mb-4 flex items-center gap-2 text-sm">
        <flux:badge color="zinc"><x-workbench::icons.flux class="mr-1 h-3.5 w-3.5" /> Flux</flux:badge>
        <flux:button size="xs" variant="ghost" href="/themes/tailwind" target="_blank">
            <x-workbench::icons.tailwind class="mr-1 inline h-4 w-4" /> Tailwind
        </flux:button>
        <flux:button size="xs" variant="ghost" href="/themes/bootstrap4" target="_blank">
            <x-workbench::icons.bootstrap class="mr-1 inline h-4 w-4" /> Bootstrap 4
        </flux:button>
        <flux:button size="xs" variant="ghost" href="/themes/bootstrap" target="_blank">
            <x-workbench::icons.bootstrap class="mr-1 inline h-4 w-4" /> Bootstrap 5
        </flux:button>
    </div>

    <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
        <livewire:flux-theme-table />
    </div>
</x-workbench::layouts.app>
