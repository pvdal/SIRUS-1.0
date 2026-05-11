<div class="min-w-0 max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 4 --}}
    <h1 class="text-3xl font-bold mb-14 text-gray-900 dark:text-gray-100">4. Agenda de Avaliações</h1>

    {{-- Capítulo 4.1 --}}
    <h2 id="cap-4.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">4.1 Visão geral da agenda</h2>
    <p class="mb-4">
        A <strong>Agenda de Avaliações</strong> é a primeira tela exibida ao usuário após o login no sistema.
        Ela centraliza o agendamento e a visualização das bancas avaliadoras do evento SIMABJU.
    </p>

    <h3 id="cap-4.1-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Exibição</h3>
    <p class="mb-2">
        A agenda é apresentada na forma de um calendário interativo,
        permitindo ao usuário acompanhar facilmente as bancas programadas durante o evento.
        Por padrão, a agenda é exibida na visualização mensal, mas o usuário pode alternar entre
        diferentes modos de exibição:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Mensal:</strong> visão geral das bancas distribuídas ao longo do mês</li>
        <li><strong>Semanal:</strong> detalhamento da agenda por semana</li>
        <li><strong>Diária:</strong> visualização completa dos horários de um dia específico</li>
    </ul>
    <p class="mb-10">
        Essas visualizações permitem identificar rapidamente dias com múltiplas bancas, horários disponíveis
        e a distribuição geral das avaliações.
    </p>

    {{-- Capítulo 4.2 --}}
    <h2 id="cap-4.2" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">
        4.2 Interação com o calendário
    </h2>

    <h3 id="cap-4.2-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Ações</h3>
    <p class="mb-2">
        No canto superior esquerdo do calendário, há um botão identificado como <strong>"Opções"</strong>,
        que ao ser clicado exibe filtros de busca de eventos (bancas) por termo, curso ou projeto.
    </p>
    @if(auth()->user()->isAdmin())
        <p class="mb-4">
            Ao selecionar a opção <strong>"Exportar Excel"</strong>, é realizado o download da programação do SIMBAJU
            referente ao semestre atual, em formato de planilha Excel.
        </p>
    @endif

    <h3 id="cap-4.2-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Alternância de visualização</h3>
    <p class="mb-4">
        No canto superior esquerdo do calendário, também estão disponíveis botões que permitem ao usuário
        alternar o modo de visualização da agenda <strong>(mensal, semanal, diária)</strong>,
        conforme a necessidade de análise ou planejamento.
    </p>

    <h3 id="cap-4.2-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Navegação por datas</h3>
    <p class="mb-2">
        No canto superior direito do calendário, estão disponíveis controles de navegação
        que auxiliam na localização das datas desejadas:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>
            <strong>Hoje:</strong> direciona o calendário para a data atual
        </li>
        <li>
            <strong>Botões de navegação:</strong> permitem avançar ou retroceder no calendário,
            de acordo com o modo de visualização selecionado (mensal, semanal ou diário)
        </li>
    </ul>

    <h3 id="cap-4.2-d" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Seleção de datas e horários</h3>
    <p class="mb-2">
        Ao clicar em uma <strong>célula do calendário</strong> (dia ou horário), o sistema
        responde de acordo com o contexto:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-10">
        @if(auth()->user()->isAdmin())
            <li>
                Horários livres permitem iniciar um <strong>novo agendamento</strong>
            </li>
        @endif
        <li>
            Eventos já cadastrados exibem os <strong>detalhes da banca agendada</strong>
        </li>
    </ul>

    @if(auth()->user()->isAdmin())
        {{-- Capítulo 4.3 --}}
        <h2 id="cap-4.3" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">4.3 Agendamento de nova banca</h2>
        <p class="mb-2">
            A criação de novos agendamentos é uma funcionalidade <strong>exclusiva do coordenador acadêmico</strong>.
            Ao clicar em um horário disponível no calendário, é aberto um <strong>modal de agendamento</strong>, onde o coordenador deve:
        </p>
        <ol class="list-decimal pl-6 space-y-1 mb-4">
            <li>Selecionar a banca avaliadora (por meio de um seletor ou informando seu identificador)</li>
            <li>Após a seleção, o sistema preenche automaticamente as seguintes informações
                <ul class="list-disc pl-4 space-y-1">
                    <li>Identificador da banca</li>
                    <li>Nome da banca</li>
                    <li>Tema do grupo</li>
                    <li>Membros do grupo</li>
                    <li>Título do trabalho</li>
                    <li>Membros da banca avaliadora</li>
                </ul>
            </li>
            <li>Informar
                <ul class="list-disc pl-4 space-y-1">
                    <li>Data e horário de início da avaliação</li>
                    <li>Data e horário de término da avaliação</li>
                </ul>
            </li>
            <li>Confirmar o agendamento clicando em <strong>Salvar</strong>, localizado no canto inferior direito do modal</li>
        </ol>
        <p class="mb-10">
            Após a confirmação, o evento passa a ser exibido no calendário.
        </p>
    @endif
    {{-- Capítulo 4.4 --}}
    <h2 id="cap-4.4" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">4.4 Visualização de bancas agendadas</h2>
    <p class="mb-4">
        Ao clicar em uma banca já agendada, o sistema abre um modal de visualização, exibindo as mesmas
        informações do agendamento.
    </p>

    <h3 id="cap-4.4-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Modo visualização</h3>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>Não é possível alterar os dados</li>
        <li>O modal apresenta botões de ação de acordo com o perfil do usuário e o estado da banca</li>
    </ul>
    <p class="mb-10">
        Usuários com perfil de aluno e professor possuem acesso apenas à visualização das informações da banca.
    </p>

    @if(auth()->user()->isAdmin())
        {{-- Capítulo 4.5 --}}
        <h2 id="cap-4.5" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">4.5 Edição e cancelamento de agendamentos</h2>
        <p class="mb-2">
            O coordenador pode <strong>editar</strong> ou <strong>cancelar</strong> um agendamento existente,
            desde que <strong>nenhuma avaliação tenha sido submetida</strong> para aquela banca. No modal de
            visualização, o coordenador pode clicar em <strong>"Editar"</strong>, localizado no canto superior direito. Ao entrar
            no modo de edição, é possível:
        </p>
        <ul class="list-disc pl-6 space-y-1 mb-4">
            <li>Alterar a data e o horário da banca</li>
            <li>Salvar as alterações</li>
            <li>Cancelar o agendamento</li>
        </ul>
        <p class="mb-10">
            Ao cancelar uma banca, o evento é removido do calendário e o sistema exibe um aviso no topo da página
            confirmando a operação. Após a submissão de pelo menos uma avaliação por um membro da banca, o
            agendamento passa a ser <strong>bloqueado para edição</strong>, garantindo a integridade do processo
            avaliativo.
        </p>
    @endif

    {{-- Capítulo 4.6 --}}
    <h2 id="cap-4.6" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">4.6 Controle de acesso e permissões</h2>
    <p class="mb-2">
        O comportamento da agenda varia conforme o perfil do usuário:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        @if(auth()->user()->isAdmin())
            <li><strong>Coordenador</strong>
                <ul class="list-disc pl-4 space-y-1">
                    <li>Criar, editar e cancelar agendamentos, além de conseguir participar de bancas como avaliador</li>
                    <li>Visualizar todas as avaliações das bancas</li>
                </ul>
            </li>
        @endif

        @if(auth()->user()->isAdmin() || auth()->user()->access_level === 2)
            <li><strong>Professor</strong>
                <ul class="list-disc pl-4 space-y-1">
                    <li>Visualizar apenas as próprias avaliações</li>
                </ul>
            </li>
        @endif
        <li><strong>Aluno</strong>
            <ul class="list-disc pl-4 space-y-1">
                <li>Visualizar as avaliações apenas das bancas relacionadas aos trabalhos dos quais já participou enquanto membro do grupo que os detém</li>
            </ul>
        </li>
    </ul>
    <div class="mb-10 bg-amber-50 dark:bg-stone-800/80 border border-amber-700 dark:border-amber-400/60 rounded-lg p-4 text-amber-800 dark:text-amber-300">
        <p class="font-semibold uppercase">
            Importante
        </p>
        <p class="text-gray-800 dark:text-gray-300">
            Tentativas de acesso as avaliações de bancas não autorizadas são automaticamente bloqueadas pelo sistema.
        </p>
    </div>

    {{-- Capítulo 4.7 --}}
    <h2 id="cap-4.7" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">4.7 Considerações importantes</h2>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>A agenda é o ponto central de organização das avaliações do evento</li>
        <li>Todas as ações são registradas e controladas conforme permissões</li>
        <li>A edição de horários é restrita, para evitar inconsistências, após o início das avaliações</li>
    </ul>
    @if(auth()->user()->isAdmin() || auth()->user()->access_level === 2)
        <p>
            Os detalhes sobre o <strong>processo de avaliação</strong>, preenchimento de fichas e visualização
            de notas são abordados no <strong>capítulo 7</strong> deste manual.
        </p>
    @endif
