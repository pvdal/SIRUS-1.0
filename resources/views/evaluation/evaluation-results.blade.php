<x-app-layout>
    <x-slot name="title">
        Avaliação
    </x-slot>

    <header class="bg-white shadow-sm dark:shadow-md py-2 dark:bg-gray-900 transition duration-150 ease-in-out">
        <div class="bg-gray-50 dark:bg-gray-700/30 border border-gray-200 dark:border-gray-600 flex flex-row max-w-7xl rounded-lg mx-auto px-4 py-3 sm:px-6 lg:px-8 justify-between items-center text-gray-800 dark:text-gray-100 transition duration-150 ease-in-out">
            <h2 class="text-2xl font-bold leading-tight tracking-tight max-w-full overflow-hidden pe-1 mb-3 md:mb-0">
                <div class="flex flex-wrap gap-1">
                    <p>Resultado da Avaliação: </p>
                    <span class="line-clamp-2 break-all">{{ $pageData['committeeName'] ?? 'Resultados' }}</span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out italic">
                    Resultado da Avaliação de Trabalho Acadêmico
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
    <div x-data='evaluationResultTabs(@json($pageData))'>
        {{-- Conteúdo principal --}}
        <x-main-content x-cloak class="max-w-7xl mx-auto dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-6 md:p-8">
            {{-- Cabeçalho da ficha avaliativa --}}
            <div class="bg-gray-50 dark:bg-gray-700/30 rounded-lg p-4 mb-6 border border-gray-200 dark:border-gray-600 transition duration-150 ease-in-out">
                <div class="flex flex-wrap md:flex-nowrap items-start justify-start gap-4 lg:gap-6">
                    <div class="flex flex-col max-w-full overflow-hidden">
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 transition uppercase tracking-wide whitespace-nowrap">Visualizando como:</span>
                        <p class="font-semibold text-lg md:line-clamp-2" x-text="evaluatorName"></p>
                    </div>
                    <div class="flex flex-col items-center">
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 transition uppercase tracking-wide whitespace-nowrap">Projeto</span>
                        <p class="font-semibold text-lg" x-text="paperProject"></p>
                    </div>
                    <div class="flex flex-col max-w-full overflow-hidden">
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 transition uppercase tracking-wide">Grupo</span>
                        <p class="font-semibold text-lg md:line-clamp-2" x-text="groupName"></p>
                    </div>
                    <div class="flex flex-col max-w-full overflow-hidden">
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 transition uppercase tracking-wide">Trabalho</span>
                        <p class="font-semibold text-lg line-clamp-2 break-all" x-text="paperTitle"></p>
                    </div>
                </div>
            </div>

            <div class="px-4 mb-10">
                <div class="grid grid-cols-3">
                    <div class="flex flex-col items-center">
                        <h3>Grupo</h3>
                        <span class="text-3xl font-bold" x-text="format(lap.group)"></span>

                    </div>
                    <div class="w-full flex flex-col items-center">
                        <h3>Arguição</h3>
                        <span class="text-3xl font-bold" x-text="format(lap.committee)"></span>

                    </div>
                    <div class="w-full flex flex-col items-center">
                        <h3>Tempo Total</h3>
                        <span class="text-3xl font-bold" x-text="format(lap.group + lap.committee)"></span>

                    </div>
                </div>
            </div>

            {{-- Caso nenhuma avaliação tenha sido efetuada --}}
            <template x-if="evaluations.length === 0">
                <div class="my-4 p-4 rounded-e-sm shadow-sm bg-blue-100/90 dark:bg-blue-600/10 border-l-4 border-blue-400/60 dark:border-blue-500/50 text-blue-800 dark:text-blue-300 transition ease-in-out duration-150" role="alert">
                    <p class="font-bold">Nenhuma avaliação foi submetida</p>
                    <p>Assim que os membros da banca avaliarem este trabalho, os resultados aparecerão aqui.</p>
                </div>
            </template>
            {{-- Avaliações --}}
            <div x-show="evaluations.length > 0">
                {{-- Navegação entre as avaliações realizadas --}}
                <nav class="flex overflow-x-auto no-scrollbar space-x-2 border-b-2 border-gray-300 dark:border-gray-700 mb-6 transition duration-150 ease-in-out">
                    <template x-for="(evaluation, index) in evaluations" :key="index">
                        <button
                            type="button"
                            @click="activeTabIndex = index"
                            class="py-2 px-4 font-medium border-b-2 transition-colors "
                            :class="activeTabIndex === index
                                    ? 'border-secondary-blue text-blue-600 dark:text-blue-400'
                                    : 'tab-button-inactive border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600'"
                            x-text="evaluation.evaluatorName">
                        </button>
                    </template>
                </nav>

                <div class="space-y-10">
                    <template x-for="(evaluation, index) in evaluations" :key="index">
                        <div x-show="activeTabIndex === index" x-transition>
                            {{-- Linha com dados de avaliação da página atual --}}
                            <div class="flex flex-wrap items-start justify-between gap-4 border-b border-gray-200 dark:border-gray-700 transition duration-150 ease-in-out pb-3 mb-6">
                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-300 transition duration-150 ease-in-out">
                                    <x-lucide-check class="w-5 h-5 text-secondary-blue"/>
                                    <p>
                                        Avaliação de <strong x-text="evaluation.evaluatorName"></strong>
                                        em <span class="font-bold text-sm" x-text="evaluation.evaluatedAt"></span>
                                    </p>
                                </div>
                                {{-- Caso seja coordenador, vê a nota final --}}
                                @can('is-admin')
                                    <div class="text-right">
                                        <span class="text-sm text-gray-500 dark:text-gray-400">Nota Final</span>
                                        <p class="text-2xl font-bold text-secondary-blue dark:text-blue-400"
                                           x-text="evaluation.totalScore.toFixed(2)">0.00</p>
                                    </div>
                                @endcan
                            </div>

                            <div class="mt-10 p-6 bg-white/80 dark:bg-gray-700/30 rounded-xl border border-gray-400/70 dark:border-gray-700 transition duration-150 ease-in-out">
                                <!-- Rubrica de Grupo -->
                                <section class="space-y-6 mb-10">
                                    <div class="text-center my-6">
                                        <h2 class="text-xl lg:text-2xl font-semibold border-b-2 border-blue-300 dark:border-blue-700 transition duration-150 ease-in-out pb-1 inline-block"
                                            x-text="rubric.nameGroup"></h2>
                                    </div>

                                    <template x-for="axis in rubric.axes.filter(a => a.type === 'in group')" :key="axis.id">
                                        <div class="space-y-2 border border-gray-500/70 rounded-lg p-3">
                                            <div class="flex flex-wrap justify-between items-center">
                                                <h3 class="text-lg font-medium mt-4 mr-4 text-gray-700 dark:text-gray-200 transition duration-150 ease-in-out"
                                                    x-text="axis.name"></h3>
                                                <span class="text-xs lg:text-sm text-gray-500 dark:text-gray-400 mt-4 transition">Peso: <span x-text="axis.weight + '%'"></span></span>
                                            </div>

                                            <div class="pb-1 rounded-sm scrollbar-custom shadow dark:shadow-[2px_2px_5px_rgba(0,0,0,0.40)] transition ease-in-out duration-150 overflow-y-hidden">
                                                <table class="min-w-full text-sm">
                                                    <thead class="text-left text-xs uppercase font-medium text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 transition duration-150 ease-in-out">
                                                        <tr>
                                                            <th class="text-xs xl:text-sm py-3 px-4 w-1/4">Critério</th>
                                                            <template x-for="level in gradeLevels" :key="level.value">
                                                                <th class="text-xs xl:text-sm py-3 px-4 text-center" x-text="level.label"></th>
                                                            </template>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700 transition duration-150 ease-in-out">
                                                        <template x-for="criterion in axis.criteria" :key="criterion.id">
                                                            <tr class="transition duration-150 ease-in-out">
                                                                <td class="min-w-32 w-64 p-3 font-medium text-gray-700 dark:text-gray-200 transition duration-150 ease-in-out">
                                                                    <span x-text="criterion.name" class="text-xs lg:text-sm xl:text-base me-2"></span>
                                                                    <button
                                                                        @click="openCommentModal('group', criterion.id)"
                                                                        title="Ver comentário"
                                                                        class="inline-block text-gray-400 hover:text-blue-500 transition align-middle relative"
                                                                    >
                                                                        <x-lucide-message-square-text class="w-4 h-4 transition duration-150 ease-in-out"/>
                                                                        <!-- Indicador visual de comentário existente -->
                                                                        <span x-show="evaluation.groupSelections[criterion.id]?.comment"
                                                                              class="absolute ml-1 -mt-1 w-2 h-2 bg-blue-500 transition rounded-full"></span>
                                                                    </button>

                                                                </td>
                                                                <template x-for="level in gradeLevels" :key="level.value">
                                                                    <td class="min-w-32 text-center relative">
                                                                        <div
                                                                            class="absolute m-1 inset-0 border rounded-lg transition duration-150 ease-in-out"
                                                                            :class="{
                                                                                'bg-blue-100 border border-blue-200 dark:border-blue-800/70 dark:bg-blue-900/40 shadow-sm':
                                                                                evaluation.groupSelections[criterion.id]?.grade === level.value
                                                                            }"
                                                                        ></div>
                                                                        <div class="p-3 lg:p-5">
                                                                            <span x-text="criterion.descriptions[level.key]"
                                                                                class="relative z-10 text-xs lg:text-sm xl:text-base leading-snug transition duration-150 ease-in-out"
                                                                                :class="{
                                                                                    'text-blue-700 dark:text-blue-200':
                                                                                    evaluation.groupSelections[criterion.id]?.grade === level.value
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

                                <!-- Rubrica Individual -->
                                <section class="space-y-6">
                                    <div class="text-center my-6">
                                        <h2 class="text-xl lg:text-2xl font-semibold dark:text-gray-100 border-b-2 border-orange-300 dark:border-orange-700 pb-1 inline-block transition duration-150 ease-in-out"
                                            x-text="rubric.nameIndividual"></h2>
                                    </div>

                                    <template x-for="axis in rubric.axes.filter(a => a.type === 'individual')" :key="axis.id">
                                        <div class="space-y-2">
                                            <div class="flex flex-wrap justify-between items-center">
                                                <h3 class="text-lg font-medium mt-4 mr-4 text-gray-700 dark:text-gray-200 transition duration-150 ease-in-out" x-text="axis.name"></h3>
                                                <span class="text-xs lg:text-sm mt-4 text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out">Peso: <span x-text="axis.weight + '%'"></span></span>
                                            </div>
                                            <template x-for="criterion in axis.criteria" :key="criterion.id">
                                                <div class="border border-gray-500/70 rounded-lg p-3 pt-3">
                                                    <p class="font-medium my-2 text-gray-800 dark:text-gray-200 transition duration-150 ease-in-out" x-text="criterion.name"></p>
                                                    <div class="pb-1 rounded-sm scrollbar-custom shadow dark:shadow-[2px_2px_5px_rgba(0,0,0,0.40)] transition ease-in-out duration-150 overflow-y-hidden">
                                                        <table class="min-w-full text-sm">
                                                            <thead class="text-left text-xs uppercase font-medium text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 transition duration-150 ease-in-out">
                                                            <tr>
                                                                <th class="text-xs xl:text-sm py-3 px-4 w-1/4">Aluno</th>
                                                                <template x-for="level in gradeLevels" :key="level.value">
                                                                    <th class="text-xs xl:text-sm py-3 px-4 text-center" x-text="level.label"></th>
                                                                </template>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 transition duration-150 ease-in-out">
                                                                <template x-for="student in students" :key="student.id">
                                                                    <tr class="transition duration-150 ease-in-out">
                                                                        <td class="min-w-32 w-64 p-3 font-medium text-gray-700 dark:text-gray-200"
                                                                        >
                                                                            <span class="text-xs lg:text-sm xl:text-base transition duration-150 ease-in-out me-2" x-text="student.name"></span>
                                                                            <button @click="openCommentModal('individual', criterion.id, student.id)"
                                                                                    title="Ver comentário"
                                                                                    class="inline-block text-gray-400 hover:text-blue-500 align-middle relative">
                                                                                <x-lucide-message-square-text class="w-4 h-4 transition duration-150 ease-in-out"/>
                                                                                <span x-show="evaluation.individualSelections[student.id]?.[criterion.id]?.comment"
                                                                                      class="absolute ml-1 -mt-1 w-2 h-2 bg-blue-500 rounded-full transition duration-150 ease-in-out"></span>
                                                                            </button>
                                                                        </td>
                                                                        <template x-for="level in gradeLevels" :key="level.value">
                                                                            <td class="min-w-32 text-center relative">
                                                                                <div
                                                                                    class="absolute m-1 inset-0 border rounded-lg transition duration-150 ease-in-out"
                                                                                    :class="{
                                                                                        'bg-orange-100 border border-orange-200 dark:border-orange-800/70 dark:bg-orange-900/40 shadow-sm':
                                                                                        evaluation.individualSelections[student.id][criterion.id]?.grade == level.value
                                                                                    }"
                                                                                ></div>
                                                                                <div class="p-3 lg:p-5">
                                                                                    <span x-text="criterion.descriptions[level.key]"
                                                                                        class="relative z-10 text-xs lg:text-sm xl:text-base leading-snug transition duration-150 ease-in-out"
                                                                                        :class="{
                                                                                            'text-orange-700 dark:text-orange-200':
                                                                                            evaluation.individualSelections[student.id][criterion.id]?.grade == level.value
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
                        </div>
                    </template>
                </div>

                {{--resultados--}}
                @can('is-admin')
                    <div class="mt-10 p-6 bg-white/80 dark:bg-gray-700/30 rounded-xl border border-gray-400/70 dark:border-gray-700 transition duration-150 ease-in-out">
                        <div x-show="evaluations.length > 0" class="space-y-8">
                            <!-- Cabeçalho com botão de ajuda -->
                            <div class="flex flex-col sm:flex-row items-center justify-between mb-8">
                                <div class="text-center sm:text-left">
                                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 transition duration-150 ease-in-out">
                                        Panorama Geral das Avaliações
                                    </h2>
                                    <p class="text-gray-500 mt-1 dark:text-gray-400 transition duration-150 ease-in-out">
                                        Médias ponderadas de cada avaliador e aluno
                                    </p>
                                </div>

                                <!-- Botão de ajuda -->
                                <button @click="showHelp = !showHelp"
                                        class="flex items-center gap-2 px-3 py-2 mt-4 sm:mt-0 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700
                                            rounded-lg text-sm xl:text-base font-medium text-blue-700 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-800/40 transition duration-150 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 11-10 10A10 10 0 0112 2z"/>
                                    </svg>
                                    Como é calculado?
                                </button>
                            </div>

                            <!-- seção explicativa -->
                            <div x-show="showHelp"
                                 x-transition
                                 class="p-4 bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg text-xs lg:text-sm xl:text-base text-blue-800 dark:text-blue-200 leading-relaxed transition duration-150 ease-in-out">
                                <p class="mb-2 font-semibold text-xs lg:text-base xl:text-lg">Como as notas são calculadas</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Para cada avaliador:
                                        <br>
                                        <span class="ml-4 italic">
                                            Nota final do aluno = (Nota Individual × Peso Individual / 100) + (Nota de Grupo × Peso de Grupo / 100)
                                        </span>
                                    </li>
                                    <li>A média final de cada aluno é a <strong>média das notas de todos os avaliadores</strong>.</li>
                                </ul>
                                <p class="mt-3 text-blue-700 dark:text-blue-300 transition duration-150 ease-in-out">
                                    Pesos definidos pela rubrica:
                                    <br>
                                    <span class="font-semibold">Rubrica de Grupo:</span> <span x-text="rubric.groupRubricWeight + '%'"></span> |
                                    <span class="font-semibold">Rubrica Individual:</span> <span x-text="rubric.individualRubricWeight + '%'"></span>
                                </p>
                            </div>

                            <!-- Tabela Consolidada -->
                            <div
                                :style="`min-height: ${getTableMinHeight()}px`"
                            >
                                <template x-if="renderTable">
                                    <div class="overflow-x-auto overflow-y-hidden scrollbar-custom mt-6 rounded-lg border border-gray-400/70 dark:border-gray-700 transition duration-150 ease-in-out">
                                        <table class="min-w-full text-sm text-gray-700 dark:text-gray-300 transition duration-150 ease-in-out rounded-lg overflow-hidden">
                                            <thead class="bg-gray-100 dark:bg-gray-700/50 transition duration-150 ease-in-out text-xs uppercase font-semibold">
                                            <tr>
                                                <th class="text-xs lg:text-sm py-3 px-4 text-left">Aluno</th>
                                                <template x-for="evaluation in consolidatedResults.evaluations" :key="evaluation.evaluatorId">
                                                    <th class="text-xs lg:text-sm py-3 px-4 text-center" x-text="evaluation.evaluatorName"></th>
                                                </template>
                                                <th class="text-xs lg:text-sm py-3 px-4 text-center">Média Final</th>
                                            </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                            <template x-for="student in consolidatedResults.results" :key="student.id">
                                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                                    <td class="text-xs lg:text-sm xl:text-base py-3 px-4 font-medium" x-text="student.name"></td>
                                                    <template x-for="evalScore in student.evaluators" :key="evalScore.name">
                                                        <td class="text-xs lg:text-sm xl:text-base py-3 px-4 text-center" x-text="evalScore.score.toFixed(2)"></td>
                                                    </template>
                                                    <td class="text-xs lg:text-sm xl:text-base py-3 px-4 text-center font-semibold text-blue-600 dark:text-blue-400 transition duration-150 ease-in-out"
                                                        x-text="student.average.toFixed(2)"></td>
                                                </tr>
                                            </template>
                                            </tbody>
                                        </table>
                                    </div>
                                </template>
                            </div>

                            <div class="flex flex-wrap gap-4">
                                <template x-for="evaluation in evaluations" :key="evaluation.evaluatorId">
                                    <x-label class="flex items-center mb-2">
                                        <x-checkbox checked class="me-2"
                                                    x-on:click="
                                                const id = evaluation.evaluatorId;
                                                if (remove.ids.includes(id)) {
                                                    remove.ids = remove.ids.filter(r => r !== id);
                                                } else {
                                                    remove.ids.push(id);
                                                }
                                                generateConsolidatedResults();
                                            "
                                        />
                                        <span x-text="evaluation.evaluatorName"></span>
                                    </x-label>
                                </template>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>

            <div class="flex justify-end py-4">
                <x-danger-button x-on:click="window.location = document.referrer || '/calendar';">
                    Voltar
                </x-danger-button>
            </div>
            {{--<x-comment-modal/>--}}

            {{-- Modal de comentários --}}
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
