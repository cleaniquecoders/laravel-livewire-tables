@aware(['isTailwind','isBootstrap'])

@php($attributes = $attributes->merge(['wire:key' => 'empty-message-'.$this->getId()]))

@if ($this->useFluxTable())
    <flux:table.row>
        <flux:table.cell :colspan="$this->getColspanCount()" align="center">
            <flux:text class="py-8 text-base">{{ $this->getEmptyMessage() }}</flux:text>
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
