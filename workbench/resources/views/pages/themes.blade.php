<x-workbench::layouts.app
    title="Themes"
    current="themes"
    description="The same table rendered under each supported theme for side-by-side comparison."
>
    <div class="space-y-8">
        <section>
            <flux:heading size="lg" class="mb-3">Flux</flux:heading>
            <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                <livewire:flux-theme-table />
            </div>
        </section>

        <section>
            <flux:heading size="lg" class="mb-3">Tailwind</flux:heading>
            <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                <livewire:tailwind-theme-table />
            </div>
        </section>

        <section>
            <flux:heading size="lg" class="mb-3">Bootstrap 5</flux:heading>
            <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                <livewire:bootstrap-theme-table />
            </div>
        </section>
    </div>
</x-workbench::layouts.app>
