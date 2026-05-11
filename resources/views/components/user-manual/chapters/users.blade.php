<div class="min-w-0 max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 5 --}}
    <h1 class="text-3xl font-bold mb-14 text-gray-900 dark:text-gray-100">5. Gerenciamento de Usuários</h1>

    {{-- Capítulo 5.1 --}}
    <h2 id="cap-5.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">5.1 Acesso à página</h2>
    <p class="mb-10">
        A página de <strong>gerenciamento de usuários</strong> é acessada por meio do menu superior do sistema,
        selecionando a opção <strong>"Usuários"</strong>. Logo abaixo do cabeçalho principal, é exibida uma
        <strong>subnavegação</strong> que permite alternar entre os diferentes tipos de usuários do sistema.
    </p>

    {{-- Capítulo 5.2 --}}
    <h2 id="cap-5.2" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">5.2 Subnavegação entre tipos de usuários</h2>
    <p class="mb-2">
        A subnavegação apresenta três abas:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-10">
        <li><strong>Alunos</strong></li>
        <li><strong>Professores</strong></li>
        <li><strong>Coordenadores</strong></li>
    </ul>

    {{-- Capítulo 5.3 --}}
    <h2 id="cap-5.3" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">5.3 Barra de ações e filtros</h2>

    <h3 id="cap-5.3-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Visão geral</h3>
    <p class="mb-2">
        Abaixo da subnavegação, encontra-se uma barra de ações organizada em layout flexível,
        que se adapta a diferentes resoluções de tela.
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Botão Cadastrar:</strong> abre um modal para criação de um novo usuário</li>
        <li><strong>Campo de busca:</strong> permite pesquisa direta na tabela</li>
        <li><strong>Filtros:</strong> refinam os resultados exibidos</li>
        <li><strong>Limpar filtros:</strong> restaura a visualização padrão</li>
    </ul>
    <p class="mb-2.5">
        Dependendo do tamanho da tela, os botões e filtros podem ser organizados em mais de uma linha,
        mantendo a usabilidade da interface.
    </p>

    <p class="mb-2">
        Para facilitar a gestão de grandes volumes de informações, o sistema disponibiliza ferramentas
        de manipulação de dados em massa, localizadas junto à barra de ações (importação e exportação de dados).
    </p>

    <h3 id="cap-5.3-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Exportação</h3>
    <p class="mb-2">
        O botão <strong>"Exportar"</strong> gera um arquivo no formato <code class="px-2 py-1 rounded-md font-mono bg-gray-100 dark:bg-gray-800">.xlsx</code> (Excel) contendo todos os registros exibidos
        na listagem atual.
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Comportamento:</strong> o arquivo gerado respeita os filtros aplicados no momento do clique (ex: se o filtro "Ativo" estiver selecionado, apenas usuários ativos serão exportados).</li>
        <li><strong>Utilização:</strong> ideal para auditorias externas, geração de relatórios de matrículas ou backups rápidos.</li>
    </ul>

    <h3 id="cap-5.3-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Importação</h3>
    <p class="mb-2">
        O botão <strong>"Importar"</strong> abre um modal dedicado para a inserção de novos registros via planilha.
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>
            <strong>Modelo de dados:</strong> o sistema fornece um link para download de uma <strong>planilha modelo</strong>. É obrigatório seguir a estrutura de colunas deste arquivo para evitar erros de leitura.
        </li>
        <li>
            <strong>Processamento:</strong> ao selecionar o arquivo e confirmar a operação, o sistema valida os dados (como formato de e-mail e unicidade do RA).
        </li>
        <li>
            <strong>Feedback ao usuário:</strong> durante o processamento, são exibidos banners de notificação no topo da tela:
            <ul class="list-[circle] pl-6 mt-1 space-y-1">
                <li><strong>Em andamento:</strong> indica que o servidor está processando as linhas do arquivo.</li>
                <li><strong>Sucesso:</strong> confirma a conclusão e o número de registros inseridos ou alterados.</li>
                <li><strong>Erro:</strong> aponta falhas específicas, como dados duplicados ou campos obrigatórios vazios, interrompendo a operação para garantir a integridade do banco de dados.</li>
            </ul>
        </li>
    </ul>

    <div class="mb-10 bg-blue-50/60 dark:bg-blue-900/10 border border-blue-400/60 dark:border-blue-500/50 rounded-lg p-4 text-blue-800 dark:text-blue-300">
        <p class="font-semibold uppercase">
            Dica
        </p>
        <p class="leading-relaxed text-gray-800 dark:text-gray-300">
            Recomenda-se realizar uma exportação em <code class="px-1.5 py-0.5 rounded font-mono bg-blue-100 dark:bg-blue-800 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-700">.xlsx</code> antes de grandes importações para servir como um ponto de restauração manual dos dados.
        </p>
    </div>

    {{-- Capítulo 5.4 --}}
    <h2 id="cap-5.4" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">5.4 Gerenciamento de alunos</h2>

    <h3 id="cap-5.4-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Cadastro</h3>
    <p class="mb-2">
        Ao clicar em <strong>Cadastrar</strong>, é aberto um modal contendo os seguintes campos:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>RA:</strong> número obrigatório de 13 dígitos</li>
        <li><strong>Nome:</strong> nome do aluno</li>
        <li><strong>E-mail:</strong> e-mail do aluno</li>
        <li><strong>Grupo (opcional):</strong> grupo ao qual o aluno está vinculado</li>
        <li><strong>Curso (opcional):</strong> curso ao qual o aluno está vinculado</li>
    </ul>
    <p class="mb-4">
        Os campos de Grupo e Curso são apresentados como seletores, enquanto os demais utilizam campos de texto.
        O salvamento é realizado pelo botão <strong>"Salvar"</strong>, localizado no canto inferior direito do modal,
        com a opção <strong>"Voltar"</strong> ao lado para cancelamento.
    </p>

    <h3 id="cap-5.4-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Busca, filtros e listagem</h3>
    <p class="mb-2">
        A tabela de alunos exibe até <strong>30 registros por página</strong>. O campo de busca permite localizar
        alunos por <strong>RA, nome ou e-mail</strong>. Os filtros disponíveis são:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>Curso</li>
        <li>Grupo</li>
        <li>Estado (ativo ou inativo)</li>
        <li>
            <span>Período de cadastro:</span>
            <ul class="list-[circle] pl-6 space-y-1 mb-4">
                <li>Hoje</li>
                <li>Últimos 7 dias</li>
                <li>Últimos 30 dias</li>
                <li>Intervalo personalizado</li>
            </ul>
        </li>
    </ul>

    <h3 id="cap-5.4-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Edição, inativação e paginação</h3>
    <p class="mb-2">
        A ação <strong>"Alterar"</strong> abre um modal com os dados do aluno para edição.
        A ação <strong>"Inativar"</strong> exibe um modal de confirmação, no qual a operação
        pode ser confirmada, ou cancelada pelo botão "Voltar", clique externo ou tecla "ESC".
    </p>
    <p class="mb-10">
        A navegação entre páginas é feita por um sistema de paginação que permite avançar ou retroceder
        por meio de setas laterais ou selecionar páginas numeradas, exibindo até cinco números por vez.
    </p>

    {{-- Capítulo 5.5 --}}
    <h2 id="cap-5.5" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">5.5 Gerenciamento de professores e coordenadores</h2>
    <p class="mb-4">
        O gerenciamento de <strong>Professores</strong> e <strong>Coordenadores</strong> segue o mesmo padrão
        de funcionamento da tela de alunos, com diferenças nos campos e filtros.
    </p>

    <h3 id="cap-5.5-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Campos de cadastro</h3>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>Nome</li>
        <li>E-mail</li>
        <li>Graduação</li>
        <li>Especialização</li>
        <li>Mestrado</li>
        <li>Doutorado</li>
    </ul>
    <p class="mb-4">
        Os campos de formação não precisam ser preenchidos no cadastro, pois são opcionais. O próprio usuário
        pode inserir essas informações posteriormente pelo seu perfil. É possível cadastrar apenas um curso
        para cada tipo de formação, portanto, recomenda-se informar os principais.
    </p>

    <h3 id="cap-5.5-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Filtros disponíveis</h3>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>Estado</li>
        <li>Período de cadastro</li>
    </ul>
    <div class="bg-blue-50/60 dark:bg-blue-900/10 border border-blue-400/60 dark:border-blue-500/50 rounded-lg p-4 text-blue-800 dark:text-blue-300">
        <p class="font-semibold uppercase">
            Permissões
        </p>
        <p class="leading-relaxed text-gray-800 dark:text-gray-300">
            Coordenadores possuem acesso a funcionalidades administrativas adicionais, como gerenciamento
            de cursos, grupos, bancas e rubricas.
        </p>
    </div>
