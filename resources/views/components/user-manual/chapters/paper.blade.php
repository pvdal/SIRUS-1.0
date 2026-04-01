<div class="max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 8 --}}
    <h1 class="text-3xl font-bold mb-14 text-gray-900 dark:text-gray-100">8. Trabalhos</h1>

    {{-- Capítulo 8.1 --}}
    <h2 id="cap-8.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">8.1 Visão Geral</h2>
    <p class="mb-10">
        A aba <strong>"Trabalhos"</strong> é responsável pelo gerenciamento dos arquivos acadêmicos
        submetidos no sistema, incluindo versões para avaliação e versões corrigidas.
        Nesta área é possível cadastrar, visualizar, alterar, inativar e organizar os trabalhos
        de forma estruturada.
    </p>

    {{-- Capítulo 8.2 --}}
    <h2 id="cap-8.2" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">8.2 Visualização em Tabela</h2>
    <p class="mb-2">
        A visualização padrão da aba <strong>"Trabalhos"</strong> é realizada em formato de tabela.
        No topo da tela está disponível uma barra de ações contendo:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>Botão de cadastro de novo trabalho</li>
        <li>Campo de busca textual</li>
        <li>Filtros avançados</li>
        <li>Botão de limpar filtros</li>
    </ul>

    <h3 id="cap-8.2-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Status de Avaliação</h3>
    <p class="mb-2">
        A coluna <strong>"Avaliação"</strong> da tabela varia conforme o estado atual do trabalho no processo de avaliação:
    </p>
    <ul class="list-disc pl-6 mb-10 space-y-1">
        <li><strong>Trabalho ainda não avaliado:</strong> Não avaliado</li>
        <li><strong>Trabalho avaliado:</strong> data e hora da avaliação</li>
    </ul>

    {{-- Capítulo 8.3 --}}
    <h2 id="cap-8.3" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">8.3 Cadastro e Edição de Trabalhos</h2>
    <p class="mb-2">
        O cadastro e a edição de trabalhos são realizados por meio de um modal.
        No cadastro inicial, é necessário selecionar um arquivo PDF e preencher os seguintes campos:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li><strong>Título do trabalho</strong></li>
        <li><strong>Ano</strong></li>
        <li><strong>Semestre</strong></li>
        <li><strong>Curso</strong></li>
        <li><strong>Projeto</strong></li>
        <li><strong>Grupo do trabalho</strong></li>
    </ul>

    <h3 id="cap-8.3-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Edição de Trabalhos</h3>
    <p class="mb-2">
        No modal de edição, é disponibilizado o botão <strong>"Alterar PDF"</strong>.
        Ao selecionar um novo arquivo, o sistema exibe:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>Arquivo selecionado (limite: 5MB)</li>
        <li>Arquivo salvo anteriormente</li>
    </ul>
    <p class="mb-4">
        O campo de título passa a ser exibido como <strong>“Título do novo trabalho”</strong>
        e é automaticamente preenchido com o nome do novo arquivo selecionado.
        Tanto o arquivo salvo quanto o novo arquivo podem ser visualizados a qualquer momento.
    </p>

    <h3 id="cap-8.3-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Informações de Avaliação</h3>
    <p class="mb-2">
        O modal exibe informações específicas conforme o estado da avaliação:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>
            <strong>Avaliação pendente:</strong> exibe data e hora de início e fim da avaliação
        </li>
        <li>
            <strong>Avaliação não agendada:</strong> texto informativo padrão
        </li>
        <li>
            <strong>Avaliação concluída:</strong> data e hora da avaliação realizada
        </li>
    </ul>
    <p class="mb-10">
        Por meio do modal é possível alterar o grupo associado a um trabalho.
    </p>

    {{-- Capítulo 8.4 --}}
    <h2 id="cap-8.4" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">8.4 Visualização em Diretório</h2>
    <p class="mb-2">
        Acima da barra de ações, há um botão de alternância que permite escolher
        entre a visualização em tabela ou em diretório.
    </p>
    <p class="mb-2">
        Na visualização em diretório, os trabalhos são organizados de forma hierárquica:
    </p>
    <p class="mb-6">
        <strong>Ano → Semestre → Versão → Curso → Projeto</strong>
    </p>
    <p class="mb-2">
        Inicialmente, todos os trabalhos são armazenados como versão de avaliação, correspondente ao material
        entregue à banca para análise dos membros.
        A estrutura de diretórios do sistema segue o padrão apresentado acima para organização dos arquivos.
    </p>
    <p class="mb-2">
        Ao acessar um diretório de projeto, os trabalhos associados são listados.
        Cada item possui um menu de ações acessado por um ícone de três pontos,
        contendo as seguintes opções:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li><strong>Visualizar</strong></li>
        <li><strong>Abrir em nova aba</strong></li>
        <li><strong>Baixar</strong></li>
        <li><strong>Alterar</strong></li>
        <li><strong>Inativar ou ativar</strong></li>
    </ul>

    <h3 id="cap-8.4-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Download por Diretório</h3>
    <p class="mb-2">
        Ao acessar um diretório do nível <strong>"Ano"</strong>, o sistema exibe a lista
        de semestres disponíveis para aquele período.
    </p>
    <p class="mb-2">
        Na listagem de diretórios de semestre, cada item possui um botão de ação
        que permite realizar o <strong>download de todos os trabalhos</strong>
        contidos naquele semestre.
    </p>
    <p class="mb-4">
        Ao acionar este botão, o sistema gera automaticamente um arquivo compactado
        contendo todos os trabalhos pertencentes ao diretório selecionado,
        respeitando a organização interna de versões, cursos e projetos.
    </p>
    <div class="bg-blue-50/60 dark:bg-blue-900/10 border border-blue-400/60 dark:border-blue-500/50 rounded-lg p-4 text-blue-800 dark:text-blue-300">
        <p class="font-semibold mb-1">Observação</p>
        <p class="text-sm text-gray-800 dark:text-gray-300">
            O download por diretório está disponível apenas no nível <strong>"Ano"</strong>, no qual são exibidos os semestres.
        </p>
    </div>
</div>
<aside class="chapter-aside hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-semibold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-700 dark:text-gray-300 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-8.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
            <span class="font-medium">8.1</span>
            <span>Visão Geral</span>
        </a>

        <a href="#cap-8.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-medium">8.2</span>
            <span>Visualização em Tabela</span>
        </a>
        <a href="#cap-8.2-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Status de Avaliação</span>
        </a>

        <a href="#cap-8.3" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-medium">8.3</span>
            <span>Cadastro e Edição de Trabalhos</span>
        </a>
        <a href="#cap-8.3-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Edição de Trabalhos</span>
        </a>
        <a href="#cap-8.3-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Informações de Avaliação</span>
        </a>

        <a href="#cap-8.4" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-medium">8.4</span>
            <span>Visualização em Diretório</span>
        </a>
        <a href="#cap-8.4-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Download por Diretório</span>
        </a>
    </nav>
</aside>
