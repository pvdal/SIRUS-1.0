<div class="px-10 pb-10 pt-14">
    <template x-if="empty.data">
        <div class="flex flex-col items-center justify-center  text-center">
            <p class="text-gray-700 text-md font-medium dark:text-gray-300 transition">
                Você ainda não foi associado a nenhum grupo.
            </p>
            <p class="text-gray-500 mt-1 text-sm">
                Assim que for cadastrado em algum, os dados do grupo aparecerão aqui.
            </p>
            <x-lucide-book-open class="w-12 h-12 mt-6 text-gray-500 dark:text-gray-300 transition"/>
        </div>
    </template>
</div>
