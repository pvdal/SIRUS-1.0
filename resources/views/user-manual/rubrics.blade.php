<x-documentation-layout>
    <x-slot name="options">
        <x-manual-pages/>
    </x-slot>
    {{-- Seção 1 --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-3xl font-bold">7. Critérios e Rubricas</h1>
    </article>

    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h2 class="text-xl font-semibold mb-4">Conceitos Fundamentais</h2>

        <div class="space-y-1 text-gray-800">
            <p><strong>Critério:</strong> Um aspecto específico do desempenho que será avaliado (Ex: "Qualidade da documentação técnica")</p>
            <p><strong>Eixo:</strong> Agrupamento de critérios relacionados (Ex: "Eixo 1: Documentação e Apresentação")</p>
            <p><strong>Rubrica:</strong> Conjunto completo de eixos e critérios para avaliar grupos ou indivíduos</p>
        </div>
    </article>

    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h2 class="text-xl font-semibold mb-4">Cadastro de Critérios</h2>

        <p class="leading-relaxed mb-2 text-gray-800">
            A tela <strong>"Critérios Cadastrados"</strong> permite:
        </p>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Visualizar todos os critérios do sistema</li>
            <li>Criar novos critérios de avaliação</li>
            <li>Editar critérios existentes</li>
            <li>Associar critérios aos eixos</li>
        </ul>

        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Exemplo de critério:</strong>
        </p>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Nome: Qualidade da documentação técnica</li>
            <li>Descrição: Avalia a clareza, completude e precisão</li>
            <li>Tipo: Técnico</li>
        </ul>
    </article>

    <!-- Section 3: Preferences -->
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h2 class="text-xl font-semibold mb-4">Cadastro de Eixos</h2>

        <p class="leading-relaxed mb-2 text-gray-800">
            A tela <strong>"Eixos Cadastrados"</strong> organiza os critérios:
        </p>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Criar novos eixos de avaliação</li>
            <li>Agrupar critérios relacionados</li>
            <li>Definir a ordem de apresentação</li>
            <li>Gerenciar eixos ativos e inativos</li>
        </ul>
    </article>

</x-documentation-layout>
