@aware([ 'tableName','isTailwind','isBootstrap','isBootstrap4','isBootstrap5', 'localisationPath'])
@if ($isTailwind)
    <div class="@if ($this->getColumnSelectIsHiddenOnMobile()) hidden sm:block @elseif ($this->getColumnSelectIsHiddenOnTablet()) hidden md:block @endif mb-4 w-full md:w-auto md:mb-0 md:ml-2">
        <div
            x-data="{ open: false, childElementOpen: false }"
            @keydown.window.escape="if (!childElementOpen) { open = false }"
            x-on:click.away="if (!childElementOpen) { open = false }"
            class="inline-block relative w-full text-left md:w-auto"
            wire:key="{{ $tableName }}-column-select-button"
        >
            <div>
                <span class="rounded-md shadow-sm">
                    <button
                        x-on:click="open = !open"
                        type="button"
                        {{
                            $attributes->merge($this->getColumnSelectButtonAttributes())
                            ->class([
                                'inline-flex justify-center px-4 py-2 w-full text-sm font-medium border shadow-sm focus:ring focus:ring-opacity-50' => $this->getColumnSelectButtonAttributes()['default-styling'],
                                'rounded-md' => ! $this->isFlux() && $this->getColumnSelectButtonAttributes()['default-styling'],
                                'rounded-lg' => $this->isFlux() && $this->getColumnSelectButtonAttributes()['default-styling'],
                                'text-gray-700 bg-white border-gray-300 hover:bg-gray-50 focus:border-indigo-300 focus:ring-indigo-200 dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600' => ! $this->isFlux() && $this->getColumnSelectButtonAttributes()['default-colors'],
                                'text-zinc-700 bg-white border-zinc-200 hover:bg-zinc-50 focus:border-zinc-400 focus:ring-zinc-200 dark:bg-zinc-700 dark:text-white dark:border-zinc-600 dark:hover:bg-zinc-600' => $this->isFlux() && $this->getColumnSelectButtonAttributes()['default-colors'],
                            ])
                            ->except(['default-styling', 'default-colors'])
                        }}
                        aria-haspopup="true"
                        x-bind:aria-expanded="open"
                        aria-expanded="true"
                    >
                        {{ __($localisationPath.'Columns') }}

                        <x-heroicon-m-chevron-down class="-mr-1 ml-2 h-5 w-5" />
                    </button>
                </span>
            </div>

            <div
                x-cloak x-show="open"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                @class([
                    'absolute right-0 z-50 mt-2 w-full divide-y ring-1 shadow-lg origin-top-right md:w-48 focus:outline-none',
                    'rounded-md divide-gray-100 ring-black ring-opacity-5' => ! $this->isFlux(),
                    'rounded-lg divide-zinc-950/5 ring-zinc-950/10 dark:divide-white/10 dark:ring-white/10' => $this->isFlux(),
                ])
            >
                <div @class([
                    'bg-white shadow-xs dark:text-white',
                    'rounded-md dark:bg-gray-700' => ! $this->isFlux(),
                    'rounded-lg dark:bg-zinc-700' => $this->isFlux(),
                ])>
                    <div class="p-2" role="menu" aria-orientation="vertical"
                            aria-labelledby="column-select-menu"
                    >
                        @if ($this->isFlux())
                            <flux:checkbox
                                @checked($this->getSelectableSelectedColumns()->count() === $this->getSelectableColumns()->count())
                                wire:click="{{ $this->getSelectableSelectedColumns()->count() === $this->getSelectableColumns()->count() ? 'deselectAllColumns' : 'selectAllColumns' }}"
                                label="{{ __($localisationPath.'All Columns') }}"
                                class="mb-2"
                            />
                            <flux:checkbox.group wire:model.live="selectedColumns" class="space-y-1.5">
                                @foreach ($this->getColumnsForColumnSelect() as $columnSlug => $columnTitle)
                                    <flux:checkbox value="{{ $columnSlug }}" label="{{ $columnTitle }}" />
                                @endforeach
                            </flux:checkbox.group>
                        @else
                        <div wire:key="{{ $tableName }}-columnSelect-selectAll-{{ rand(0,1000) }}">
                            <label
                                wire:loading.attr="disabled"
                                class="inline-flex items-center px-2 py-1 disabled:opacity-50 disabled:cursor-wait"
                            >
                                <input
                                    {{
                                        $attributes->merge($this->getColumnSelectMenuOptionCheckboxAttributes())
                                        ->class([
                                            'transition duration-150 ease-in-out rounded shadow-sm focus:ring focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-wait' => $this->getColumnSelectMenuOptionCheckboxAttributes()['default-styling'],
                                            'text-indigo-600 border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 dark:bg-gray-900 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 dark:focus:bg-gray-600' => $this->getColumnSelectMenuOptionCheckboxAttributes()['default-colors'],
                                        ])
                                        ->except(['default-styling', 'default-colors'])
                                    }}
                                    wire:loading.attr="disabled"
                                    type="checkbox"@if($this->useClientSideColumnVisibilityIsEnabled()) x-on:click="{{ $this->getClientSideAllColumnsToggle() }}" x-bind:checked="{{ $this->getClientSideAllColumnsChecked() }}"@endif

                                    @unless($this->useClientSideColumnVisibilityIsEnabled())@checked($this->getSelectableSelectedColumns()->count() === $this->getSelectableColumns()->count())
                                    @if($this->getSelectableSelectedColumns()->count() === $this->getSelectableColumns()->count())  wire:click="deselectAllColumns" @else wire:click="selectAllColumns" @endif