</div>
<aside class="chapter-aside flex-1 hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-bold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-500 dark:text-gray-400 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-4.1" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            4.1 Visão geral da agenda
        </a>
        <a href="#cap-4.1-a" class="sub-chapter-link block mb-3 !pl-10">
            Exibição
        </a>

        <a href="#cap-4.2" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            4.2 Interação com o calendário
        </a>
        <a href="#cap-4.2-a" class="sub-chapter-link block mb-1 !pl-10">
            Ações
        </a>
        <a href="#cap-4.2-b" class="sub-chapter-link block mb-1 !pl-10">
            Alternância de visualização
        </a>
        <a href="#cap-4.2-c" class="sub-chapter-link block mb-1 !pl-10">
            Navegação por datas
        </a>
        <a href="#cap-4.2-d" class="sub-chapter-link block mb-3 !pl-10">
            Seleção de datas e horários
        </a>

        @if(auth()->user()->isAdmin())
            <a href="#cap-4.3" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
                4.3 Agendamento de nova banca
            </a>
        @endif

        <a href="#cap-4.4" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            4.4 Visualização de bancas agendadas
        </a>
        <a href="#cap-4.4-a" class="sub-chapter-link block mb-3 !pl-10">
            Modo visualização
        </a>

        @if(auth()->user()->isAdmin())
            <a href="#cap-4.5" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
                4.5 Edição e cancelamento de agendamentos
            </a>
        @endif

        <a href="#cap-4.6" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
            4.6 Controle de acesso e permissões
        </a>

        <a href="#cap-4.7" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
            4.7 Considerações importantes
        </a>
    </nav>
</aside>
