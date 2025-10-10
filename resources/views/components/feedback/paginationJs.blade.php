<div class="flex justify-center mt-6 mb-8" x-show="totalPages > 1">
    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">

        <!-- Botão Anterior -->
        <button @click="changePage(page - 1)" :disabled="page === 1"
                :class="page === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-50'"
                class="relative inline-flex items-center rounded-l-md px-2 py-2 ring-1 ring-inset ring-gray-300 bg-white">
            <span class="sr-only">Anterior</span>
            <!-- ícone -->
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                      d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z"
                      clip-rule="evenodd"/>
            </svg>
        </button>

        <!-- Primeira página -->
        <button @click="changePage(1)"
                :class="page === 1
                    ? 'relative z-10 inline-flex items-center bg-primary-blue px-4 py-2 text-sm font-semibold text-white focus:z-20'
                    : 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10 bg-white'">
1
        </button>

        <!-- Reticências iniciais -->
        <span x-show="page > 3"
              class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 bg-white">...</span>

        <!-- Páginas próximas -->
        <template x-for="n in Array.from({length: totalPages}, (_, i) => i + 1).filter(n => n > 1 && n < totalPages && Math.abs(n - page) <= 1)" :key="n">
            <button @click="changePage(n)"
                    :class="page === n
                        ? 'relative z-10 inline-flex items-center bg-primary-blue px-4 py-2 text-sm font-semibold text-white focus:z-20'
                        : 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10 bg-white'"
                    x-text="n">
            </button>
        </template>

        <!-- Reticências finais -->
        <span x-show="page < totalPages - 2"
              class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 bg-white">...</span>

        <!-- Última página -->
        <button x-show="totalPages > 1" @click="changePage(totalPages)"
                :class="page === totalPages
                    ? 'relative z-10 inline-flex items-center bg-primary-blue px-4 py-2 text-sm font-semibold text-white focus:z-20'
                    : 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-10 bg-white'"
                x-text="totalPages">
        </button>

        <!-- Próximo -->
        <button @click="changePage(page + 1)" :disabled="page === totalPages"
                :class="page === totalPages ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-50'"
                class="relative inline-flex items-center rounded-r-md px-2 py-2 ring-1 ring-inset ring-gray-300 bg-white">
            <span class="sr-only">Próximo</span>
            <!-- ícone -->
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
