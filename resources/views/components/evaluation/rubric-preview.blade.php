{{-- resources/views/management/rubrics/model-view.blade.php --}}
{{--    <!DOCTYPE html>--}}
{{--<html lang="pt-br">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport" content="width=device-width, initial-scale=1.0">--}}
{{--    <title>Modelo da Rúbrica: {{ $rubric->name }}</title>--}}
{{--    --}}{{-- Importa os estilos do Vite/Tailwind para que a tabela fique bonita --}}
{{--    @vite(['resources/css/app.css', 'resources/js/app.js'])--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', () => {--}}
{{--            const params = new URLSearchParams(window.location.search);--}}
{{--            if (params.get('dark') === 'true') {--}}
{{--                document.documentElement.classList.add('dark');--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
{{--</head>--}}
{{--<body class="bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-200">--}}
{{--<div class="p-4 sm:p-6">--}}
{{--    <h1 class="text-xl font-bold mb-4">{{ $rubric->name }}</h1>--}}

{{--    --}}{{-- Itera sobre cada Eixo para agrupar os critérios --}}
{{--    @foreach($rubric->axes as $axis)--}}
{{--        <h2 class="text-lg font-semibold mt-6 mb-2">{{ $axis->name }}</h2>--}}
{{--        <div class="overflow-x-auto">--}}
{{--            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 border dark:border-gray-600">--}}
{{--                <thead class="bg-gray-100 dark:bg-gray-700">--}}
{{--                <tr>--}}
{{--                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider w-1/4">Critério</th>--}}
{{--                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Insatisfatório</th>--}}
{{--                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Regular</th>--}}
{{--                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Bom</th>--}}
{{--                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Excelente</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">--}}
{{--                --}}{{-- Itera sobre os Critérios de cada Eixo --}}
{{--                @forelse($axis->criteria as $criterion)--}}
{{--                    <tr>--}}
{{--                        <td class="px-6 py-4 whitespace-normal font-semibold">{{ $criterion->description }}</td>--}}
{{--                        <td class="px-6 py-4 whitespace-normal text-sm">{{ $criterion->unsatisfactory }}</td>--}}
{{--                        <td class="px-6 py-4 whitespace-normal text-sm">{{ $criterion->satisfactory }}</td>--}}
{{--                        <td class="px-6 py-4 whitespace-normal text-sm">{{ $criterion->good }}</td>--}}
{{--                        <td class="px-6 py-4 whitespace-normal text-sm">{{ $criterion->excellent }}</td>--}}
{{--                    </tr>--}}
{{--                @empty--}}
{{--                    <tr>--}}
{{--                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nenhum critério associado a este eixo.</td>--}}
{{--                    </tr>--}}
{{--                @endforelse--}}
{{--                </tbody>--}}
{{--            </table>--}}
{{--        </div>--}}
{{--    @endforeach--}}
{{--</div>--}}
{{--</body>--}}
{{--</html>--}}



<div class="max-w-10-l mx-auto p-1 py-2 lg:px-2 max-w-[2100px]">
    <div class="bg-white overflow-visible shadow-xl dark:shadow-gray-600/50 rounded-lg dark:bg-gray-900 transition duration-150 ease-in-out">

        <div x-show="!showRubricCards" x-transition x-cloak>
            <div class="bg-white overflow-visible shadow-xl dark:shadow-gray-600/50 rounded-lg dark:bg-gray-900 transition duration-150 ease-in-out">
                <template x-if="rubricForModelView">
                    <div class="p-4 sm:p-6">
                        <h1 class="text-xl font-bold mb-4 dark:text-gray-200" x-text="rubricForModelView.name"></h1>
                        <template x-if="rubricForModelView.axes && rubricForModelView.axes.length > 0">
                            <div class="text-sm mb-4">
                                <strong class="dark:text-gray-200">Tipo de Avaliação:</strong>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full"
                                      :class="rubricForModelView.axes[0].type === 'individual' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800'"
                                      x-text="rubricForModelView.axes[0].type === 'individual' ? 'Individual' : 'Em Grupo'">
                                </span>
                            </div>
                        </template>

                        {{-- ========================================== --}}
                        {{--   VISÃO PARA RÚBRICA DO TIPO "EM GRUPO"    --}}
                        {{-- ========================================== --}}
                        <template x-if="rubricForModelView.axes && rubricForModelView.axes.length > 0 && rubricForModelView.axes[0].type === 'in group'">
                            <div>
                                {{-- Loop nos Eixos em grupo--}}
                                <template x-for="axis in rubricForModelView.axes" :key="axis.id">
                                    <div class="mb-8">
                                        <h2 class="text-lg font-semibold mt-6 mb-2 dark:text-gray-300" x-text="axis.name"></h2>
                                        <div class="overflow-x-auto shadow rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                <thead class="bg-gray-100 dark:bg-gray-700">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 uppercase tracking-wider w-1/4">Critério</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 uppercase tracking-wider">Insatisfatório</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 uppercase tracking-wider">Regular</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 uppercase tracking-wider">Bom</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 uppercase tracking-wider">Excelente</th>
                                                </tr>
                                                </thead>
                                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                {{-- Loop nos Critérios de cada Eixo --}}
                                                    <template x-for="criterion in axis.criteria" :key="criterion.id">
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-normal dark:text-gray-300 font-semibold" x-text="criterion.name"></td>
                                                            <td class="px-6 py-4 whitespace-normal dark:text-gray-300 text-sm" x-text="criterion.unsatisfactory"></td>
                                                            <td class="px-6 py-4 whitespace-normal dark:text-gray-300 text-sm" x-text="criterion.satisfactory"></td>
                                                            <td class="px-6 py-4 whitespace-normal dark:text-gray-300 text-sm" x-text="criterion.good"></td>
                                                            <td class="px-6 py-4 whitespace-normal dark:text-gray-300 text-sm" x-text="criterion.excellent"></td>
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
                            </div>
                        </template>

                        {{-- ========================================== --}}
                        {{--   VISÃO PARA RÚBRICA DO TIPO "INDIVIDUAL"  --}}
                        {{-- ========================================== --}}
                        {{-- CONDIÇÃO CORRIGIDA: Verifica o 'type' do PRIMEIRO eixo --}}
                        <template x-if="rubricForModelView.axes && rubricForModelView.axes.length > 0 && rubricForModelView.axes[0].type === 'individual'">
                            <div class="space-y-12">
                                {{-- O resto do seu código para a visão 'individual' continua aqui... --}}
                                {{-- Loop para simular 5 alunos (para o preview) --}}
                                <template x-for="studentNumber in [1, 2, 3, 4, 5]" :key="studentNumber">
                                    <div class="border-t-2 dark:border-gray-600 pt-6">
                                        <h3 class="text-xl font-bold text-primary-blue dark:text-secondary-blue mb-4">
                                            Aluno <span x-text="studentNumber"></span>
                                        </h3>

                                        {{-- Para cada aluno, repetimos a lógica de mostrar os eixos e critérios --}}
                                        <template x-for="axis in rubricForModelView.axes" :key="axis.id">
                                            <div class="mb-8">
                                                <h2 class="text-lg font-semibold mt-6 mb-2 dark:text-gray-300" x-text="axis.name"></h2>
                                                <div class="overflow-x-auto shadow rounded-lg">
                                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                                        <thead class="bg-gray-100 dark:bg-gray-700">
                                                        <tr>
                                                            <th class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 uppercase tracking-wider w-1/4">Critério</th>
                                                            <th class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 uppercase tracking-wider">Insatisfatório</th>
                                                            <th class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 uppercase tracking-wider">Regular</th>
                                                            <th class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 uppercase tracking-wider">Bom</th>
                                                            <th class="px-6 py-3 text-left text-xs font-medium dark:text-gray-300 uppercase tracking-wider">Excelente</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                                        <template x-for="criterion in axis.criteria" :key="criterion.id">
                                                            <tr>
                                                                <td class="px-6 py-4 whitespace-normal dark:text-gray-300 font-semibold" x-text="criterion.name"></td>
                                                                <td class="px-6 py-4 whitespace-normal dark:text-gray-300 text-sm" x-text="criterion.unsatisfactory"></td>
                                                                <td class="px-6 py-4 whitespace-normal dark:text-gray-300 text-sm" x-text="criterion.satisfactory"></td>
                                                                <td class="px-6 py-4 whitespace-normal dark:text-gray-300 text-sm" x-text="criterion.good"></td>
                                                                <td class="px-6 py-4 whitespace-normal dark:text-gray-300 text-sm" x-text="criterion.excellent"></td>
                                                            </tr>
                                                        </template>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>


                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