</div>
<aside class="chapter-aside flex-1 hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-semibold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-500 dark:text-gray-400 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-5.1" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
            5.1 Acesso à página
        </a>

        <a href="#cap-5.2" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
            5.2 Subnavegação entre tipos de usuários
        </a>

        <a href="#cap-5.3" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            5.3 Barra de ações e filtros
        </a>
        <a href="#cap-5.3-a" class="sub-chapter-link block mb-1 !pl-10">
            Visão geral
        </a>
        <a href="#cap-5.3-b" class="sub-chapter-link block mb-1 !pl-10">
            Exportação
        </a>
        <a href="#cap-5.3-c" class="sub-chapter-link block mb-3 !pl-10">
            Importação
        </a>

        <a href="#cap-5.4" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            5.4 Gerenciamento de alunos
        </a>
        <a href="#cap-5.4-a" class="sub-chapter-link block mb-1 !pl-10">
            Cadastro
        </a>
        <a href="#cap-5.4-b" class="sub-chapter-link block mb-1 !pl-10">
            Busca, filtros e listagem
        </a>
        <a href="#cap-5.4-c" class="sub-chapter-link block mb-3 !pl-10">
            Edição, inativação e paginação
        </a>

        <a href="#cap-5.5" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            5.5 Gerenciamento de professores e coordenadores
        </a>
        <a href="#cap-5.5-a" class="sub-chapter-link block mb-1 !pl-10">
            Campos de cadastro
        </a>
        <a href="#cap-5.5-b" class="sub-chapter-link block mb-3 !pl-10">
            Filtros disponíveis
        </a>
    </nav>
</aside>
