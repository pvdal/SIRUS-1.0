<x-app-layout>
    <x-slot name="title">
        Avaliação
    </x-slot>

    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 tracking-tight mb-3 md:mb-0">
            Avaliação: {{ $evaluationData['paperTitle'] ?? 'Tela de Avaliação' }}
            <p class="text-sm text-gray-500 dark:text-gray-400 italic">
                Formulário de Avaliação de Trabalho Acadêmico
            </p>
        </h2>
    </x-slot>

    <style>
        .evaluation-read-only .cursor-pointer {
            cursor: not-allowed; /* Mostra um cursor de "proibido" */
            pointer-events: none; /* Desabilita magicamente todos os cliques */
            opacity: 0.8; /* Deixa a tabela levemente apagada */
        }
    </style>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg transition-all">

                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100"
                     x-data='evaluationFormData(@json($evaluationData))'
                     :class="{ 'evaluation-read-only': isReadOnly }">

                    <template x-if="isReadOnly">
                        <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700" role="alert">
                            <p class="font-bold">Avaliação Concluída</p>
                            <p>Esta avaliação já foi enviada e não pode mais ser editada. Os dados abaixo são apenas para visualização.</p>
                        </div>
                    </template>

                    {{-- div para cabeçalho da avaliação--}}
                    <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-4 mb-6 border border-gray-200 dark:border-gray-600">
                        <div class="flex flex-wrap md:flex-nowrap items-center justify-between gap-6">
                            <div class="flex flex-col">
                                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Avaliador</span>
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

                    <div class="mt-10 p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl border border-gray-200 dark:border-gray-700">

{{--                    rubrica em grupo--}}
                    <section class="space-y-6 mb-10">
                        <div class="text-center my-6">
                            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 border-b-2 border-blue-300 dark:border-blue-700 pb-1 inline-block"
                                x-text="rubric.nameGroup"></h1>
                        </div>

                        <template x-for="axis in rubric.axes.filter(a => a.type === 'in group')" :key="axis.id">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200 mt-2" x-text="axis.name"></h3>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Peso: <span x-text="axis.weight + '%'"></span></span>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full text-sm">
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <template x-for="criterion in axis.criteria" :key="criterion.id">
                                            <tr>
                                                <td class="py-3 px-3 font-medium text-gray-700 dark:text-gray-200 w-64" x-text="criterion.name"></td>

                                                <template x-for="level in gradeLevels" :key="level.value">
                                                    <td class="py-3 px-2 text-center cursor-pointer"
                                                        @click="groupSelections[criterion.id] = level.value"
                                                        :class="{
                                            'bg-blue-100 dark:bg-blue-900/40 border border-blue-400 text-blue-800 dark:text-blue-200 font-semibold rounded-md':
                                                groupSelections[criterion.id] == level.value,
                                            'hover:bg-blue-50 dark:hover:bg-blue-900/10 rounded-md': groupSelections[criterion.id] != level.value
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

{{--                    rubrica individual--}}
                    <section class="space-y-6 mb-10">
                        <div class="text-center my-6">
                            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 border-b-2 border-orange-300 dark:border-orange-700 pb-1 inline-block"
                                x-text="rubric.nameIndividual"></h1>
                        </div>

                        <template x-for="axis in rubric.axes.filter(a => a.type === 'individual')" :key="axis.id">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-700 dark:text-gray-200 mt-2" x-text="axis.name"></h3>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Peso: <span x-text="axis.weight + '%'"></span></span>
                                </div>

                                <template x-for="criterion in axis.criteria" :key="criterion.id">
                                    <div class="overflow-x-auto border rounded-lg p-3">
                                        <p class="font-medium text-gray-800 dark:text-gray-200 mb-2" x-text="criterion.name"></p>
                                        <table class="min-w-full text-sm">
                                            <thead class="text-left text-xs uppercase font-medium text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50">
                                            <tr>
                                                <th class="py-3 px-4 w-1/4">Aluno</th>
                                                <template x-for="level in gradeLevels" :key="level.value">
                                                    <th class="py-3 px-4 text-center" x-text="level.label"></th>
                                                </template>
                                            </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                            <template x-for="student in students" :key="student.id">
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                                    <td class="py-4 px-4 font-medium text-gray-700 dark:text-gray-200" x-text="student.name"></td>

                                                    <template x-for="level in gradeLevels" :key="level.value">
                                                        <td class="py-4 px-4 text-center cursor-pointer transition-colors duration-200 ease-in-out"
                                                            @click="individualSelections[student.id] = { ...individualSelections[student.id], [criterion.id]: level.value }"
                                                            :class="{
                                                'bg-orange-100 dark:bg-orange-900/50 border-2 border-orange-400 text-orange-800 dark:text-orange-200 font-semibold rounded-md':
                                                    individualSelections[student.id] && individualSelections[student.id][criterion.id] == level.value,
                                                'hover:bg-orange-50 dark:hover:bg-orange-900/10 rounded-md': !(individualSelections[student.id] && individualSelections[student.id][criterion.id] == level.value)
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

