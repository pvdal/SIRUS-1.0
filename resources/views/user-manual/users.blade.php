<x-documentation-layout>
    <x-slot name="options">
        <x-manual-pages/>
    </x-slot>
    {{-- Seção 1 --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-3xl font-bold">5. Gerenciamento de Usuários</h1>
    </article>
    {{-- Seção 1: Recuperação de Senha --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-xl font-bold mb-4">Cadastro de Alunos</h1>

        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Visualizando a Lista de Alunos:</strong>
        </p>
        <p class="leading-relaxed mb-4 text-gray-800">
            A tela "Alunos Cadastrados" exibe uma tabela com colunas de RA, Nome, E-mail, Grupo, Curso, Estado e Ações.
        </p>

        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Filtros Disponíveis:</strong>
        </p>
        <ul class="list-disc pl-6 space-y-2 mb-4 text-gray-800">
            <li>Busca por Nome - Digite o nome do aluno</li>
            <li>Filtro por Curso - Selecione um curso específico</li>
            <li>Filtro por Grupo - Visualize alunos de um grupo</li>
            <li>Filtro por Período - Escolha o período/semestre</li>
            <li>Filtro por Estado - Mostrar ativos ou inativos</li>
        </ul>

        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Cadastrando um Novo Aluno:</strong>
        </p>
        <ol class="list-decimal pl-6 space-y-2 mb-4 text-gray-800">
            <li>Clique no botão "CADASTRAR"</li>
            <li>Preencha o modal com RA, Nome, E-mail, Grupo e Curso</li>
            <li>Clique em "SALVAR" para confirmar ou "FECHAR" para cancelar</li>
        </ol>

        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Alterando ou Inativando Alunos:</strong>
        </p>
        <ul class="list-disc pl-6 space-y-2 text-gray-800">
            <li>Use o botão "ALTERAR" para editar informações</li>
            <li>Use o botão "INATIVAR" para desativar o acesso (não deleta dados)</li>
        </ul>
    </article>

    {{-- Seção 2: Autenticação de Dois Fatores --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-xl font-bold mb-4">Cadastro de Professores</h1>
        <p class="leading-relaxed mb-4 text-gray-800">
            A tela <strong>"Professores Cadastrados"</strong> funciona de forma similar ao cadastro de alunos.
        </p>

        <h2 class="font-semibold mb-2">Funcionalidades:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Visualizar tabela com Nome, E-mail, Departamento, Estado</li>
            <li>Buscar professores por nome</li>
            <li>ALTERAR - Editar informações do professor</li>
            <li>INATIVAR - Desativar acesso do professor</li>
            <li>ATIVAR - Reativar professores inativos</li>
        </ul>

        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Processo de cadastro:</strong> CADASTRAR → Preencher modal → SALVAR
        </p>
    </article>

    {{-- Seção 3: Gerenciamento de Sessões e Dispositivos --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-xl font-bold mb-4">Cadastro de Coordenadores</h1>
        <p class="leading-relaxed mb-4 text-gray-800">
            A tela <strong>"Coordenadores Cadastrados"</strong> gerencia os coordenadores do sistema.
        </p>

        <h2 class="font-semibold mb-2">Funcionalidades:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Listar coordenadores com nome e e-mail</li>
            <li>Filtrar e buscar coordenadores</li>
            <li>ALTERAR - Editar dados do coordenador</li>
            <li>INATIVAR - Controlar acesso ao sistema</li>
        </ul>

        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 text-blue-800">
            <p class="font-semibold">
                Permissões
            </p>
            <p class="text-sm leading-relaxed">
                Coordenadores têm acesso a funcionalidades administrativas como gerenciar cursos, grupos, bancas e rubricas.
            </p>
        </div>
    </article>
</x-documentation-layout>
