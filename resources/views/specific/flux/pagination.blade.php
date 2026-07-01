{{-- Flux theme pagination: generated from the tailwind view with a zinc (Flux) palette. --}}
<div>
    @if ($paginator->hasPages())
        @php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : $this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1)

        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
            <div class="flex justify-between flex-1 md:hidden">
                <span>
                    @if ($paginator->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-zinc-500 bg-white border border-zinc-200 cursor-default leading-5 rounded-lg dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
                            {!! __('pagination.previous') !!}
                        </span>
                    @else
                        <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-200 leading-5 rounded-lg hover:text-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-300 dark:focus:ring-zinc-600 focus:border-zinc-400 active:bg-zinc-100 active:text-zinc-700 transition ease-in-out duration-150 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:border-zinc-700 dark:hover:bg-zinc-700">
                            {!! __('pagination.previous') !!}
                        </button>
                    @endif
                </span>

                <span>
                    @if ($paginator->hasMorePages())
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.before" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-zinc-700 bg-white border border-zinc-200 leading-5 rounded-lg hover:text-zinc-500 focus:outline-none focus:ring-2 focus:ring-zinc-300 dark:focus:ring-zinc-600 focus:border-zinc-400 active:bg-zinc-100 active:text-zinc-700 transition ease-in-out duration-150 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:border-zinc-700 dark:hover:bg-zinc-700">
                            {!! __('pagination.next') !!}
                        </button>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-zinc-500 bg-white border border-zinc-200 cursor-default leading-5 rounded-lg dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
                            {!! __('pagination.next') !!}
                        </span>
                    @endif
                </span>
            </div>

            <div class="hidden md:flex-1 md:flex md:items-center md:justify-between">
                <div>
                    <span class="relative z-0 inline-flex rounded-lg shadow-sm">
                        <span>
                            {{-- Previous Page Link --}}
                            @if ($paginator->onFirstPage())
                                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                    <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-zinc-500 bg-white border border-zinc-200 cursor-default rounded-l-md leading-5 dark:bg-zinc-800 dark:text-white dark:border-zinc-700" aria-hidden="true">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                            @else
                                <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-zinc-500 bg-white border border-zinc-200 rounded-l-md leading-5 hover:text-zinc-400 focus:z-10 focus:outline-none focus:border-zinc-400 focus:ring-2 focus:ring-zinc-300 dark:focus:ring-zinc-600 active:bg-zinc-100 active:text-zinc-500 transition ease-in-out duration-150 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:border-zinc-700 dark:hover:bg-zinc-700" aria-label="{{ __('pagination.previous') }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @endif
                        </span>

                        {{-- Pagination Elements --}}
                        @if ($elements ?? null)
                            @foreach ($elements as $element)
                                {{-- "Three Dots" Separator --}}
                                @if (is_string($element))
                                    <span aria-disabled="true">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-zinc-700 bg-white border border-zinc-200 cursor-default leading-5 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">{{ $element }}</span>
                                    </span>
                                @endif

                                {{-- Array Of Links --}}
                                @if (is_array($element))
                                    @foreach ($element as $page => $url)
                                        <span wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page{{ $page }}">
                                            @if ($page == $paginator->currentPage())
                                                <span aria-current="page">
                                                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-zinc-500 bg-zinc-100 border border-zinc-200 cursor-default leading-5 dark:bg-zinc-600 dark:text-white dark:border-zinc-600">{{ $page }}</span>
                                                </span>
                                            @else
                                                <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-zinc-700 bg-white border border-zinc-200 leading-5 hover:text-zinc-500 focus:z-10 focus:outline-none focus:border-zinc-400 focus:ring-2 focus:ring-zinc-300 dark:focus:ring-zinc-600 active:bg-zinc-100 active:text-zinc-700 transition ease-in-out duration-150 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:border-zinc-700 dark:hover:bg-zinc-700" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                                    {{ $page }}
                                                </button>
                                            @endif
                                        </span>
                                    @endforeach
                                @endif
                            @endforeach
                        @endif

                        <span>
                            {{-- Next Page Link --}}
                            @if ($paginator->hasMorePages())
                                <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}.after" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-zinc-500 bg-white border border-zinc-200 rounded-r-md leading-5 hover:text-zinc-400 focus:z-10 focus:outline-none focus:border-zinc-400 focus:ring-2 focus:ring-zinc-300 dark:focus:ring-zinc-600 active:bg-zinc-100 active:text-zinc-500 transition ease-in-out duration-150 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:border-zinc-700 dark:hover:bg-zinc-700" aria-label="{{ __('pagination.next') }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @else
                                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                    <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-zinc-500 bg-white border border-zinc-200 cursor-default rounded-r-md leading-5 dark:bg-zinc-800 dark:text-white dark:border-zinc-700" aria-hidden="true">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                            @endif
                        </span>
                    </span>
                </div>
            </div>
        </nav>
    @endif
</div>
