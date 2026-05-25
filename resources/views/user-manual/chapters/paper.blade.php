<div class="min-w-0 max-w-4xl w-full xl:pe-24 manual-content" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 9 --}}
    <h1>9. Trabalhos</h1>

    {{-- Capítulo 9.1 --}}
    <section>
        <h2 id="cap-9.1">9.1 Visão geral</h2>

        <p>
            A aba <strong>"Trabalhos"</strong> é responsável pelo gerenciamento dos arquivos acadêmicos
            submetidos no sistema, incluindo versões para avaliação e versões corrigidas.
            Nesta área é possível cadastrar, visualizar, alterar, inativar e organizar os trabalhos
            de forma estruturada.
        </p>
    </section>

    {{-- Capítulo 9.2 --}}
    <section>
        <h2 id="cap-9.2">9.2 Visualização em tabela</h2>

        <p>
            A visualização padrão da aba <strong>"Trabalhos"</strong> é realizada em formato de tabela.
            No topo da tela está disponível uma barra de ações contendo:
        </p>
        <ul>
            <li>Botão de cadastro de novo trabalho</li>
            <li>Campo de busca textual</li>
            <li>Filtros avançados</li>
            <li>Botão de limpar filtros</li>
        </ul>

        <h3 id="cap-9.2-a">Status de avaliação</h3>
        <p>
            A coluna <strong>"Avaliação"</strong> da tabela varia conforme o estado atual do trabalho no processo de avaliação:
        </p>
        <ul>
            <li><strong>Trabalho ainda não avaliado:</strong> Não avaliado</li>
            <li><strong>Trabalho avaliado:</strong> data e hora da avaliação</li>
        </ul>
    </section>

    {{-- Capítulo 9.3 --}}
    <section>
        <h2 id="cap-9.3">9.3 Cadastro e edição de trabalhos</h2>

        <p>
            O cadastro e a edição de trabalhos são realizados por meio de um modal.
            No cadastro inicial, é necessário selecionar um arquivo PDF e preencher os seguintes campos:
        </p>
        <ul>
            <li><strong>Título do trabalho</strong></li>
            <li><strong>Ano</strong></li>
            <li><strong>Semestre</strong></li>
            <li><strong>Curso</strong></li>
            <li><strong>Projeto</strong></li>
            <li><strong>Grupo do trabalho</strong></li>
        </ul>

        <div class="manual-alert manual-alert-info">
            <p class="manual-alert-title">
                Lembre-se
            </p>
            <p class="manual-alert-message">
                Após inativar um trabalho, ele só poderá ser visualizado por coordenadores.
            </p>
        </div>

        <h3 id="cap-9.3-a">Edição de trabalhos</h3>
        <p>
            No modal de edição, é disponibilizado o botão <strong>"Alterar PDF"</strong>.
            Ao selecionar um novo arquivo, o sistema exibe:
        </p>
        <ul>
            <li>Arquivo selecionado (limite: 5MB)</li>
            <li>Arquivo salvo anteriormente</li>
        </ul>
        <p>
            O campo de título passa a ser exibido como <strong>“Título do novo trabalho”</strong>
            e é automaticamente preenchido com o nome do novo arquivo selecionado.
            Tanto o arquivo salvo quanto o novo arquivo podem ser visualizados a qualquer momento.
        </p>

        <h3 id="cap-9.3-b">Informações de avaliação</h3>
        <p>
            O modal exibe informações específicas conforme o estado da avaliação:
        </p>
        <ul>
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
        <p>
            Por meio do modal é possível alterar o grupo associado a um trabalho.
        </p>
    </section>

    {{-- Capítulo 9.4 --}}
    <section>
        <h2 id="cap-9.4" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">9.4 Visualização em diretório</h2>

        <p>
            Acima da barra de ações, há um botão de alternância que permite escolher
            entre a visualização em tabela ou em diretório.
        </p>
        <p>
            Na visualização em diretório, os trabalhos são organizados de forma hierárquica:
        </p>
        <p class="!my-6">
            <strong>Ano → Semestre → Versão → Curso → Projeto</strong>
        </p>
        <p>
            Inicialmente, todos os trabalhos são armazenados como versão de avaliação, correspondente ao material
            entregue à banca para análise dos membros.
            A estrutura de diretórios do sistema segue o padrão apresentado acima para organização dos arquivos.
        </p>
        <p>
            Ao acessar um diretório de projeto, os trabalhos associados são listados.
            Cada item possui um menu de ações acessado por um ícone de três pontos,
            contendo as seguintes opções:
        </p>
        <ul>
            <li><strong>Visualizar</strong></li>
            <li><strong>Abrir em nova aba</strong></li>
            <li><strong>Baixar</strong></li>
            <li><strong>Alterar</strong></li>
            <li><strong>Inativar ou ativar</strong></li>
        </ul>

        <h3 id="cap-9.4-a">Download por diretório</h3>
        <p>
            Ao acessar um diretório do nível <strong>"Ano"</strong>, o sistema exibe a lista
            de semestres disponíveis para aquele período.
        </p>
        <p>
            Na listagem de diretórios de semestre, cada item possui um botão de ação
            que permite realizar o <strong>download de todos os trabalhos</strong>
            contidos naquele semestre.
        </p>
        <p>
            Ao acionar este botão, o sistema gera automaticamente um arquivo compactado
            contendo todos os trabalhos pertencentes ao diretório selecionado,
            respeitando a organização interna de versões, cursos e projetos.
        </p>
        <div class="manual-alert manual-alert-info">
            <p class="manual-alert-title">
                Lembre-se
            </p>
            <p class="manual-alert-message">
                O download por diretório está disponível apenas no nível <strong class="font-semibold">"Ano"</strong>, no qual são exibidos os semestres.
            </p>
        </div>
    </section>
</div>
<aside class="chapter-aside flex-1 hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-bold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-500 dark:text-gray-400 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-9.1" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
            9.1 Visão geral
        </a>

        <a href="#cap-9.2" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            9.2 Visualização em tabela
        </a>
        <a href="#cap-9.2-a" class="sub-chapter-link block mb-3 !pl-10">
            Status de avaliação
        </a>

        <a href="#cap-9.3" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            9.3 Cadastro e edição de trabalhos
        </a>
        <a href="#cap-9.3-a" class="sub-chapter-link block mb-1 !pl-10">
            Edição de trabalhos
        </a>
        <a href="#cap-9.3-b" class="sub-chapter-link block mb-3 !pl-10">
            Informações de avaliação
        </a>

        <a href="#cap-9.4" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            9.4 Visualização em diretório
        </a>
        <a href="#cap-9.4-a" class="sub-chapter-link block mb-3 !pl-10">
            Download por diretório
        </a>
    </nav>
</aside>
