<div class="max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 7 --}}
    <h1 class="text-3xl font-bold mb-14 text-gray-900 dark:text-gray-100">7. Rubricas e Processo de Avaliação</h1>

    {{-- Capítulo 7.1 --}}
    <h2 id="cap-7.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">7.1 Conceitos Fundamentais</h2>
    <div class="space-y-2 mb-10">
        <ul class="list-disc pl-6 mb-4 space-y-1">
            <li>
                <strong>Critério:</strong> item avaliativo específico que descreve um aspecto do desempenho,
                como por exemplo <strong>"Domínio do tema"</strong>. Cada critério possui quatro níveis de desempenho,
                inspirado na escala do tipo Likert.
            </li>
            <li>
                <strong>Eixo:</strong> conjunto de critérios relacionados, utilizado para organizar a avaliação
                em áreas temáticas. Cada eixo possui um peso percentual dentro da rubrica.
            </li>
            <li>
                <strong>Rubrica:</strong> estrutura avaliativa composta por eixos e critérios, utilizada
                pelos membros da banca para avaliar trabalhos em grupo ou individualmente.
            </li>
        </ul>
    </div>
    @if(auth()->user()->isAdmin())
        {{-- Capítulo 7.2 --}}
        <h2 id="cap-7.2" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">7.2 Gestão de Rubricas</h2>
        <p class="mb-2">
            As <strong>rubricas</strong> são fichas avaliativas utilizadas pelos membros da banca
            para realizar a avaliação dos trabalhos apresentados. Cada rubrica define de forma
            estruturada os critérios e pesos utilizados durante o processo avaliativo.
        </p>
        <p class="mb-4">
            O acesso à gestão de rubricas é realizado pela aba <strong>“Rubricas”</strong>.
            Esta área possui uma sub-navegação semelhante à aba de usuários, permitindo alternar entre:
            <strong>Critérios</strong>, <strong>Eixos</strong> e <strong>Rubricas</strong>.
            Todas as operações são realizadas exclusivamente por coordenadores.
        </p>

        <h3 id="cap-7.2-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Critérios</h3>
        <p class="mb-2">
            A aba de critérios apresenta uma visualização em tabela, contendo paginação e barra de ações, com
            botão de cadastro, campo de busca, filtros e botão de limpar filtros.
        </p>
        <p class="mb-2">
            O modal de criação e edição de critérios contém os seguintes campos:
        </p>
        <ul class="list-disc pl-6 mb-4 space-y-1">
            <li>Nome do Critério (ex: Domínio do tema)</li>
            <li>Descrição de desempenho <strong>Excelente</strong></li>
            <li>Descrição de desempenho <strong>Bom</strong></li>
            <li>Descrição de desempenho <strong>Satisfatório</strong></li>
            <li>Descrição de desempenho <strong>Insatisfatório</strong></li>
        </ul>

        <h3 id="cap-7.2-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Eixos</h3>
        <p class="mb-2">
            A aba de eixos também utiliza visualização em tabela e possui os mesmos recursos
            de busca, filtros, paginação e ações.
        </p>
        <p class="mb-2">
            O modal de criação e edição de eixos possui:
        </p>
        <ul class="list-disc pl-6 mb-4 space-y-1">
            <li>Nome do Eixo</li>
            <li>Campo de busca para adicionar critérios</li>
        </ul>
        <p class="mb-2">
            Os eixos são adicionados por meio de um campo de busca. Cada eixo selecionado
            possui um campo de <strong>peso</strong>, sendo obrigatório que a soma dos pesos
            totalize <strong>100%</strong>.
        </p>
        <p class="mb-4">
            Não é permitido cadastrar uma rubrica contendo dois ou mais eixos que compartilhem
            critérios iguais, garantindo consistência e evitando duplicidade na avaliação.
        </p>

        <h3 id="cap-7.2-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Rubricas</h3>
        <p class="mb-2">
            A aba de rubricas possui visualização em <strong>cards</strong>, semelhante às abas de
            grupos e bancas.
        </p>
        <p class="mb-2">
            Cada card apresenta
        </p>
        <ul class="list-disc pl-6 mb-4 space-y-1">
            <li>ID da rubrica</li>
            <li>Nome da rubrica</li>
            <li>Listagem dos eixos associados</li>
            <li>Botão de pré-visualização da rubrica</li>
            <li>Etiqueta de status (ativo ou inativo)</li>
            <li>Botões de alterar e inativar</li>
        </ul>
        <p class="mb-2">
            O modal de criação ou edição de rubricas contém:
        </p>
        <ul class="list-disc pl-6 mb-4 space-y-1">
            <li>
                <strong>Tipo de Avaliação:</strong>
                Individual ou Em grupo
            </li>
            <li><strong>Nome da Rubrica</strong></li>
            <li><strong>Adicionar Eixos à Rubrica</strong></li>
        </ul>
        <p class="mb-2">
            Os eixos são adicionados por meio de um campo de busca. Cada eixo selecionado
            possui um campo de <strong>peso</strong>, sendo obrigatório que a soma dos pesos
            totalize <strong>100%</strong>.
        </p>
        <p class="mb-10">
            Não é permitido cadastrar uma rubrica contendo dois ou mais eixos que compartilhem
            critérios iguais, garantindo consistência e evitando duplicidade na avaliação.
        </p>
    @endif

    {{-- Capítulo 7.3 --}}
    <h2 id="cap-7.3" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">7.3 Processo de Avaliação</h2>

    <h3 id="cap-7.3-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Acesso à Ficha Avaliativa</h3>
    <p class="mb-2">
        A ficha avaliativa pode ser acessada de duas formas:
    </p>
    <ol class="list-decimal pl-6 mb-4 space-y-1">
        <li>
            Pela aba <strong>Agenda</strong>, clicando em um evento no calendário e,
            em seguida, no botão <strong>Avaliar</strong> ou <strong>Avaliação</strong>.
        </li>
        <li>
            Pela aba <strong>Bancas</strong>:
            <ul class="list-disc pl-6 mt-2">
                <li>Coordenadores acessam pelo modal de edição da banca</li>
                <li>Professores e alunos acessam diretamente pelo card da banca</li>
            </ul>
        </li>
    </ol>
    <p class="mb-4">
        O texto do botão varia conforme o estado da avaliação:
        <strong>Avaliar</strong> (ainda não realizada) ou <strong>Avaliação</strong> (já realizada).
        Alunos sempre visualizam como <strong>Avaliação</strong>, pois não avaliam.
    </p>

    <h3 id="cap-7.3-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Ficha Avaliativa</h3>
    <p class="mb-2">
        A ficha avaliativa é exibida em layout vertical, sem menu de navegação superior, para maior foco.
        No cabeçalho são exibidas as seguintes informações:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>Avaliador</li>
        <li>Projeto</li>
        <li>Grupo</li>
        <li>Trabalho avaliado</li>
    </ul>
    <p class="mb-4">
        A área de rubricas é dividida em:
        <strong>Rubrica de Grupo</strong> (destacada em laranja) e
        <strong>Rubrica Individual</strong> (destacada em azul).
    </p>

    <h3 id="cap-7.3-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Preenchimento e Envio</h3>
    <p class="mb-2">
        Cada critério é avaliado selecionando um dos quatro níveis:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>Insatisfatório</li>
        <li>Regular</li>
        <li>Bom</li>
        <li>Excelente</li>
    </ul>
    <p class="mb-2">
        Comentários são opcionais e podem ser adicionados por critério.
    </p>
    <p class="mb-2">
        Todos os campos são obrigatórios. Caso algum não seja preenchido,
        um modal de aviso será exibido listando os critérios pendentes.
    </p>
    <p class="mb-2">
        Ao clicar em <strong>Finalizar Avaliação</strong>, um modal de confirmação é exibido.
        Após o envio, a avaliação não pode mais ser editada.
    </p>
    <div class="mb-10 bg-red-50/60 dark:bg-red-900/10 border border-red-400/60 dark:border-red-500/50 rounded-lg p-4 text-red-800 dark:text-red-300">
        <p class="font-semibold">
            Importante
        </p>
        <p class="text-sm text-gray-800 dark:text-gray-300">
            Clique em "SALVAR AVALIAÇÃO" para que todas as informações sejam gravadas no sistema.
            Sem isso, os dados serão perdidos.
        </p>
    </div>

    <h3 id="cap-7.3-d" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Resultados e Visualização</h3>
    <p class="mb-2">
        Após finalizada, a avaliação pode ser visualizada, mas não alterada.
        @if(auth()->user()->isAdmin())
            Coordenadores possuem acesso adicional para visualizar as avaliações
            de todos os membros da banca, organizadas em abas.
        @endif
    </p>

    @if(auth()->user()->isAdmin())
        <p>
            O sistema apresenta um panorama geral com médias ponderadas,
            nota final do grupo e notas individuais, além de uma explicação
            detalhada do cálculo das notas.
        </p>
    @endif
</div>
<aside class="chapter-aside hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-semibold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-700 dark:text-gray-300 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-7.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
            <span class="font-medium">7.1</span>
            <span>Conceitos Fundamentais</span>
        </a>

        @if(auth()->user()->isAdmin())
            <a href="#cap-7.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
                <span class="font-medium">7.2</span>
                <span>Gestão de Rubricas</span>
            </a>
            <a href="#cap-7.2-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                <span>Critérios</span>
            </a>
            <a href="#cap-7.2-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                <span>Eixos</span>
            </a>
            <a href="#cap-7.2-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
                <span>Rubricas</span>
            </a>
        @endif

        <a href="#cap-7.3" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-medium">7.3</span>
            <span>Processo de Avaliação</span>
        </a>
        <a href="#cap-7.3-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Acesso à Ficha Avaliativa</span>
        </a>
        <a href="#cap-7.3-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Ficha Avaliativa</span>
        </a>
        <a href="#cap-7.3-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Preenchimento e Envio</span>
        </a>
        <a href="#cap-7.3-d" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Resultados e Visualização</span>
        </a>
    </nav>
</aside>
