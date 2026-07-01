@aware(['isTailwind','isBootstrap'])

@php($attributes = $attributes->merge(['wire:key' => 'empty-message-'.$this->getId()]))

@if ($this->useFluxTable())
    <flux:table.row>
        <flux:table.cell :colspan="$this->getColspanCount()">
            <div class="flex flex-col items-center justify-center gap-4 px-6 py-14 text-center">
                <span class="flex h-14 w-14 items-center justify-center rounded-full bg-zinc-100 ring-1 ring-zinc-950/5 dark:bg-white/5 dark:ring-white/10">
                    <x-heroicon-o-magnifying-glass class="h-7 w-7 text-zinc-400 dark:text-zinc-500" />
                </span>
                <div class="space-y-1">
                    <flux:heading size="sm">{{ __('No results found') }}</flux:heading>
                    <flux:text class="mx-auto max-w-sm text-zinc-500 dark:text-zinc-400">{{ $this->getEmptyMessage() }}</flux:text>
                </div>
            </div>
        </flux:table.cell>
    </flux:table.row>
@elseif ($isTailwind)
    <tr {{ $attributes }}>
        <td colspan="{{ $this->getColspanCount() }}">
            <div class="flex flex-col items-center justify-center gap-4 px-6 py-14 text-center dark:bg-gray-800">
                <span class="flex h-14 w-14 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700">
                    <x-heroicon-o-magnifying-glass class="h-7 w-7 text-gray-400 dark:text-gray-500" />
                </span>
                <div class="space-y-1">
                    <p class="text-base font-medium text-gray-700 dark:text-gray-200">{{ __('No results found') }}</p>
                    <p class="mx-auto max-w-sm text-sm text-gray-500 dark:text-gray-400">{{ $this->getEmptyMessage() }}</p>
                </div>
            </div>
        </td>
    </tr>
@elseif ($isBootstrap)
    <tr {{ $attributes }}>
        <td colspan="{{ $this->getColspanCount() }}" class="text-center py-5">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <x-heroicon-o-magnifying-glass class="mb-3 text-muted" style="width:2.5rem;height:2.5rem;" />
                <p class="h6 mb-1">{{ __('No results found') }}</p>
                <p class="text-muted small mb-0">{{ $this->getEmptyMessage() }}</p>
            </div>
        </td>
    </tr>
@endif
