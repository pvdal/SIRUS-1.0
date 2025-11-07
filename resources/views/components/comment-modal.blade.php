<div x-show="showCommentModal" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     style="background-color: rgba(0, 0, 0, 0.5);">

    <div @click.outside="closeCommentModal()"
         class="w-full max-w-lg overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-xl">

        <div class="border-b px-6 py-4 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                <span x-show="!isCommentReadOnly">Adicionar Comentário</span>
                <span x-show="isCommentReadOnly">Ver Comentário</span>
            </h3>
        </div>

        <div class="p-6">
            <label for="comment_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Comentário:</label>
            <textarea id="comment_text" x-model="currentCommentText" rows="5"

                      :readonly="isCommentReadOnly"

                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"

                      :class="{ 'bg-gray-100 dark:bg-gray-700/50': isCommentReadOnly }"

            ></textarea>
        </div>

        <div class="flex justify-end space-x-4 bg-gray-50 px-6 py-4 dark:bg-gray-700/70">

            <template x-if="isCommentReadOnly">
                <x-secondary-button @click="closeCommentModal()">Fechar</x-secondary-button>
            </template>

            <template x-if="!isCommentReadOnly">
                <x-secondary-button @click="closeCommentModal()">Cancelar</x-secondary-button>

                @can('evaluate')
                    <x-secondary-button @click="saveComment()" class="bg-blue-600 text-white hover:bg-blue-700">
                        Salvar Comentário
                    </x-secondary-button>
                @endcan
            </template>
        </div>
    </div>
</div>
