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
            <div class="flex justify-center items-center space-x-2 dark:bg-gray-800">
                <span class="font-medium py-8 text-gray-400 text-lg dark:text-white">{{ $this->getEmptyMessage() }}</span>
            </div>
        </td>
    </tr>
@elseif ($isBootstrap)
     <tr {{ $attributes }}>
        <td colspan="{{ $this->getColspanCount() }}">
            {{ $this->getEmptyMessage() }}
        </td>
    </tr>
@endif