{{--                    resultados--}}
                    <div class="mt-10 p-6 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl  border border-gray-200 dark:border-gray-700 transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                                Nota Final (Prévia)
                            </h3>
                            <span class="text-xs font-medium text-gray-500 dark:text-gray-400 italic">Atualizado automaticamente</span>
                        </div>

                        <!-- Nota principal -->
                        <div class="text-center py-6">
                            <span class="text-6xl font-extrabold text-blue-600 dark:text-blue-400 drop-shadow-sm"
                                  x-text="totalScore.toFixed(2)">
                                0.00
                            </span>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Pontuação total ponderada</p>
                        </div>

                        <!-- Subnotas de Grupo e Média Individual -->
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div class="flex flex-col items-center justify-center p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg border border-blue-100 dark:border-blue-700">
                                <span class="text-gray-600 dark:text-gray-300">Nota do Grupo</span>
                                <span class="text-2xl font-semibold text-blue-700 dark:text-blue-300 mt-1"
                                      x-text="groupRubricScore.toFixed(2)">0.00</span>
                            </div>

                            <div class="flex flex-col items-center justify-center p-3 bg-orange-50 dark:bg-orange-900/30 rounded-lg border border-orange-100 dark:border-orange-700">
                                <span class="text-gray-600 dark:text-gray-300">Média Individual</span>
                                <span class="text-2xl font-semibold text-orange-700 dark:text-orange-300 mt-1"
                                      x-text="averageIndividualScore.toFixed(2)">0.00</span>
                            </div>
                        </div>

                        <!-- Lista das notas individuais -->
                        <div class="mt-8">
                            <h4 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
                                Desempenho Individual
                            </h4>

                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                    <thead class="bg-gray-100 dark:bg-gray-700/50 text-xs uppercase font-semibold">
                                    <tr>
                                        <th class="py-3 px-4 text-left">Aluno</th>
                                        <th class="py-3 px-4 text-center">Nota Individual</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <template x-for="student in students" :key="student.id">
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                            <td class="py-3 px-4 font-medium" x-text="student.name"></td>
                                            <td class="py-3 px-4 text-center">
                                <span class="font-semibold text-orange-600 dark:text-orange-400"
                                      x-text="individualStudentScores[student.id]?.toFixed(2) ?? '0.00'">
                                    0.00
                                </span>
                                            </td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
{{--                    fim resultados--}}

                    <div class="flex justify-end gap-3 mt-10 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <x-danger-button x-on:click="window.location = document.referrer || '/calendar';">
                            Voltar
                        </x-danger-button>

                        <template x-if="!isReadOnly">
                            <x-secondary-button
                                type="button"
                                x-on:click="confirmSave"
                                x-bind:disabled="saving"
                            >
                                <span x-show="!saving">Finalizar Avaliação</span>
                                <span x-show="saving">Salvando...</span>
                            </x-secondary-button>
                        </template>
                    </div>

                    {{--                    MODAL DE AVISO--}}
                    <x-warning-modal
                        x-model="showWarningModal"
                        @close="showWarningModal = false; clearWarningFields();"
                        :maxWidth="'lg'"
                        :warningType="'warningType'">

                        <x-slot name="title">
                            <template x-if="warningType">
                                <span x-text="warningType" class="font-semibold"></span>
                            </template>
                        </x-slot>

                        <x-slot name="content">
                            <template x-if="warningContent">
                                <div x-html="warningContent" class="prose dark:prose-invert max-w-none">
                                </div>
                            </template>
                        </x-slot>

                        <x-slot name="footer">
                            <template x-if="warningType === 'Confirmação'">
                                <x-danger-button type="button"
                                                 x-on:click="
                                        submitEvaluation();
                                        $el.blur();
                                    "
                                >
                                    Confirmar Envio
                                </x-danger-button>
                            </template>

                            <x-secondary-button type="button"
                                                @click="showWarningModal = false; clearWarningFields();"
                                                class="min-w-[98px]">
                                Voltar
                            </x-secondary-button>
                        </x-slot>
                    </x-warning-modal>
                    {{--                        FIM MODAL DE AVISO--}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
