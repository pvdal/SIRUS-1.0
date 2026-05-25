<div class="min-w-0 max-w-4xl w-full xl:pe-24 manual-content" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 7 --}}
    <h1>7. Rubricas e Processo de Avaliação</h1>

    {{-- Capítulo 7.1 --}}
    <section>
        <h2 id="cap-7.1">7.1 Conceitos fundamentais</h2>

        <ul>
            <li>
                <strong>Critério:</strong> item avaliativo específico que descreve um aspecto do desempenho,
                como por exemplo <strong>"Domínio do tema"</strong>. Cada critério possui quatro níveis de desempenho,
                inspirados na escala do tipo Likert: insatisfatório, satisfatório, bom e excelente.
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
    </section>

@can('is-admin')
    {{-- Capítulo 7.2 --}}
    <section>
        <h2 id="cap-7.2">7.2 Gestão de rubricas</h2>

        <p>
            As <strong>rubricas</strong> são fichas avaliativas utilizadas pelos membros da banca
            para realizar a avaliação dos trabalhos apresentados. Cada rubrica define de forma
            estruturada os critérios e pesos utilizados durante o processo avaliativo.
        </p>
        <p>
            O acesso à gestão de rubricas é realizado pela aba <strong>“Rubricas”</strong>.
            Esta área possui uma sub-navegação semelhante à aba de usuários, permitindo alternar entre:
            <strong>Critérios</strong>, <strong>Eixos</strong> e <strong>Rubricas</strong>.
            Todas as operações são realizadas exclusivamente por coordenadores.
        </p>

        <h3 id="cap-7.2-a">Critérios</h3>
        <p>
            A aba de critérios apresenta uma visualização em tabela, contendo paginação e barra de ações, com
            botão de cadastro, campo de busca, filtros, botão de limpar filtros e botão de importação e exportação
            de critérios em massa, cujo funcionamento é explicado no capítulo 5.3 deste manual.
        </p>
        <p>
            O modal de criação e edição de critérios contém os seguintes campos:
        </p>
        <ul>
            <li>Nome do Critério (ex: Domínio do tema)</li>
            <li>Descrição de desempenho <strong>Excelente</strong></li>
            <li>Descrição de desempenho <strong>Bom</strong></li>
            <li>Descrição de desempenho <strong>Satisfatório</strong></li>
            <li>Descrição de desempenho <strong>Insatisfatório</strong></li>
        </ul>

        <h3 id="cap-7.2-b">Eixos</h3>
        <p>
            A aba de eixos também utiliza visualização em tabela e possui os mesmos recursos
            de busca, filtros, paginação e ações.
        </p>
        <p>
            O modal de criação e edição de eixos possui:
        </p>
        <ul>
            <li>Nome do Eixo</li>
            <li>Campo de busca para adicionar critérios</li>
        </ul>

        <h3 id="cap-7.2-c">Rubricas</h3>
        <p>
            A aba de rubricas possui visualização em <strong>cartões</strong>, semelhante às abas de
            grupos e bancas.
        </p>
        <p>
            Cada <cartão></cartão> apresenta:
        </p>
        <ul>
            <li>ID da rubrica</li>
            <li>Nome da rubrica</li>
            <li>Listagem dos eixos associados</li>
            <li>Botão de pré-visualização da rubrica</li>
            <li>Etiqueta de status (ativo ou inativo)</li>
            <li>Botões de alterar e inativar</li>
        </ul>
        <p>
            O modal de criação ou edição de rubricas contém campos de:
        </p>
        <ul>
            <li>
                <strong>Tipo de Avaliação</strong> (Individual ou Em grupo)
            </li>
            <li><strong>Nome da Rubrica</strong></li>
            <li><strong>Adicionar Eixos à Rubrica</strong></li>
        </ul>
        <p>
            Os eixos são adicionados por meio de um campo de busca. Cada eixo selecionado
            possui um campo de <strong>peso</strong>, sendo obrigatório que a soma dos pesos
            totalize <strong>100%</strong>.
        </p>
        <p>
            Não é permitido cadastrar uma rubrica contendo dois ou mais eixos que compartilhem
            critérios iguais, garantindo consistência e evitando duplicidade na avaliação.
        </p>
    </section>
