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
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg transition-all">

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

                        <div class="evaluation-read-only space-y-10">
                            <template x-for="(evaluation, index) in evaluations" :key="index">
                                <div x-show="activeTabIndex === index" x-transition>

                                    <!-- Linha com dados do avaliador -->
                                    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 dark:border-gray-700 pb-3 mb-6">
                                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <p>
                                                Avaliação de <strong x-text="evaluation.evaluatorName"></strong>
                                                <span class="text-gray-400 dark:text-gray-500">em</span>
                                                <span class="italic text-sm" x-text="evaluation.evaluatedAt"></span>
                                            </p>
                                        </div>

                                        @can('is-admin')
                                            <div class="text-right">
                                                <span class="text-sm text-gray-500 dark:text-gray-400">Nota Final</span>
                                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400"
                                                   x-text="evaluation.totalScore.toFixed(2)">0.00</p>
                                            </div>
                                        @endcan
                                    </div>

                                    <div class="mt-10 p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-gray-200 dark:border-gray-700">

                                        <!-- Rubrica de Grupo -->
                                        <section class="space-y-6 mb-10">
                                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 border-b-2 border-blue-300 dark:border-blue-700 pb-1 inline-block"
                                                x-text="rubric.nameGroup"></h2>

                                            <template x-for="axis in rubric.axes.filter(a => a.type === 'in group')" :key="axis.id">
                                                <div class="space-y-2">
                                                    <div class="flex justify-between items-center">
                                                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200 mt-4"
                                                        x-text="axis.name"></h3>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">Peso: <span x-text="axis.weight + '%'"></span></span>
                                                    </div>
                                                    <div class="overflow-x-auto">
                                                        <table class="min-w-full text-sm">
                                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                            <template x-for="criterion in axis.criteria" :key="criterion.id">
                                                                <tr>
                                                                    <td class="py-3 px-3 font-medium text-gray-700 dark:text-gray-200 w-64"
                                                                        x-text="criterion.name"></td>
                                                                    <template x-for="level in gradeLevels" :key="level.value">
                                                                        <td class="py-3 px-2 text-center"
                                                                            :class="{
                                                            'bg-blue-100 dark:bg-blue-900/40 border border-blue-400 text-blue-800 dark:text-blue-200 font-semibold rounded-md':
                                                                evaluation.groupSelections[criterion.id] == level.value
                                                        }">
                                                                            <span x-text="criterion.descriptions[level.key]" class="text-xs leading-snug"></span>
                                                                        </td>
                                                                    </template>
                                                                </tr>
                                                            </template>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </template>
                                        </section>

                                        <!-- Rubrica Individual -->
                                        <section class="space-y-6">
                                            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 border-b-2 border-orange-300 dark:border-orange-700 pb-1 inline-block"
                                                x-text="rubric.nameIndividual"></h2>

                                            <template x-for="axis in rubric.axes.filter(a => a.type === 'individual')" :key="axis.id">
                                                <div class="space-y-2">
                                                    <div class="flex justify-between items-center">
                                                        <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200 mt-4"
                                                            x-text="axis.name"></h3>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">Peso: <span x-text="axis.weight + '%'"></span></span>
                                                    </div>
                                                    <template x-for="criterion in axis.criteria" :key="criterion.id">
                                                        <div class="overflow-x-auto border rounded-lg p-3">
                                                            <p class="font-medium text-gray-800 dark:text-gray-200 mb-2" x-text="criterion.name"></p>
                                                            <table class="min-w-full text-sm">
                                                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                                <template x-for="student in students" :key="student.id">
                                                                    <tr>
                                                                        <td class="py-3 px-3 font-medium text-gray-700 dark:text-gray-200 w-48"
                                                                            x-text="student.name"></td>
                                                                        <template x-for="level in gradeLevels" :key="level.value">
                                                                            <td class="py-3 px-2 text-center"
                                                                                :class="{
                                                                'bg-orange-100 dark:bg-orange-900/40 border border-orange-400 text-orange-800 dark:text-orange-200 font-semibold rounded-md':
                                                                    evaluation.individualSelections[student.id] && evaluation.individualSelections[student.id][criterion.id] == level.value
                                                            }">
                                                                                <span x-text="criterion.descriptions[level.key]" class="text-xs leading-snug"></span>
                                                                            </td>
                                                                        </template>
                                                                    </tr>
                                                                </template>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                        </section>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{--                    resultados--}}
                        @can('is-admin')

                        <div class="mt-10 p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-gray-200 dark:border-gray-700 transition-all duration-300"
                             x-data="{ showHelp: false }">

                            <div x-show="evaluations.length > 0" class="space-y-8">
                                <!-- Cabeçalho com botão de ajuda -->
                                <div class="flex flex-col sm:flex-row items-center justify-between mb-8">
                                    <div class="text-center sm:text-left">
                                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                                            Panorama Geral das Avaliações
                                        </h2>
                                        <p class="text-gray-500 dark:text-gray-400 mt-1">
                                            Médias ponderadas de cada avaliador e aluno
                                        </p>
                                    </div>

                                    <!-- Botão de ajuda -->
                                    <button @click="showHelp = !showHelp"
                                            class="flex items-center gap-2 px-3 py-2 mt-4 sm:mt-0 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg text-sm font-medium text-blue-700 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-800/40 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z"/>
                                        </svg>
                                        Como é calculado?
                                    </button>
                                </div>

                                <!-- seção explicativa -->
                                <div x-show="showHelp"
                                     x-transition
                                     class="p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg text-sm text-blue-800 dark:text-blue-200 leading-relaxed">
                                    <p class="mb-2 font-semibold">Como as notas são calculadas</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Para cada avaliador:
                                            <br>
                                            <span class="ml-4 italic">
                                                Nota final do aluno = (Nota Individual × Peso Individual / 100) + (Nota de Grupo × Peso de Grupo / 100)
                                            </span>
                                        </li>
                                        <li>A média final de cada aluno é a <strong>média das notas de todos os avaliadores</strong>.</li>
                                    </ul>
                                    <p class="mt-3 text-sm text-blue-700 dark:text-blue-300">
                                        Pesos definidos pela rubrica:
                                        <br>
                                        <span class="font-semibold">Rubrica de Grupo:</span> <span x-text="rubric.groupRubricWeight + '%'"></span> |
                                        <span class="font-semibold">Rubrica Individual:</span> <span x-text="rubric.individualRubricWeight + '%'"></span>
                                    </p>
                                </div>

                                <!-- Tabela Consolidada -->
                                <div class="overflow-x-auto mt-6">
                                    <table class="min-w-full text-sm text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                        <thead class="bg-gray-100 dark:bg-gray-700/50 text-xs uppercase font-semibold">
                                        <tr>
                                            <th class="py-3 px-4 text-left">Aluno</th>
                                            <template x-for="evaluation in evaluations" :key="evaluation.evaluatorName">
                                                <th class="py-3 px-4 text-center" x-text="evaluation.evaluatorName"></th>
                                            </template>
                                            <th class="py-3 px-4 text-center">Média Final</th>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <template x-for="student in consolidatedResults" :key="student.id">
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                                <td class="py-3 px-4 font-medium" x-text="student.name"></td>
                                                <template x-for="evalScore in student.evaluators" :key="evalScore.name">
                                                    <td class="py-3 px-4 text-center" x-text="evalScore.score.toFixed(2)"></td>
                                                </template>
                                                <td class="py-3 px-4 text-center font-semibold text-blue-600 dark:text-blue-400"
                                                    x-text="student.average.toFixed(2)"></td>
                                            </tr>
                                        </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{--                    fim resultados--}}
                        @endcan

                    </div>

                    <div class="flex justify-end p-4">
                        <x-danger-button x-on:click="window.location = document.referrer || '/calendar';">
                            Voltar
                        </x-danger-button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
