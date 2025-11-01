<x-app-layout>
    <x-slot name="title">
        Avaliação
    </x-slot>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight mb-3 md:mb-0">
            Resultado da Avaliação: {{ $pageData['paperTitle'] ?? 'Resultados' }}
            <p class="text-sm text-gray-500 dark:text-gray-400 italic">
                Resultado da Avaliação de Trabalho Acadêmico
            </p>
        </h2>
    </x-slot>

    <style>
        .evaluation-read-only .cursor-pointer {
            cursor: default;
            pointer-events: none;
            opacity: 0.8;
        }
        /* Estilo para a aba ativa */
        .tab-button-active {
            border-color: #C75B12; /* Azul do tema */
            background-color: #C75B12;
            color: white;
        }
        .tab-button-inactive {
            border-color: #6b7280; /* Cinza */
            background-color: transparent;
            color: #6b7280; /* Cinza */
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100"
                     x-data='evaluationResultTabs(@json($pageData))'>

                    <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-4 mb-6 border border-gray-200 dark:border-gray-600">
                        <div class="flex flex-wrap md:flex-nowrap items-center justify-between gap-6">
                            <div class="flex flex-col">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Visualizando como:</span>
                                <p class="font-semibold text-lg text-gray-900 dark:text-gray-100" x-text="evaluatorName"></p>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Grupo</span>
                                <p class="font-semibold text-lg" x-text="groupName"></p>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">PI/TG</span>
                                <p class="font-semibold text-lg" x-text="paperProject"></p>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Trabalho</span>
                                <p class="font-semibold text-lg" x-text="paperTitle"></p>
                            </div>
                        </div>
                    </div>


                    <template x-if="evaluations.length === 0">
                        <div class="my-4 p-4 bg-blue-100 border-l-4 border-blue-500 text-blue-700" role="alert">
                            <p class="font-bold">Nenhuma avaliação foi submetida</p>
                            <p>Assim que os membros da banca avaliarem este trabalho, os resultados aparecerão aqui.</p>
                        </div>
                    </template>

                    <div x-show="evaluations.length > 0">
                        <div class="flex space-x-2 border-b-2 border-gray-300 dark:border-gray-700 mb-6">
                            <template x-for="(evaluation, index) in evaluations" :key="index">
                                <button
                                    @click="activeTabIndex = index"
                                    class="py-2 px-4 font-medium border-b-4 transition-colors "
                                    :class="activeTabIndex === index ? 'border-blue-500 text-blue-500' : 'tab-button-inactive border-transparent text-gray-500 hover:text-gray-700'"
                                    x-text="evaluation.evaluatorName">
                                </button>
                            </template>
                        </div>

                        <div class="evaluation-read-only">
                            <template x-for="(evaluation, index) in evaluations" :key="index">
                                <div x-show="activeTabIndex === index" class="space-y-8">

                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Avaliação submetida por <strong x-text="evaluation.evaluatorName"></strong> em <span x-text="evaluation.evaluatedAt"></span>
                                    </p>

                                    <div class="text-center my-6">
                                        <h1 class="text-3xl font-bold" x-text="rubric.nameGroup"></h1>
                                    </div>

                                    <template x-for="axis in rubric.axes.filter(a => a.type === 'in group')" :key="axis.id">
                                        <div class="border dark:border-gray-700 rounded-lg p-1">
                                            <h3 class="text-xl font-bold mb-3 px-4 pt-4" x-text="axis.name"></h3>
                                            <div class="overflow-x-auto">
                                                <table class="min-w-full text-sm">
                                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                    <template x-for="criterion in axis.criteria" :key="criterion.id">
                                                        <tr>
                                                            <td class="py-4 px-4 font-semibold align-top" x-text="criterion.name"></td>
                                                            <template x-for="level in gradeLevels" :key="level.value">
                                                                <td class="py-4 px-4 align-top text-center cursor-pointer ..."
                                                                    :class="{ 'bg-blue-100 dark:bg-blue-900/50 border-2 border-blue-400': evaluation.groupSelections[criterion.id] == level.value }">
                                                                    <p x-text="criterion.descriptions[level.key]"></p>
                                                                </td>
                                                            </template>
                                                        </tr>
                                                    </template>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </template>

                                    <div class="text-center my-6">
                                        <h1 class="text-3xl font-bold" x-text="rubric.nameIndividual"></h1>
                                    </div>

                                    <template x-for="axis in rubric.axes.filter(a => a.type === 'individual')" :key="axis.id">
                                        <div class="border dark:border-gray-700 rounded-lg p-4">
                                            <h3 class="text-xl font-bold mb-3 px-4 pt-4" x-text="axis.name"></h3>
                                            <div class="space-y-6">
                                                <template x-for="criterion in axis.criteria" :key="criterion.id">
                                                    <div class="p-1">
                                                        <p class="font-semibold text-md mb-3" x-text="criterion.name"></p>
                                                        <div class="overflow-x-auto">
                                                            <table class="min-w-full text-sm">
                                                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                                <template x-for="student in students" :key="student.id">
                                                                    <tr>
                                                                        <td class="py-4 px-4 font-semibold" x-text="student.name"></td>
                                                                        <template x-for="level in gradeLevels" :key="level.value">
                                                                            <td class="py-4 px-4 align-top text-center cursor-pointer ..."
                                                                                :class="{ 'bg-green-100 dark:bg-green-900/50 border-2 border-green-400': evaluation.individualSelections[student.id] && evaluation.individualSelections[student.id][criterion.id] == level.value }">
                                                                                <p x-text="criterion.descriptions[level.key]"></p>
                                                                            </td>
                                                                        </template>
                                                                    </tr>
                                                                </template>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div> <div class="flex justify-end p-4">
                        <x-danger-button x-on:click="window.location = document.referrer || '/calendar';">
                            Voltar
                        </x-danger-button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
