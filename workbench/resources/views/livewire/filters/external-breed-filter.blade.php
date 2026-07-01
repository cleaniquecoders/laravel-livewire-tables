<div>
    <flux:checkbox.group wire:model.live="selectedItems" class="space-y-1.5">
        @foreach ($selectOptions as $id => $name)
            <flux:checkbox value="{{ $id }}" label="{{ $name }}" />
        @endforeach
    </flux:checkbox.group>
</div>
