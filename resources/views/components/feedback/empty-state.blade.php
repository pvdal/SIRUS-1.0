@php
   // [$singular, $plural] = $model;
@endphp

<div class="px-10 pb-10 pt-14">
    <template x-if="empty.data">
        <div class="flex flex-col items-center justify-center  text-center">
            <p class="text-gray-700 text-md font-medium dark:text-gray-300 transition">
                Nenhum item foi cadastrado até o momento.
            </p>
            <p class="text-gray-500 mt-1 text-sm">
                Assim que houverem itens cadastrados, eles aparecerão aqui.
            </p>
            <x-lucide-book-open class="w-12 h-12 mt-6 text-gray-500 dark:text-gray-300 transition"/>
        </div>
    </template>
    <template x-if="empty.result">
        <div class="flex flex-col items-center justify-center text-center">
            <p class="text-gray-700 text-md font-medium dark:text-gray-300 transition">
                Nenhum registro encontrado.
            </p>
            <p class="text-gray-500 mt-1 text-sm dark:text-gray-400 transition">
                Nenhum resultado corresponde aos filtros ou termos de pesquisa aplicados.
            </p>
            <x-lucide-search-x class="w-12 h-12 mt-6 text-gray-500 dark:text-gray-300 transition"/>
        </div>
    </template>
</div>
