<x-workbench::layouts.tailwind title="Client-side columns">
    <div class="mb-6 rounded-md bg-blue-50 p-4 text-sm text-blue-800">
        #48 — client-side column visibility: every selectable column is rendered and the
        Columns dropdown toggles them instantly via Alpine <code>x-show</code>, with no
        Livewire round-trip per toggle. The selection still syncs (entangled) on the next
        Livewire request.
    </div>

    <livewire:client-side-columns-table />
</x-workbench::layouts.tailwind>
