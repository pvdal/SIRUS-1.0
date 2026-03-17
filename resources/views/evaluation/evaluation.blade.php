<x-app-layout>
    <x-slot name="title">
        Avaliação
    </x-slot>

    <header class="bg-white shadow-sm dark:shadow-md py-2 dark:bg-gray-900 transition duration-150 ease-in-out">
        <div class="bg-gray-50 dark:bg-gray-700/30 border border-gray-200 dark:border-gray-600 flex flex-row max-w-7xl rounded-lg mx-auto px-4 py-3 sm:px-6 lg:px-8 justify-between items-center text-gray-800 dark:text-gray-100 transition duration-150 ease-in-out">
            <h2 class="text-2xl font-bold leading-tight tracking-tight max-w-full overflow-hidden pe-1 mb-3 md:mb-0">
                <div class="flex flex-wrap gap-1">
                    <p>Avaliação: </p>
                    <span class="line-clamp-2 break-all">{{ $evaluationData['committeeName'] ?? 'Tela de Avaliação' }}</span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out italic">
                    Formulário de Avaliação de Trabalho Acadêmico
                </p>
            </h2>
            @if(config('appearance.switch_theme'))
                <button
                    @click="toggleTheme()"
                    class="ms-auto sm:mx-0 relative flex items-center gap-2 p-2 rounded-lg
                    border border-gray-300 dark:border-gray-600
                    text-gray-500 dark:text-gray-300
                    hover:bg-gray-100 dark:hover:bg-gray-800
                    transition duration-150 ease-in-out"
                    aria-label="Alternar tema"
                >
                    <!-- Slot fixo do ícone -->
                    <span class="relative w-4 h-4">
                        <!-- Moon -->
                        <x-lucide-moon
                            class="absolute inset-0 h-4 w-4
                                   transition-all duration-300 ease-in-out
                                   opacity-100 scale-100 rotate-0
                                   dark:opacity-0 dark:scale-75 dark:-rotate-90"
                        />
                        <!-- Sun -->
                        <x-lucide-sun
                            class="absolute inset-0 h-4 w-4
                                   transition-all duration-300 ease-in-out
                                   opacity-0 scale-75 rotate-90
                                   dark:opacity-100 dark:scale-100 dark:rotate-0"
                        />
                    </span>
                </button>
            @endif
        </div>
    </header>

    {{-- Inicialização do Alpine --}}
    <div x-data='evaluationFormData(@json($evaluationData))'>
        {{-- Conteúdo principal --}}
        <x-main-content x-cloak class="max-w-7xl mx-auto dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-6 md:p-8">
            {{-- Aviso de avaliação concluída --}}
            <template x-if="isReadOnly">
                <div class="rounded-sm mb-4 bg-amber-50 dark:bg-stone-800/80 border-l-4 border-amber-700 dark:border-amber-400/60 p-4 text-amber-800 dark:text-amber-300 transition ease-in-out duration-150" role="alert">
                    <p class="font-semibold">Avaliação Concluída</p>
                    <p class="text-sm text-gray-800 dark:text-gray-300 transition ease-in-out duration-150">
                        Esta avaliação já foi enviada e não pode mais ser editada. Os dados abaixo são apenas para visualização.
                    </p>
                </div>
            </template>
            {{-- Cabeçalho da ficha avaliativa --}}
            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-4 mb-6 border border-gray-300 dark:border-gray-600 transition duration-150 ease-in-out justify-around">
                <div class="flex flex-wrap md:flex-nowrap items-start justify-start gap-4 lg:gap-6">
                    <div class="flex flex-col max-w-full overflow-hidden">
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 transition uppercase tracking-wide whitespace-nowrap">Avaliador</span>
                        <p class="font-semibold text-lg md:line-clamp-2" x-text="evaluatorName"></p>
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 transition uppercase tracking-wide whitespace-nowrap">Projeto</span>
                        <p class="font-semibold text-lg md:line-clamp-2" x-text="paperProject"></p>
                    </div>
                    <div class="flex flex-col max-w-full overflow-hidden">
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 transition uppercase tracking-wide">Grupo</span>
                        <p class="font-semibold text-lg" x-text="groupName"></p>
                    </div>
                    <div class="flex flex-col max-w-full overflow-hidden">
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 transition uppercase tracking-wide">Trabalho</span>
                        <p class="font-semibold text-lg line-clamp-2 break-all" x-text="paperTitle"></p>
                    </div>
                </div>
            </div>
            @if(($isCreator || $isPresident) && $timed === false)
                <div class="px-4 mb-8">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="w-full flex flex-col items-start xs:items-center">
                            <h3>Cronômetro</h3>
                            <span class="text-3xl mb-4 font-bold" x-text="!stopped ? formattedTime : '0:00'"></span>

                            <div>
                                <x-button @click="start()" x-show="!running && !stopped">
                                    Iniciar
                                </x-button>
                                <x-secondary-button @click="mark()" x-show="running && !lap.group">
                                    Marcar
                                </x-secondary-button>
                                <x-danger-button @click="finish()" x-show="running && lap.group">
                                    Finalizar
                                </x-danger-button>
                            </div>
                        </div>
                        <div class="flex flex-col items-start xs:items-center">
                            <h3>Grupo</h3>
                            <div x-show="lap.group">
                                <span class="text-3xl font-bold" x-text="format(lap.group)"></span>
                            </div>
                        </div>
                        <div class="w-full flex flex-col items-start xs:items-center">
                            <h3>Arguição</h3>
                            <div x-show="stopped">
                                <span class="text-3xl font-bold" x-text="format(lap.committee)"></span>
                            </div>
                        </div>
                        <div class="w-full flex flex-col items-start xs:items-center">
                            <h3>Tempo Total</h3>
                            <div x-show="stopped">
                                <span class="text-3xl font-bold" x-text="format(lap.group + lap.committee)"></span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-10 p-6 bg-white/80 dark:bg-gray-700/30 rounded-xl border border-gray-400/70 dark:border-gray-700 transition duration-150 ease-in-out">

                {{-- Rubrica em grupo --}}
                <section class="space-y-6 mb-10">
                    <div class="text-center my-6">
                        <h1 class="text-xl lg:text-2xl font-semibold border-b-2 border-blue-300 dark:border-blue-700 transition duration-150 ease-in-out pb-1 inline-block"
                            x-text="rubric.nameGroup"></h1>
                    </div>

                    <template x-for="axis in rubric.axes.filter(a => a.type === 'in group')" :key="axis.id">
                        <div class="space-y-2 border border-gray-400/70 rounded-lg p-3">
                            <div class="flex flex-wrap justify-between items-center">
                                <h3 class="text-lg font-medium mt-4 mr-4" x-text="axis.name"></h3>
                                <span class="text-xs lg:text-sm text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out mt-4">Peso: <span x-text="axis.weight + '%'"></span></span>
                            </div>

                            <div class="pb-1 rounded-sm scrollbar-custom shadow dark:shadow-[2px_2px_5px_rgba(0,0,0,0.40)] transition ease-in-out duration-150 overflow-y-hidden"
                            >
                                <table class="min-w-full text-sm">
                                    <thead class="text-left text-xs uppercase font-medium text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 transition duration-150 ease-in-out">
                                        <tr>
                                            <th class="text-xs xl:text-sm py-3 px-4 w-1/4">Critério</th>
                                            <template x-for="level in gradeLevels" :key="level.value">
                                                <th class="text-xs xl:text-sm py-3 px-4 text-center" x-text="level.label"></th>
                                            </template>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        <template x-for="criterion in axis.criteria" :key="criterion.id">
                                            <tr class="transition duration-150 ease-in-out">
                                                <td class="min-w-32 p-3 font-medium w-64">
                                                    <span x-text="criterion.name" class="text-xs lg:text-sm xl:text-base me-2"></span>

                                                    <button @click="openCommentModal('group', criterion.id)"
                                                            title="Adicionar comentário"
                                                            class="inline-block text-gray-400 hover:text-blue-500 align-middle relative transition duration-150 ease-in-out">
                                                        <x-lucide-message-square-text  class="w-4 h-4"/>
                                                        <span x-show="groupSelections[criterion.id] && groupSelections[criterion.id].comment"
                                                              class="absolute ml-1 -mt-1 w-2 h-2 bg-blue-500 rounded-full transition duration-150 ease-in-out"></span>
                                                    </button>
                                                </td>
                                                <template x-for="level in gradeLevels" :key="level.value">
                                                    <td class="min-w-32 text-center relative "
                                                        @click="
                                                            if (typeof groupSelections[criterion.id] !== 'object' || groupSelections[criterion.id] === null) {
                                                                groupSelections[criterion.id] = {};
                                                            }
                                                            groupSelections[criterion.id].grade = level.value;
                                                        "
                                                        :class="isReadOnly ? 'pointer-events-none' : 'cursor-pointer'"
                                                    >
                                                        <div
                                                            class="absolute m-1 inset-0 border rounded-lg transition duration-150 ease-in-out"
                                                            :class="{
                                                                'bg-blue-100 border-blue-200 dark:border-blue-800/70 dark:bg-blue-900/40 shadow-sm':
                                                                    groupSelections[criterion.id] && groupSelections[criterion.id].grade == level.value,
                                                                'hover:bg-blue-50 border-transparent dark:hover:bg-blue-900/10':
                                                                    !groupSelections[criterion.id] || groupSelections[criterion.id].grade != level.value
                                                            }"
                                                        ></div>
                                                        <div class="p-3 lg:p-5">
                                                            <span x-text="criterion.descriptions[level.key]"
                                                                class="relative z-10 pointer-events-none text-xs lg:text-sm xl:text-base leading-snug transition duration-150 ease-in-out"
                                                                :class="{
                                                                    'text-blue-800 dark:text-blue-200':
                                                                    groupSelections[criterion.id] && groupSelections[criterion.id].grade == level.value,
                                                                }"
                                                            ></span>
                                                        </div>
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

                {{-- Rubrica individual --}}
                <section class="space-y-6 mb-10">
                    <div class="text-center my-6">
                        <h1 class="text-xl lg:text-2xl font-semibold text-gray-800 dark:text-gray-100 transition duration-150 ease-in-out border-b-2 border-orange-300 dark:border-orange-700 pb-1 inline-block"
                            x-text="rubric.nameIndividual"></h1>
                    </div>

                    <template x-for="axis in rubric.axes.filter(a => a.type === 'individual')" :key="axis.id">
                        <div class="space-y-4">
                            <div class="flex flex-wrap justify-between items-center">
                                <h3 class="text-lg font-medium mt-4 mr-4" x-text="axis.name"></h3>
                                <span class="text-xs lg:text-sm text-gray-500 mt-4 dark:text-gray-400 transition duration-150 ease-in-out">Peso: <span x-text="axis.weight + '%'"></span></span>
                            </div>

                            <template x-for="criterion in axis.criteria" :key="criterion.id">
                                <div class="overflow-x-auto scrollbar-custom border border-gray-400/70 rounded-lg p-3">
                                    <p class="text-xs lg:text-sm xl:text-base font-medium mb-2 text-gray-800 dark:text-gray-200 transition duration-150 ease-in-out" x-text="criterion.name"></p>
                                    <div class="pb-1 rounded-sm shadow dark:shadow-[2px_2px_5px_rgba(0,0,0,0.40)] transition ease-in-out duration-150 overflow-y-hidden">
                                        <table class="min-w-full text-sm">
                                            <thead class="text-left text-xs uppercase font-medium text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 transition duration-150 ease-in-out">
                                                <tr>
                                                    <th class="text-xs xl:text-sm py-3 px-4 w-1/4">Aluno</th>
                                                    <template x-for="level in gradeLevels" :key="level.value">
                                                        <th class="text-xs xl:text-sm py-3 px-4 text-center" x-text="level.label"></th>
                                                    </template>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                            <template x-for="student in students" :key="student.id">
                                                <tr class="transition duration-150 ease-in-out">
                                                    <td class="min-w-32 w-64 p-3 font-medium text-gray-700 dark:text-gray-200" >
                                                        <span class="text-xs lg:text-sm xl:text-base transition duration-150 ease-in-out me-2" x-text="student.name"></span>

                                                        <button @click="openCommentModal('individual', criterion.id, student.id)"
                                                                title="Adicionar comentário"
                                                                class="inline-block text-gray-400 hover:text-blue-500 align-middle relative">
                                                            <x-lucide-message-square-text class="w-4 h-4 text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out"/>
                                                            <span x-show="individualSelections[student.id] && individualSelections[student.id][criterion.id] && individualSelections[student.id][criterion.id].comment"
                                                                  class="absolute ml-1 -mt-1 w-2 h-2 bg-blue-500 rounded-full transition duration-150 ease-in-out"></span>
                                                        </button>
                                                    </td>
                                                    <template x-for="level in gradeLevels" :key="level.value">
                                                        <td class="min-w-32 text-center relative cursor-pointer"
                                                            @click="
                                                                if (!individualSelections[student.id]) individualSelections[student.id] = {};
                                                                if (!individualSelections[student.id][criterion.id]) individualSelections[student.id][criterion.id] = {};
                                                                individualSelections[student.id][criterion.id].grade = level.value;
                                                            "
                                                            :class="isReadOnly ? 'pointer-events-none' : 'cursor-pointer'"
                                                        >
                                                            <div
                                                                class="absolute inset-0 m-1 border rounded-lg transition duration-150 ease-in-out"
                                                                :class="{
                                                                    'bg-orange-100 border-orange-200 dark:border-orange-800/70  dark:bg-orange-900/40':
                                                                        individualSelections[student.id] && individualSelections[student.id][criterion.id] && individualSelections[student.id][criterion.id].grade == level.value,
                                                                    'hover:bg-orange-50 border-transparent dark:hover:bg-orange-900/10 rounded-md':
                                                                        !individualSelections[student.id] || !individualSelections[student.id][criterion.id] || individualSelections[student.id][criterion.id].grade != level.value
                                                                }"
                                                            >
                                                            </div>
                                                            <div class="p-3 lg:p-5">
                                                                <span x-text="criterion.descriptions[level.key]"
                                                                      class="relative z-10 pointer-events-none text-xs lg:text-sm xl:text-base leading-snug transition duration-150 ease-in-out"
                                                                      :class="{
                                                                         'text-orange-800 dark:text-orange-200':
                                                                         individualSelections[student.id] && individualSelections[student.id][criterion.id] && individualSelections[student.id][criterion.id].grade == level.value
                                                                    }"
                                                                ></span>
                                                            </div>
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
                    </template>
                </section>
            </div>

            {{-- Resultados --}}
            <div class="mt-10 p-6 bg-white/80 dark:bg-gray-700/30 rounded-xl border border-gray-400/70 dark:border-gray-700 transition duration-150 ease-in-out">
                <div class="flex flex-wrap items-center justify-between mb-4">
                    <h3 class="flex items-center gap-2 text-xl mr-4 font-bold">
                        Nota Final (Prévia)
                    </h3>
                    <span class="text-sm lg:text-base font-medium italic text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out">Atualizado automaticamente</span>
                </div>

                <!-- Nota principal -->
                <div class="text-center py-6">
                    <span class="text-6xl font-extrabold text-blue-600 dark:text-blue-400 transition duration-150 ease-in-out"
                          x-text="totalScore.toFixed(2)">
                        0.00
                    </span>
                    <p class="text-md lg:text-base xl:text-lg text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out mt-2">Pontuação total ponderada</p>
                </div>

                <!-- Subnotas de Grupo e Média Individual -->
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 text-md lg:text-base xl:text-lg">
                    <div class="flex flex-col items-center justify-center p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg border border-blue-100 dark:border-blue-700 transition duration-150 ease-in-out">
                        <span class="text-gray-600 dark:text-gray-300 transition duration-150 ease-in-out">Nota do Grupo</span>
                        <span class="text-2xl font-semibold text-blue-700 dark:text-blue-300 mt-1 transition duration-150 ease-in-out"
                              x-text="groupRubricScore.toFixed(2)">0.00</span>
                    </div>

                    <div class="flex flex-col items-center justify-center p-3 bg-orange-50 dark:bg-orange-900/30 rounded-lg border border-orange-100 dark:border-orange-700 transition duration-150 ease-in-out">
                        <span class="text-gray-600 dark:text-gray-300 transition duration-150 ease-in-out">Média Individual</span>
                        <span class="text-2xl font-semibold text-orange-700 dark:text-orange-300 mt-1 transition duration-150 ease-in-out"
                              x-text="averageIndividualScore.toFixed(2)">0.00</span>
                    </div>
                </div>

                <!-- Lista das notas individuais -->
                <div class="mt-8">
                    <h4 class="text-md lg:text-base xl:text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2 transition duration-150 ease-in-out">
                        Desempenho Individual
                    </h4>

                    <div class="overflow-x-auto scrollbar-custom rounded-lg overflow-y-hidden border border-gray-400/70">
                        <table class="min-w-full text-sm text-gray-700 dark:text-gray-300 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 dark:bg-gray-700/50 transition duration-150 ease-in-out text-xs uppercase font-semibold">
                            <tr>
                                <th class="text-xs lg:text-sm py-3 px-4 text-left">Aluno</th>
                                <th class="text-xs lg:text-sm py-3 px-4 text-center">Nota Individual</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 transition duration-150 ease-in-out">
                                <template x-for="student in students" :key="student.id">
                                    <template x-if="individualStudentScores[student.id] > 0 || !isReadOnly">
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition duration-150 ease-in-out">
                                            <td class="text-xs lg:text-sm xl:text-base py-3 px-4 font-medium" x-text="student.name"></td>
                                            <td class="py-3 px-4 text-center">
                                            <span class="text-xs lg:text-sm xl:text-base font-semibold text-orange-600 dark:text-orange-400 transition duration-150 ease-in-out"
                                                  x-text="individualStudentScores[student.id]?.toFixed(2) ?? '0.00'">
                                                0.00
                                            </span>
                                            </td>
                                        </tr>
                                    </template>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 py-4">
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

                <x-danger-button x-on:click="window.location = document.referrer || '/calendar';">
                    Voltar
                </x-danger-button>
            </div>

            {{--                    MODAL DE AVISO--}}
            <x-warning-modal
                x-model="showWarningModal"
                @close="showWarningModal = false; clearWarningFields();"
                :maxWidth="'lg'"
                :warningType="'warningType'">

                <x-slot name="title">
                    <template x-if="warningType && finished">
                        <span x-text="warningType" class="font-semibold"></span>
                    </template>
                    <template x-if="!finished">
                        <span class="font-semibold">Aviso</span>
                    </template>
                </x-slot>

                <x-slot name="content">
                    <template x-if="warningContent">
                        <div x-html="warningContent"></div>
                    </template>
                </x-slot>

                <x-slot name="footer">
                    <template x-if="finished">
                        <x-secondary-button type="button"
                            x-on:click="
                                submitEvaluation();
                                $el.blur();
                            "
                        >
                            Confirmar Envio
                        </x-secondary-button>
                    </template>

                    <x-danger-button type="button"
                        @click="showWarningModal = false; clearWarningFields();"
                        class="min-w-[98px]">
                            Voltar
                    </x-danger-button>
                </x-slot>
            </x-warning-modal>

            {{--<x-comment-modal/>--}}

            <x-custom-modal x-model="showCommentModal" maxWidth="lg">
                <x-slot name="title">
                    <span x-show="!isCommentReadOnly">Adicionar Comentário</span>
                    <span x-show="isCommentReadOnly">Ver Comentário</span>
                </x-slot>
                <x-slot name="content">
                    <label for="comment_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Comentário:</label>
                    <textarea id="comment_text" x-model="currentCommentText" rows="5"
                       :readonly="isCommentReadOnly"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100"
                       :class="{ 'bg-gray-100 dark:bg-gray-700/50': isCommentReadOnly }"
                    ></textarea>
                </x-slot>
                <x-slot name="footer">
                    <template x-if="isCommentReadOnly">
                        <x-danger-button @click="closeCommentModal()">Fechar</x-danger-button>
                    </template>

                    <template x-if="!isCommentReadOnly">
                        <div>
                            @can('evaluate')
                                <x-secondary-button @click="saveComment()" class="bg-blue-600 text-white hover:bg-blue-700">
                                    Salvar Comentário
                                </x-secondary-button>
                            @endcan
                            <x-danger-button @click="closeCommentModal()">Cancelar</x-danger-button>
                        </div>
                    </template>
                </x-slot>
            </x-custom-modal>
        </x-main-content>
    </div>
</x-app-layout>
