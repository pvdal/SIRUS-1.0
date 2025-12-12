<x-documentation-layout>
    <x-slot name="options">
        <x-manual-pages/>
    </x-slot>
    {{-- Seção 1 --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-3xl font-bold">4. Agenda de Avaliações</h1>
    </article>

    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h2 class="text-xl font-semibold mb-4">Visualização mensal</h2>
        <p class="leading-relaxed mb-2">
            Após o login bem-sucedido, você acessará a <strong>Agenda de Avaliação</strong>, que é sua tela inicial no sistema.
        </p>

        <p class="leading-relaxed mb-2">
            A tela exibe um <strong>calendário mensal</strong> onde você pode:
        </p>

        <ul class="list-disc pl-6 space-y-1 text-gray-800">
            <li>Ver rapidamente quais Bancas Agendadas ocorrerão em cada dia do mês</li>
            <li>Identificar dias com múltiplas avaliações</li>
            <li>Planejar sua agenda com antecedência</li>
        </ul>

        <h3 class="font-semibold mb-2">Elementos da tela:</h3>
        <ul class="list-disc pl-6 space-y-1 text-gray-800">
            <li>Centralizar o gerenciamento de avaliações acadêmicas</li>
            <li>Padronizar critérios e rubricas de avaliação</li>
            <li>Facilitar o agendamento de bancas avaliativas</li>
            <li>Organizar dados de alunos, professores e coordenadores</li>
            <li>Gerar análises e relatórios de desempenho</li>
        </ul>
    </article>

    {{-- Seção Público-Alvo --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h2 class="text-xl font-semibold mb-4">Visualização Diária</h2>

        <p class="leading-relaxed mb-2 text-gray-800">
            Para ver mais detalhes sobre um dia específico:
        </p>
        <ol class="list-decimal pl-6 space-y-1 mb-4 text-gray-800">
            <li>Clique no dia desejado no calendário mensal</li>
            <li>Você verá o cronograma horário daquele dia</li>
            <li>Visualize horários disponíveis e bancas agendadas</li>
        </ol>

        <p class="leading-relaxed mb-2 text-gray-800 font-bold">
            Para agendar uma nova banca:
        </p>
        <ol class="list-decimal pl-6 space-y-1 text-gray-800">
            <li>Selecione um horário disponível</li>
            <li>Clique em "AGENDAR NOVA BANCA"</li>
            <li>Preencha as informações solicitadas</li>
            <li>Confirme o agendamento</li>
        </ol>
    </article>
</x-documentation-layout>
