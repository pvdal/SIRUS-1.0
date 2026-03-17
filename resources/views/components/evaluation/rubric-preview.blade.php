<x-main-content x-cloak class="max-w-7xl mx-auto shadow dark:shadow-gray-800/50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 p-6 md:p-8">
    <div class="bg-white w-full py-6 overflow-visible rounded-lg dark:bg-gray-900 transition duration-150 ease-in-out">
        <template x-if="rubricForModelView?.axes?.length > 0">
            <div class="text-sm mb-4">
                <strong class="text-gray-800 dark:text-gray-200 transition duration-150 ease-in-out">Tipo de Avaliação:</strong>
                <span class="px-2 py-1 text-xs font-semibold rounded-full"
                      :class="rubricForModelView.type === 2 ? 'bg-blue-100 dark:bg-blue-300 text-blue-800' : 'bg-green-200/80 text-green-900'"
                      x-text="rubricForModelView.type === 2 ? 'Individual' : 'Em Grupo'">
                </span>
            </div>
        </template>

        {{-- ========================================== --}}
        {{--   VISÃO PARA RÚBRICA DO TIPO "EM GRUPO"    --}}
        {{-- ========================================== --}}
        <div class="mt-10 space-y-6 p-6 bg-white/80 dark:bg-gray-700/30 rounded-xl border border-gray-400/70 dark:border-gray-700 transition duration-150 ease-in-out">
            <div class="text-center my-6">
                <h1 class=" text-gray-900 dark:text-gray-100 text-xl lg:text-2xl font-semibold border-b-2 transition duration-150 ease-in-out pb-1 inline-block"
                    :class="rubricForModelView.type === 1 ? 'border-blue-300 dark:border-blue-700' : 'border-orange-300 dark:border-orange-700'"
                    x-text="rubricForModelView.name"></h1>
            </div>
            <template x-if="rubricForModelView?.axes?.length > 0 && rubricForModelView.type === 1">
                {{-- Loop nos Eixos em grupo--}}
                <template x-for="axis in rubricForModelView.axes" :key="axis.id">
                    <div class="space-y-2 border border-gray-400/70 rounded-lg p-3">
                        <div class="flex flex-wrap justify-between items-center">
                            <h3 class="text-lg font-medium mt-4 mr-4" x-text="axis.name"></h3>
                            <span class="text-xs lg:text-sm text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out mt-4">Peso: <span x-text="axis.weight + '%'"></span></span>
                        </div>

                        <div class="overflow-x-auto shadow dark:shadow-[2px_2px_5px_rgba(0,0,0,0.40)] transition ease-in-out rounded-sm">
                            <table class="min-w-full text-sm">
                                <thead class="text-left text-xs uppercase font-medium text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 transition duration-150 ease-in-out">
                                    <tr>
                                        <th class="text-xs xl:text-sm py-3 px-4 w-1/4">Critério</th>
                                        <th class="text-xs xl:text-sm py-3 px-4 text-center">Insatisfatório</th>
                                        <th class="text-xs xl:text-sm py-3 px-4 text-center">Regular</th>
                                        <th class="text-xs xl:text-sm py-3 px-4 text-center">Bom</th>
                                        <th class="text-xs xl:text-sm py-3 px-4 text-center">Excelente</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                {{-- Loop nos Critérios de cada Eixo --}}
                                    <template x-for="criterion in axis.criteria" :key="criterion.id">
                                        <tr class="transition duration-150 ease-in-out">
                                            <td class="min-w-32 p-3 font-medium w-64">
                                                <span x-text="criterion.name" class="text-xs lg:text-sm xl:text-base"></span>

                                                <button title="Adicionar comentário"
                                                        class="ml-2 inline-block text-gray-400 hover:text-blue-500 align-middle relative transition duration-150 ease-in-out">
                                                    <x-lucide-message-square-text  class="w-4 h-4"/>
                                                </button>
                                            </td>
                                            <td class="min-w-32 p-3 text-center cursor-pointer text-xs lg:text-sm xl:text-base leading-snug" x-text="criterion.unsatisfactory"></td>
                                            <td class="min-w-32 p-3 text-center cursor-pointer text-xs lg:text-sm xl:text-base leading-snug" x-text="criterion.satisfactory"></td>
                                            <td class="min-w-32 p-3 text-center cursor-pointer text-xs lg:text-sm xl:text-base leading-snug" x-text="criterion.good"></td>
                                            <td class="min-w-32 p-3 text-center cursor-pointer text-xs lg:text-sm xl:text-base leading-snug" x-text="criterion.excellent"></td>
                                        </tr>
                                    </template>
                                    {{-- Mensagem se não houver critérios --}}
                                    <template x-if="axis.criteria.length === 0">
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nenhum critério associado a este eixo.</td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </template>
            </template>

            {{-- ========================================== --}}
            {{--   VISÃO PARA RÚBRICA DO TIPO "INDIVIDUAL"  --}}
            {{-- ========================================== --}}
            {{-- CONDIÇÃO CORRIGIDA: Verifica o 'type' do PRIMEIRO eixo --}}
            <template x-if="rubricForModelView?.axes?.length > 0 && rubricForModelView.type === 2">
                <div class="space-y-6 mb-10">
                    {{-- O resto do seu código para a visão 'individual' continua aqui... --}}
                    {{-- Loop para simular 5 alunos (para o preview) --}}
                    {{-- Para cada aluno, repetimos a lógica de mostrar os eixos e critérios --}}
                    <template x-for="axis in rubricForModelView.axes" :key="axis.id">
                        <div class="space-y-4">
                            <div class="space-y-4">
                                <div class="flex flex-wrap justify-between items-center">
                                    <h3 class="text-lg font-medium mt-4 mr-4" x-text="axis.name"></h3>
                                    <span class="text-xs lg:text-sm text-gray-500 mt-4 dark:text-gray-400 transition duration-150 ease-in-out">Peso: <span x-text="axis.weight + '%'"></span></span>
                                </div>

                                <template x-for="criterion in axis.criteria" :key="criterion.id">
                                    <div class="overflow-x-auto scrollbar-custom border border-gray-400/70 rounded-lg p-3">
                                        <p class="text-xs lg:text-sm xl:text-base font-medium mb-2 text-gray-800 dark:text-gray-200 transition duration-150 ease-in-out" x-text="criterion.name"></p>
                                        <div class="overflow-x-auto shadow dark:shadow-[2px_2px_5px_rgba(0,0,0,0.40)] transition ease-in-out rounded-sm">
                                            <table class="min-w-full text-sm">
                                                <thead class="text-left text-xs uppercase font-medium text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-700/50 transition duration-150 ease-in-out">
                                                    <tr>
                                                        <th class="text-xs xl:text-sm py-3 px-4 w-1/4">Aluno</th>
                                                        <template x-for="level in ['Insatisfatório','Regular', 'Bom', 'Exelente']" :key="level">
                                                            <th class="text-xs xl:text-sm py-3 px-4 text-center" x-text="level"></th>
                                                        </template>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                    <template x-for="student in [1,2,3]" :key="student">
                                                        <tr class="transition duration-150 ease-in-out">
                                                            <td class="min-w-32 p-3 font-medium w-64">
                                                                <span x-text="'Aluno ' + student" class="text-xs lg:text-sm xl:text-base"></span>

                                                                <button title="Adicionar comentário"
                                                                        class="ml-2 inline-block text-gray-400 hover:text-blue-500 align-middle relative transition duration-150 ease-in-out">
                                                                    <x-lucide-message-square-text  class="w-4 h-4"/>
                                                                </button>
                                                            </td>
                                                            <td class="min-w-32 p-3 text-center cursor-pointer text-xs lg:text-sm xl:text-base leading-snug" x-text="criterion.unsatisfactory"></td>
                                                            <td class="min-w-32 p-3 text-center cursor-pointer text-xs lg:text-sm xl:text-base leading-snug" x-text="criterion.satisfactory"></td>
                                                            <td class="min-w-32 p-3 text-center cursor-pointer text-xs lg:text-sm xl:text-base leading-snug" x-text="criterion.good"></td>
                                                            <td class="min-w-32 p-3 text-center cursor-pointer text-xs lg:text-sm xl:text-base leading-snug" x-text="criterion.excellent"></td>
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
    </div>
</x-main-content>