@endcan

    {{-- Capítulo 7.3 --}}
    <section>
        <h2 id="cap-7.3">7.3 Processo de avaliação</h2>

        <h3 id="cap-7.3-a">Acesso à Ficha Avaliativa</h3>
        <p>
            A ficha avaliativa pode ser acessada de duas formas:
        </p>
        <ol>
            <li>
                Pela aba <strong>"Agenda"</strong>, clicando em um evento no calendário e,
                em seguida, no botão <strong>Avaliar</strong> ou <strong>Avaliação</strong>.
            </li>
            <li>
                Pela aba <strong>"Bancas"</strong>:
                <ul>
                    <li>Coordenadores acessam pelo modal de edição da banca</li>
                    <li>Professores e alunos acessam diretamente pelo cartão da banca</li>
                </ul>
            </li>
        </ol>
        <p>
            O texto do botão varia conforme o estado da avaliação:
            <strong>Avaliar</strong> (ainda não realizada) ou <strong>Avaliação</strong> (já realizada).
            Alunos sempre visualizam como <strong>Avaliação</strong>, pois não avaliam.
        </p>
        @can('evaluate')
            <div class="manual-alert manual-alert-info">
                <p class="manual-alert-title">
                    Janela de avaliação
                </p>
                <p class="manual-alert-message">
                    As avaliações podem ser iniciadas a partir de 30 minutos antes do que foi definido no agendamento e até 4 horas depois.
                </p>
            </div>
        @endcan

        <h3 id="cap-7.3-b">Ficha Avaliativa</h3>
        <p>
            A ficha avaliativa é exibida sem menu de navegação superior, para maior foco dos avaliadores.
            No cabeçalho são exibidas as seguintes informações:
        </p>
        <ul>
            <li>Avaliador</li>
            <li>Projeto</li>
            <li>Grupo</li>
            <li>Trabalho avaliado</li>
        </ul>
        <p>
            Abaixo do cabeçalho, encontra-se uma seção dedicada ao controle do tempo total da apresentação do grupo e do
            tempo reservado para a arguição da banca. O membro responsável por esse controle será o usuário que realizou
            o cadastro a banca no sistema ou o membro identificado como <strong>presidente</strong>.
        </p>
        <p>
            A área de rubricas é dividida em:
            <strong>Rubrica em Grupo</strong> (destacada em azul) e
            <strong>Rubrica Individual</strong> (destacada em laranja).
        </p>

        <h3 id="cap-7.3-c">Preenchimento e envio</h3>
        <p>
            Cada critério é avaliado selecionando um dos quatro níveis:
        </p>
        <ul>
            <li>Insatisfatório</li>
            <li>Regular</li>
            <li>Bom</li>
            <li>Excelente</li>
        </ul>
        <p>
            Comentários são opcionais e podem ser adicionados por critério.
        </p>
        @can('evaluate')
            <p>
                Todos os campos são obrigatórios. Caso algum não seja preenchido,
                um modal de aviso será exibido listando os critérios pendentes.
            </p>
            <p>
                Ao clicar em <strong>"Finalizar Avaliação"</strong>, um modal de confirmação é exibido.
                Após o envio, a avaliação não pode mais ser editada.
            </p>
            <div class="manual-alert manual-alert-danger">
                <p class="manual-alert-title">
                    Atenção
                </p>
                <p class="manual-alert-message">
                    Clique em "Salvar Avaliação" para que todas as informações sejam gravadas no sistema.
                    Sem isso, os dados serão perdidos.
                </p>
            </div>
        @endcan

        <h3 id="cap-7.3-d">Resultados e visualização</h3>
        <p>
            Após finalizada, a avaliação pode ser visualizada, mas não alterada.
            @can('is-admin')
                Coordenadores possuem acesso adicional para visualizar as avaliações
                de todos os membros da banca, organizadas em abas. <br>
            @endcan
        </p>
        <p>
            O sistema apresenta um panorama geral com médias ponderadas,
            nota final do grupo e notas individuais, além de uma explicação
            detalhada do cálculo das notas.
        </p>
    </section>
</div>
<aside class="chapter-aside flex-1 hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-bold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-500 dark:text-gray-400 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-7.1" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
            7.1 Conceitos fundamentais
        </a>

        @if(auth()->user()->isAdmin())
            <a href="#cap-7.2" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
                7.2 Gestão de rubricas
            </a>
            <a href="#cap-7.2-a" class="sub-chapter-link block mb-1 !pl-10">
                Critérios
            </a>
            <a href="#cap-7.2-b" class="sub-chapter-link block mb-1 !pl-10">
                Eixos
            </a>
            <a href="#cap-7.2-c" class="sub-chapter-link block mb-3 !pl-10">
                Rubricas
            </a>
        @endif

        <a href="#cap-7.3" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            7.3 Processo de avaliação
        </a>
        <a href="#cap-7.3-a" class="sub-chapter-link block mb-1 !pl-10">
            Acesso à Ficha Avaliativa
        </a>
        <a href="#cap-7.3-b" class="sub-chapter-link block mb-1 !pl-10">
            Ficha Avaliativa
        </a>
        <a href="#cap-7.3-c" class="sub-chapter-link block mb-1 !pl-10">
            Preenchimento e envio
        </a>
        <a href="#cap-7.3-d" class="sub-chapter-link block mb-3 !pl-10">
            Resultados e visualização
        </a>
    </nav>
</aside>