@endunless
                                >
                                <span class="ml-2">{{ __($localisationPath.'All Columns') }}</span>
                            </label>
                        </div>

                        @foreach ($this->getColumnsForColumnSelect() as $columnSlug => $columnTitle)
                            <div
                                wire:key="{{ $tableName }}-columnSelect-{{ $loop->index }}"
                            >
                                <label
                                    wire:loading.attr="disabled"
                                    wire:target="selectedColumns"
                                    class="inline-flex items-center px-2 py-1 disabled:opacity-50 disabled:cursor-wait"
                                >
                                    <input
                                        {{
                                            $attributes->merge($this->getColumnSelectMenuOptionCheckboxAttributes())
                                            ->class([
                                                'transition duration-150 ease-in-out rounded shadow-sm focus:ring focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-wait' => $this->getColumnSelectMenuOptionCheckboxAttributes()['default-styling'],
                                                'text-indigo-600 border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 dark:bg-gray-900 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600 dark:focus:bg-gray-600' => $this->getColumnSelectMenuOptionCheckboxAttributes()['default-colors'],
                                            ])
                                            ->except(['default-styling', 'default-colors'])
                                        }}
                                        @unless($this->useClientSideColumnVisibilityIsEnabled())wire:model.live="selectedColumns" wire:target="selectedColumns"@else x-model="visibleColumns" @endunless

                                        wire:loading.attr="disabled" type="checkbox"
                                        value="{{ $columnSlug }}" />
                                    <span class="ml-2">{{ $columnTitle }}</span>
                                </label>
                            </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif ($isBootstrap)
    <div
        @class([
            $this->themeClasses('cs.wrapper.mobile') => $this->getColumnSelectIsHiddenOnMobile(),
            $this->themeClasses('cs.wrapper.tablet') => $this->getColumnSelectIsHiddenOnTablet(),
        ])
    >
        <div
            x-data="{ open: false, childElementOpen: false }"
            x-on:keydown.escape.stop="if (!childElementOpen) { open = false }"
            x-on:mousedown.away="if (!childElementOpen) { open = false }"
            @class([$this->themeClasses('cs.dropdown')])
            wire:key="{{ $tableName }}-column-select-button"
        >
            <button
                x-on:click="open = !open"
                {{
                    $attributes->merge($this->getColumnSelectButtonAttributes())
                    ->class([
                        'btn dropdown-toggle d-block w-100 d-md-inline' => $this->getColumnSelectButtonAttributes()['default-styling'],
                    ])
                    ->except(['default-styling', 'default-colors'])
                }}
                type="button" id="{{ $tableName }}-columnSelect" aria-haspopup="true"
                x-bind:aria-expanded="open"
            >
                {{ __($localisationPath.'Columns') }}
            </button>

            <div
                x-bind:class="{ 'show': open }"
                @class([$this->themeClasses('cs.menu')])
                aria-labelledby="columnSelect-{{ $tableName }}"
            >
                @if($isBootstrap4)
                    <div wire:key="{{ $tableName }}-columnSelect-selectAll-{{ rand(0,1000) }}">
                        <label wire:loading.attr="disabled" class="px-2 mb-1">
                            <input
                                wire:loading.attr="disabled"
                                type="checkbox"
                                @if($this->useClientSideColumnVisibilityIsEnabled()) x-on:click="{{ $this->getClientSideAllColumnsToggle() }}" x-bind:checked="{{ $this->getClientSideAllColumnsChecked() }}"@elseif($this->getSelectableSelectedColumns()->count() == $this->getSelectableColumns()->count()) checked wire:click="deselectAllColumns" @else unchecked wire:click="selectAllColumns" @endif
                            />

                            <span class="ml-2">{{ __($localisationPath.'All Columns') }}</span>


                        </label>
                    </div>
                @elseif($isBootstrap5)
                    <div class="form-check ms-2" wire:key="{{ $tableName }}-columnSelect-selectAll-{{ rand(0,1000) }}">
                        <input
                            wire:loading.attr="disabled"
                            type="checkbox"
                            {{
                                $attributes->merge($this->getColumnSelectMenuOptionCheckboxAttributes())
                                ->class([
                                    'form-check-input' => $this->getColumnSelectMenuOptionCheckboxAttributes()['default-styling'],
                                ])
                                ->except(['default-styling', 'default-colors'])
                            }}
                            @if($this->useClientSideColumnVisibilityIsEnabled()) x-on:click="{{ $this->getClientSideAllColumnsToggle() }}" x-bind:checked="{{ $this->getClientSideAllColumnsChecked() }}"@elseif($this->getSelectableSelectedColumns()->count() == $this->getSelectableColumns()->count()) checked wire:click="deselectAllColumns" @else unchecked wire:click="selectAllColumns" @endif
                        />

                        <label wire:loading.attr="disabled" class="form-check-label">
                            {{ __($localisationPath.'All Columns') }}
                        </label>
                    </div>
                @endif

                @foreach ($this->getColumnsForColumnSelect() as $columnSlug => $columnTitle)
                    <div
                        wire:key="{{ $tableName }}-columnSelect-{{ $loop->index }}"
                        @class([$this->themeClasses('cs.formcheck')])
                    >
                        @if ($isBootstrap4)
                            <label
                                wire:loading.attr="disabled"
                                wire:target="selectedColumns"
                                class="px-2 {{ $loop->last ? 'mb-0' : 'mb-1' }}"
                            >
                                <input
                                    @unless($this->useClientSideColumnVisibilityIsEnabled())wire:model.live="selectedColumns"
                                    wire:target="selectedColumns"@else x-model="visibleColumns" @endunless

                                    wire:loading.attr="disabled" type="checkbox"
                                    value="{{ $columnSlug }}"
                                />
                                <span class="ml-2">
                                    {{ $columnTitle }}
                                </span>
                            </label>
                        @elseif($isBootstrap5)
                            <input
                                @unless($this->useClientSideColumnVisibilityIsEnabled())wire:model.live="selectedColumns"
                                wire:target="selectedColumns"@else x-model="visibleColumns" @endunless

                                wire:loading.attr="disabled"
                                type="checkbox"
                                {{
                                    $attributes->merge($this->getColumnSelectMenuOptionCheckboxAttributes())
                                    ->class([
                                        'form-check-input' => $this->getColumnSelectMenuOptionCheckboxAttributes()['default-styling'],
                                    ])
                                    ->except(['default-styling', 'default-colors'])
                                }}
                                value="{{ $columnSlug }}"
                            />
                            <label
                                wire:loading.attr="disabled"
                                wire:target="selectedColumns"
                                class="{{ $loop->last ? 'mb-0' : 'mb-1' }} form-check-label"
                            >
                                {{ $columnTitle }}
                            </label>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
