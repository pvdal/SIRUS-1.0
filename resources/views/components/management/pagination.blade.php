<div class="flex justify-center mt-6 pb-10" x-show="{{ $totalPages }} > 1">
    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
        {{-- Botão Anterior --}}
        <button @click="{{ $pageVar }} > 1 && {{ $loadFunction  }}({{ $pageVar }} - 1)"
                x-bind:disabled="{{ $pageVar }} === 1"
                x-bind:class="{{ $pageVar }} === 1 ? 'text-gray-300 dark:text-gray-500 cursor-default' : 'text-gray-500 dark:text-gray-300  hover:bg-gray-50 dark:hover:bg-opacity-80'"
                class="relative inline-flex items-center rounded-l-md px-2 py-2 ring-1 ring-inset ring-gray-300 focus:z-10 focus:outline-offset-0 dark:ring-gray-700 bg-white dark:bg-gray-800">
            <span class="sr-only">Anterior</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                      clip-rule="evenodd"/>
            </svg>
        </button>

        {{-- Primeira página --}}
        <button @click="{{ $loadFunction }}(1)"
                x-bind:class="{{ $pageVar }} === 1
                    ? 'relative z-10 inline-flex items-center bg-primary-blue dark:bg-secondary-blue px-4 py-2 text-sm font-semibold text-white focus:z-20'
                    : 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10 dark:text-gray-200 dark:ring-gray-700 dark:hover:bg-opacity-80 bg-white dark:bg-gray-800'">
            1
        </button>

        <div class="hidden sm:inline-flex">
            {{-- Reticências iniciais --}}
            <span x-show="{{ $pageVar }} > 3"
                  class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 bg-white dark:bg-gray-700 dark:ring-gray-700 dark:text-gray-300">...</span>
        </div>

        {{-- Páginas próximas à atual --}}
        <template x-for="n in Array.from({length: {{ $totalPages }}}, (_, i) => i + 1)
                        .filter(n => n > 1 && n < {{ $totalPages }} && Math.abs(n - {{ $pageVar }}) <= 1)" :key="n">
            <button @click="{{ $loadFunction }}(n)"
                    x-bind:class="{{ $pageVar }} === n
                        ? 'relative z-10 inline-flex items-center bg-primary-blue dark:bg-secondary-blue px-4 py-2 text-sm font-semibold text-white focus:z-20'
                        : 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10 bg-white dark:bg-gray-800 dark:ring-gray-700 dark:hover:bg-opacity-80  dark:text-gray-300'"
                    x-text="n">
            </button>
        </template>
        <div class="hidden sm:inline-flex">
            {{-- Reticências finais --}}
            <span x-show="{{ $pageVar }} < {{ $totalPages }} - 2"
                  class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 bg-white dark:bg-gray-700 dark:ring-gray-700 dark:text-gray-300">...</span>
        </div>
        {{-- Última página --}}
        <button x-show="{{ $totalPages }} > 1" @click="{{ $loadFunction  }}({{ $totalPages }})"
                x-bind:class="{{ $pageVar }} === {{ $totalPages }}
                    ? 'relative z-10 inline-flex items-center bg-primary-blue dark:bg-secondary-blue px-4 py-2 text-sm font-semibold text-white focus:z-20'
                    : 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10 dark:text-gray-200 dark:ring-gray-700 dark:hover:bg-opacity-80 bg-white dark:bg-gray-800'"
                x-text="{{ $totalPages }}">
        </button>

        {{-- Botão Próximo --}}
        <button @click="{{ $pageVar }} < {{$totalPages }} && {{ $loadFunction  }}({{ $pageVar }} + 1)"
                x-bind:disabled="{{ $pageVar }} === {{ $totalPages }}"
                x-bind:class="{{ $pageVar }} === {{ $totalPages }} ? 'text-gray-300 dark:text-gray-500 cursor-default' : 'text-gray-500 dark:text-gray-300  hover:bg-gray-50 dark:hover:bg-opacity-80'"
                class="relative inline-flex items-center rounded-r-md px-2 py-2 ring-1 ring-inset ring-gray-300 focus:z-10 focus:outline-offset-0 dark:ring-gray-700 bg-white dark:bg-gray-800">
            <span class="sr-only">Próximo</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path
                    fill-rule="evenodd"
                    d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                    clip-rule="evenodd"
                />
            </svg>
        </button>
    </nav>
</div>
