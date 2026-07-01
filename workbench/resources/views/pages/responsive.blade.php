<x-workbench::layouts.app
    title="Responsive / collapsing columns"
    current="responsive"
    description="Columns collapse at tablet and mobile breakpoints. Resize the window narrow: collapsed columns hide and a +/- toggle appears to expand them per row."
>
    <flux:callout icon="information-circle" variant="secondary" class="mb-6">
        <flux:callout.text>
            Regression demo for collapsible columns on mobile (#18). Age &amp; Breed collapse on mobile,
            Species &amp; Owner collapse on tablet, and Vaccinated &amp; Last Visit always collapse. Narrow the
            viewport (or open your browser's device toolbar) and use the <strong>+</strong> toggle on each row.
        </flux:callout.text>
    </flux:callout>

    <div class="rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
        <livewire:responsive-table />
    </div>
</x-workbench::layouts.app>
