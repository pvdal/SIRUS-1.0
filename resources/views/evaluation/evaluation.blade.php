<x-rubric-preview>
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

                    <div class="text-center my-6">
                        <h1 class="text-3xl font-bold" x-text="rubric.nameGroup"></h1>
                    </div>


                    <div class="space-y-8">
                        <template x-for="axis in rubric.axes.filter(a => a.type === 'in group')" :key="axis.id">
                            <div class="border dark:border-gray-700 rounded-lg p-4">
                                <h3 class="text-xl font-bold mb-3 px-4 pt-4" x-text="axis.name"></h3>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full text-sm border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs uppercase">
                                        <tr>
                                            <th class="py-3 px-4 font-semibold w-1/4">Critério</th>
                                            <template x-for="level in gradeLevels" :key="level.value">
                                                <th class="py-3 px-4 text-center font-semibold" x-text="level.label"></th>
                                            </template>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <template x-for="criterion in axis.criteria" :key="criterion.id">
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                                <td class="py-4 px-4 font-medium text-gray-800 dark:text-gray-200" x-text="criterion.name"></td>
                                                <template x-for="level in gradeLevels" :key="level.value">
                                                    <td
                                                        class="py-4 px-4 text-center cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/30 transition"
                                                        :class="{ 'bg-blue-100 dark:bg-blue-900/50 border-2 border-blue-400': groupSelections[criterion.id] == level.value }"
                                                        @click="groupSelections[criterion.id] = level.value"
                                                    >
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

                    <div class="text-center my-6">
                        <h1 class="text-3xl font-bold" x-text="rubric.nameIndividual"></h1>
                    </div>

                    <div class="space-y-8">
                        <template x-for="axis in rubric.axes.filter(a => a.type === 'individual')" :key="axis.id">
                            <div class="border dark:border-gray-700 rounded-lg p-4">
                                <h3 class="text-xl font-bold mb-3 px-4 pt-4" x-text="axis.name"></h3>
                                <div class="space-y-6">
                                    <template x-for="criterion in axis.criteria" :key="criterion.id">
                                        <div class="p-1">
                                            <p class="font-semibold text-md mb-3" x-text="criterion.name"></p>
                                            <div class="overflow-x-auto">
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
                                                        <tr>
                                                            <td class="py-4 px-4 font-semibold" x-text="student.name"></td>
                                                            <template x-for="level in gradeLevels" :key="level.value">
                                                                <td class="py-4 px-4 align-top text-center cursor-pointer transition-colors duration-200 ease-in-out hover:bg-gray-100 dark:hover:bg-gray-700"
                                                                    @click="individualSelections[student.id] = { ...individualSelections[student.id], [criterion.id]: level.value }"
                                                                    :class="{ 'bg-green-100 dark:bg-green-900/50 border-2 border-green-400': individualSelections[student.id] && individualSelections[student.id][criterion.id] == level.value }">
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
</x-rubric-preview>
