<x-documentation-layout>
    <x-slot name="options">
        <x-manual-pages/>
    </x-slot>
    {{-- Seção 1 --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-3xl font-bold">6. Configurações Institucionais</h1>
    </article>
    {{-- Seção 1: Recuperação de Senha --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-xl font-bold mb-4">Gerenciamento de Cursos</h1>
        <p class="leading-relaxed mb-2 text-gray-800">
            A tela <strong>"Cursos Cadastrados"</strong> centraliza todos os cursos oferecidos.
        </p>

        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Tabela de Cursos contém:</strong>
        </p>

        <ul class="list-disc pl-6 space-y-2 text-gray-800">
            <li>
                <strong>ID -</strong> Nome do curso
            </li>
            <li>
                <strong>Nome -</strong> Manhã, Tarde ou Noite
            </li>
            <li>
                <strong>Coordenador -</strong> Coordenador responsável
            </li>
            <li>
                <strong>Estado -</strong> Ativo ou Inativo
            </li>
            <li>
                <strong>Ações -</strong> ALTERAR / INATIVAR / ATIVAR
            </li>
        </ul>
    </article>

    {{-- Seção 2: Autenticação de Dois Fatores --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-xl font-bold mb-4">Gerenciamento de Grupos</h1>
        <p class="leading-relaxed mb-2 text-gray-800">
            A tela <strong>"Cadastro de Grupos"</strong> exibe os grupos em formato de cartões.
        </p>

        <h2 class="font-semibold mb-2">Informações em cada cartão:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Nome do grupo</li>
            <li>Número de membros</li>
            <li>Lista de integrantes</li>
            <li>Status (Ativo/Inativo)</li>
        </ul>

        <h2 class="font-semibold mb-2">Ações por grupo:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>ALTERAR - Editar informações e membros</li>
            <li>INATIVAR - Desativar o grupo</li>
            <li>ATIVAR - Reativar grupos inativos</li>
        </ul>
    </article>

    {{-- Seção 3: Gerenciamento de Sessões e Dispositivos --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-xl font-bold mb-4">
            Gerenciamento de Bancas
        </h1>
        <p class="leading-relaxed mb-4 text-gray-800">
            A tela <strong>"Bancas Cadastradas"</strong> gerencia todas as bancas de avaliação.
        </p>

        <h2 class="font-semibold mb-2">Informações em cada cartão:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Nome da banca (Ex: "Banca 01", "Banca 02")</li>
            <li>Criador - Quem criou a banca</li>
            <li>Número de membros</li>
            <li>Lista de integrantes com papéis (Coordenador ou Membro)</li>
        </ul>

        <h2 class="font-semibold mb-2">Ações por grupo:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>ALTERAR - Editar informações e membros</li>
            <li>INATIVAR - Desativar o grupo</li>
            <li>ATIVAR - Reativar grupos inativos</li>
        </ul>
    </article>
</x-documentation-layout>
