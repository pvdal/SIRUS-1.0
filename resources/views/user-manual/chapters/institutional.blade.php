<div class="min-w-0 max-w-4xl w-full xl:pe-24 manual-content" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 6 --}}
    <h1>6. Configurações Institucionais</h1>

@can('is-admin')
    {{-- Capítulo 6.1 --}}
    <section>
        <h2 id="cap-6.1">6.1 Gerenciamento de cursos</h2>

        <p>
            A página de <strong>gerenciamento de cursos</strong> é acessada pelo menu superior do sistema,
            por meio da opção <strong>"Cursos"</strong>. A visualização é apresentada em formato de tabela,
            seguindo o mesmo padrão das demais telas administrativas.
        </p>

        <h3 id="cap-6.1-a">Estrutura da tabela</h3>
        <ul>
            <li><strong>ID:</strong> identificador do curso</li>
            <li><strong>Nome:</strong> nome do curso</li>
            <li><strong>Turno:</strong> manhã, Tarde ou Noite</li>
            <li><strong>Coordenador:</strong> responsável pelo curso</li>
            <li><strong>Estado:</strong> ativo ou Inativo</li>
            <li><strong>Ações:</strong> alterar, Inativar ou Ativar</li>
        </ul>

        <h3 id="cap-6.1-b">Barra de ações e filtros</h3>
        <p>
            Acima da tabela, encontra-se uma barra de ações e filtros contendo
        </p>
        <ul>
            <li>Botão <strong>"Cadastrar curso"</strong>, que abre o modal de criação de curso</li>
            <li>Campo de busca textual</li>
            <li>Filtros disponíveis (<strong>Estado</strong> e <strong>Período</strong>)</li>
            <li>Opção <strong>Limpar filtros</strong></li>
        </ul>

        <h3 id="cap-6.1-c">Cadastro e edição</h3>
        <p>
            O modal de cadastro e edição de cursos possui os campos
        </p>
        <ul>
            <li><strong>Nome do curso</strong></li>
            <li><strong>Turno</strong></li>
            <li><strong>Coordenador</strong></li>
        </ul>
        <p>
            As ações de edição, inativação e paginação seguem o mesmo comportamento descrito no capítulo
            de Gerenciamento de Usuários, com exibição de até <strong>30 registros por página</strong>.
        </p>
    </section>

    {{-- Capítulo 6.2 --}}
    <section>
        <h2 id="cap-6.2">6.2 Gerenciamento de grupos</h2>

        <p>
            O gerenciamento de grupos é acessado pelo menu superior do sistema e apresenta uma interface
            que reune informações acadêmicas, trabalhos associados e membros do grupo.
            A visualização é feita por meio de <strong>cartões</strong>.
        </p>

        <h2 id="cap-6.2.1">6.2.1 Visualização dos grupos</h2>
        <p>
            Cada grupo é apresentado em formato de <strong>cartão responsivo</strong>, no qual as
            informações são organizadas verticalmente. A disposição exata dos elementos pode variar
            conforme a largura da tela, sem prejuízo de funcionalidade.
        </p>

        <h3 id="cap-6.2.1-a">Estrutura do cartão</h3>
        <ul>
            <li><strong>ID do grupo:</strong> exibido no topo do cartão</li>
            <li><strong>Tema do grupo:</strong> logo abaixo do identificador</li>
            <li><strong>Lista de membros:</strong> relação nominal dos alunos integrantes</li>
        </ul>

        <h3 id="cap-6.2.1-b">Trabalho associado ao grupo</h3>
        <p>
            Abaixo da listagem de membros, é exibido um botão contendo o <strong>título do último
                trabalho associado ao grupo</strong>. Ao clicar nesse botão, o arquivo é aberto para
            visualização dentro do próprio sistema.
        </p>
        <p>
            No canto direito desse botão, encontra-se um menu de ações representado por três pontos.
            Ao acioná-lo, são exibidas as seguintes opções:
        </p>
        <ul>
            <li><strong>Visualizar:</strong> abre o arquivo dentro do sistema</li>
            <li><strong>Nova aba:</strong> abre o arquivo em uma nova aba do navegador</li>
            <li><strong>Baixar:</strong> realiza o download do arquivo</li>
        </ul>

        <h3 id="cap-6.2.1-c">Estado e ações do grupo</h3>
        <p>
            Na parte inferior do cartão, é exibida uma etiqueta de estado indicando se o grupo está
            <strong>Ativo</strong> (em azul) ou <strong>Inativo</strong> (em cinza), seguida pelos botões
            de ação disponíveis:
        </p>
        <ul>
            <li><strong>Alterar:</strong> abre o modal de edição do grupo</li>
            <li><strong>Inativar:</strong> altera o estado do grupo para inativo</li>
        </ul>
        <p>
            Quando o grupo se encontra no estado <strong>Inativo</strong>, o botão <strong>"Alterar"</strong>
            deixa de ser exibido, permanecendo apenas a opção de <strong>"Ativar"</strong>. Esse
            comportamento é padronizado em todas as tabelas e cartões do sistema.
        </p>

        <h2 id="cap-6.2.2">6.2.2 Cadastro e edição de grupos</h2>
        <p>
            Ao clicar em <strong>"Cadastrar grupo"</strong>, é aberto um modal para criação ou edição do grupo,
            contendo os seguintes campos
        </p>
        <ul>
            <li><strong>Tema do grupo</strong></li>
            <li><strong>Atribuir trabalho do grupo</strong></li>
            <li><strong>Busca de membros do grupo</strong></li>
        </ul>

        <h3 id="cap-6.2.2-a">Atribuição de trabalhos ao grupo</h3>
        <p>
            A atribuição de trabalhos é realizada por meio do upload de arquivos no formato <strong>PDF</strong>,
            com tamanho máximo de <strong>5 MB</strong>. Ao selecionar um arquivo, é exibida uma área interna
            de configuração do trabalho. Essa área apresenta informações do arquivo selecionado, incluindo nome e
            tamanho, além de campos para definição de
        </p>
        <ul>
            <li><strong>Título do trabalho</strong></li>
            <li><strong>Ano</strong></li>
            <li><strong>Semestre</strong></li>
            <li><strong>Curso</strong></li>
            <li><strong>Projeto</strong></li>
            <li><strong>Grupo do trabalho</strong></li>
        </ul>
        <p>
            Alguns campos são preenchidos automaticamente, considerando o ano e semestre atuais.
        </p>
        <p>
            O trabalho somente passa a integrar o formulário após o clique no botão <strong>"+"</strong>.
            Caso contrário, o arquivo selecionado é desconsiderado.
        </p>

        <h3 id="cap-6.2.2-b">Lista de trabalhos do grupo</h3>
        <p>
            Os trabalhos adicionados são exibidos em uma lista de menus expansíveis.
            Trabalhos recém-adicionados são identificados com a etiqueta <strong>"Pendente"</strong>,
            removida após o salvamento do grupo. Além dos campos já citados, para os trabalhos adicionados
            também é possível
        </p>
        <ul>
            <li>Visualizar o arquivo dentro do sistema ou abrir em nova aba</li>
            <li>Realizar download do arquivo</li>
            <li>Inativar o trabalho clicando no botão de exclusão <strong>"X"</strong></li>
        </ul>
        <p>
            O botão <strong>“Fechar todos”</strong> possibilita recolher todos os itens da lista de uma só vez.
            Na parte inferior de cada menu expansível, também é exibido o tamanho do arquivo em MB (megabytes).
            Ao final da lista, é apresentado o tamanho total ocupado por todos os trabalhos vinculados ao grupo.
        </p>

        <h3 id="cap-6.2.2-c">Seleção de membros do grupo</h3>
        <p>
            A seleção de membros é realizada por meio de um campo de busca que permite localizar alunos
            pelo nome ou RA. Os resultados são exibidos dinamicamente, com limite de até 20 registros.
        </p>
        <p>
            Ao selecionar um aluno, ele é adicionado à lista de <strong>alunos selecionados</strong>,
            podendo ser removido a qualquer momento pelo botão de exclusão.
        </p>
    </section>

    {{-- Capítulo 6.3 --}}
    <section>
        {{-- Capítulo 6.3 --}}
        <section>
            <h2 id="cap-6.3">6.3 Gerenciamento de bancas</h2>

            <p>
                A aba <strong>"Bancas"</strong> apresenta as bancas avaliadoras em formato de
                <strong>cartões responsivos</strong>, seguindo o mesmo padrão visual e funcional da
                aba de <strong>grupos</strong>. A tela conta com botão de cadastro, campo de busca, filtros e opção
                para limpar filtros.
            </p>
        </section>

        {{-- Capítulo 6.3.1 --}}
        <section>
            <h2 id="cap-6.3.1">6.3.1 Visualização das bancas</h2>

            <p>
                Cada cartão pode alternar dinamicamente entre a <strong>visualização da banca</strong>
                e a <strong>visualização do grupo</strong> associado àquela banca.
            </p>

            <h3 id="cap-6.3.1-a">Alternância entre bancas e grupos</h3>
            <p>
                Logo abaixo da barra de ações, estão disponíveis os botões <strong>"Bancas"</strong>
                e <strong>"Grupos"</strong>. Esses botões alternam <strong>globalmente</strong> a
                visualização de todos os cartões exibidos na página atual.
            </p>
            <p>
                Além disso, cada cartão possui, em seu topo, um botão individual que permite alternar
                apenas aquele cartão entre a visualização de banca e a visualização de grupo.
            </p>

            <h3 id="cap-6.3.1-b">Visualização da banca</h3>
            <ul>
                <li><strong>ID da banca:</strong> exibido no topo do cartão</li>
                <li><strong>Criador:</strong> nome do coordenador responsável pela criação da banca</li>
                <li><strong>Nome da banca:</strong> identificação textual da banca</li>
                <li><strong>Lista de membros:</strong> integrantes da banca com indicação de função (ex.: Orientador, Membro)</li>
            </ul>
            <p>
                Na parte inferior do cartão são exibidos a etiqueta de estado
                <strong>Ativo</strong> ou <strong>Inativo</strong>, seguida pelos botões de ação
                disponíveis:
            </p>
            <ul>
                <li><strong>Alterar:</strong> edição das informações da banca</li>
                <li><strong>Inativar ou Ativar:</strong> alteração do estado da banca</li>
            </ul>

            <h3 id="cap-6.3.1-c">Visualização do grupo associado à banca</h3>
            <p>
                Ao alternar o cartão para a visualização de grupo, são exibidas informações referentes
                ao <strong>grupo que possui o trabalho associado à banca</strong>.
            </p>
            <ul>
                <li><strong>ID do grupo</strong></li>
                <li><strong>Tema do grupo</strong></li>
                <li><strong>Lista de membros do grupo</strong></li>
            </ul>

            <h3 id="cap-6.3.1-d">Trabalho avaliado pela banca</h3>
            <p>
                Abaixo da listagem de membros, é exibido um botão que representa o trabalho associado à
                banca. Esse botão permite acesso ao arquivo e conta com um menu de ações (três pontos),
                contendo as opções:
            </p>
            <ul>
                <li><strong>Visualizar:</strong> abre o arquivo dentro do sistema</li>
                <li><strong>Nova aba:</strong> abre o arquivo em uma nova aba do navegador</li>
                <li><strong>Baixar:</strong> realiza o download do arquivo</li>
            </ul>
        </section>

        {{-- Capítulo 6.3.2 --}}
        <section>
            <h2 id="cap-6.3.2">6.3.2 Cadastro e edição de bancas</h2>

            <p>
                O cadastro e a edição de bancas são realizados por meio de um modal, acessado a partir da tela de gerenciamento de bancas.
                O modal concentra todas as configurações necessárias para a definição da banca avaliadora, incluindo grupo, trabalho, rubricas e membros.
            </p>

            <h3 id="cap-6.3.2-a">Campos do formulário</h3>
            <ul>
                <li><strong>Nome da Banca:</strong> identificação textual da banca</li>
                <li><strong>Grupo:</strong> seleção do grupo associado à banca</li>
                <li><strong>Trabalho para avaliação:</strong> seleção do trabalho do grupo que será avaliado</li>
            </ul>

            <h3 id="cap-6.3.2-b">Rubricas</h3>
            <p>
                O campo <strong>Rubricas</strong> funciona como um campo de busca dinâmica. À medida que o usuário digita, são exibidas sugestões de rubricas cadastradas no sistema.
            </p>
            <p>
                Ao clicar em uma rubrica da lista filtrada, ela é adicionada à listagem abaixo do campo de busca. Cada rubrica adicionada possui um campo para definição de <strong>peso</strong>.
            </p>
            <ul>
                <li>É obrigatório selecionar, no mínimo, duas rubricas</li>
                <li>Deve existir pelo menos uma rubrica do tipo <strong>"Individual"</strong> e uma do tipo <strong>"Em grupo"</strong></li>
                <li>A soma dos pesos de todas as rubricas deve totalizar <strong>100%</strong></li>
            </ul>
            <p>
                Caso essas regras não sejam atendidas, o sistema impede o salvamento da banca.
            </p>

            <h3 id="cap-6.3.2-c">Tipo de membro</h3>
            <p>
                O campo <strong>"Tipo de membro"</strong> define a função que será atribuída aos membros adicionados à banca. As opções disponíveis são:
            </p>
            <ul>
                <li>Convidado</li>
                <li>Coordenador</li>
                <li>Especialista</li>
                <li>Membro</li>
                <li>Orientador</li>
                <li>Presidente</li>
            </ul>
            <p>
                O tipo selecionado neste campo será aplicado automaticamente a todos os membros adicionados
                enquanto estiver ativo, podendo ser alterado a qualquer momento.

                O membro <strong>presidente</strong> é o líder da banca, responsável pela contagem do tempo de
                apresentação do grupo e pela condução da arguição. Caso não haja um presidente designado, a
                contagem do tempo deverá ser realizada pelo usuário responsável pelo cadastro da banca.
            </p>

            <h3 id="cap-6.3.2-d">Membros da banca</h3>
            <p>
                O campo de busca de membros funciona de forma semelhante à busca de membros do grupo. À medida que o usuário digita, são exibidas até <strong>20 sugestões</strong> de coordenadores e professores.
            </p>
            <p>
                Cada item da lista exibe o <strong>tipo do usuário</strong> (coordenador ou professor), o nome e o identificador. Ao clicar em um membro, ele é adicionado à lista de membros da banca com o tipo definido no campo <strong>"Tipo de membro"</strong>.
            </p>
            <p>
                Os membros adicionados são exibidos em uma lista abaixo, cada um com um botão de exclusão no canto direito, que permite removê-los da banca. As alterações somente são efetivadas após clicar em <strong>"Salvar"</strong>.
            </p>

            <h3 id="cap-6.3.2-e">Botão Avaliar / Avaliação</h3>
            <p>
                No topo do modal existe um botão contextual, que pode assumir os rótulos <strong>"Avaliar"</strong> ou
                <strong>"Avaliação"</strong>, dependendo do estado da banca.
            </p>
            <ul>
                <li><strong>Avaliar:</strong> exibido para coordenadores que ainda não realizaram a avaliação</li>
                <li><strong>Avaliação:</strong> exibido quando a avaliação já foi realizada</li>
            </ul>
            <p>
                Ao clicar em <strong>"Avaliar"</strong>, o professor ou coordenador é redirecionado para a tela de avaliação da banca, desde que dentro do prazo.
            </p>
            <p>
                Caso o período de avaliação já tenha sido encerrado e o membro não tenha avaliado, o sistema exibe um aviso no topo da tela informando: <strong>"Banca finalizada!"</strong>.
            </p>

            <h3 id="cap-6.3.2-f">Notificação por e-mail</h3>
            <p>
                No fim do modal de cadastro e edição de bancas, há uma opção de notificação por e-mail,
                apresentada por meio de uma caixa de seleção (checkbox).
            </p>
            <p>
                O texto exibido nessa opção varia conforme o contexto da operação:
            </p>
            <ul>
                <li>
                    <strong>Criação de banca:</strong>
                    <em>"Notificar membros sobre participação na banca"</em>
                </li>
                <li>
                    <strong>Edição de banca:</strong>
                    <em>"Notificar novo(s) membros sobre participação na banca"</em>
                </li>
            </ul>
            <p>
                Quando a opção está marcada, o sistema envia automaticamente um e-mail de convite aos
                membros envolvidos:
            </p>
            <ul>
                <li>Na criação da banca, todos os membros selecionados recebem a notificação</li>
                <li>Na edição da banca, apenas os membros adicionados após a criação recebem o convite</li>
            </ul>
            <p>
                Caso a opção não seja marcada, nenhuma notificação por e-mail é enviada, e a banca é
                criada ou atualizada normalmente.
            </p>
        </section>
    </section>
@endcan

    {{-- Capítulo 6.4 --}}
    <section>
        <h2 id="cap-6.4">6.4 Visualização do grupo pelo aluno</h2>

        <p>
            Essa página apresenta exclusivamente as informações referentes ao grupo ao qual
            o aluno está vinculado. A interface é organizada em blocos informativos e listagem
            de trabalhos, mantendo o padrão visual do sistema.
        </p>

        <h3 id="cap-6.4.1-a">Informações do grupo</h3>
        <ul>
            <li><strong>ID do grupo:</strong> identificador exibido no topo da página</li>
            <li><strong>Tema do grupo:</strong> título principal do grupo</li>
            <li><strong>Quantidade de membros:</strong> total de integrantes vinculados</li>
            <li><strong>Quantidade de trabalhos:</strong> total de arquivos cadastrados</li>
            <li><strong>Status:</strong> indicação se o grupo está ativo ou inativo</li>
            <li><strong>Data de criação:</strong> registro da criação do grupo</li>
            <li><strong>Última atualização:</strong> data da modificação mais recente</li>
        </ul>

        <h3 id="cap-6.4.1-b">Membros do grupo</h3>
        <p>
            A seção de membros do grupo apresenta a listagem nominal dos integrantes do grupo.
        </p>
        <ul>
            <li><strong>Nome completo</strong> de cada integrante</li>
            <li><strong>Identificação visual</strong> (avatar ou iniciais)</li>
        </ul>
        <p>
            O aluno possui permissão apenas de <strong>visualização</strong>, não sendo possível
            alterar a composição do grupo.
        </p>

        <h3 id="cap-6.4.1-c">Trabalhos do grupo</h3>
        <p>
            A página exibe a listagem de trabalhos vinculados ao grupo.
            Cada trabalho é apresentado como um <strong>item expansível</strong>.
        </p>
        <ul>
            <li><strong>Nome do arquivo</strong></li>
            <li><strong>Ano</strong></li>
            <li><strong>Semestre</strong></li>
            <li><strong>Projeto</strong></li>
            <li><strong>Curso</strong></li>
        </ul>
        <p>
            Os itens da lista são clicáveis. Ao clicar sobre o nome do trabalho,
            é exibido um painel expandido logo abaixo do próprio item,
            contendo informações adicionais e ações disponíveis.
        </p>
        <ul>
            <li><strong>Visualizar:</strong> abre o arquivo dentro do sistema</li>
            <li><strong>Nova aba:</strong> abre o arquivo em uma nova aba do navegador</li>
            <li><strong>Baixar:</strong> realiza o download do arquivo</li>
        </ul>
        <p>
            Trabalhos marcados como <strong>"inativo"</strong> permanecem visíveis na listagem,
            identificados por etiqueta específica, porém sem alteração estrutural
            na organização da página.
        </p>
    </section>
</div>
<aside class="chapter-aside flex-1 hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-bold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-500 dark:text-gray-400 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        @can('is-admin')
            <a href="#cap-6.1" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
                6.1 Gerenciamento de cursos
            </a>
            <a href="#cap-6.1-a" class="sub-chapter-link block mb-1 !pl-10">
                Estrutura da tabela
            </a>
            <a href="#cap-6.1-b" class="sub-chapter-link block mb-1 !pl-10">
                Barra de ações e filtros
            </a>
            <a href="#cap-6.1-c" class="sub-chapter-link block mb-3 !pl-10">
                Cadastro e edição
            </a>

            <a href="#cap-6.2" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
                6.2 Gerenciamento de grupos
            </a>

            <a href="#cap-6.2.1" class="sub-chapter-link block mb-1 !pl-7 font-semibold text-gray-700 dark:text-gray-300">
                6.2.1 Visualização dos grupos
            </a>
            <a href="#cap-6.2.1-a" class="sub-chapter-link block mb-1 !pl-10">
                Estrutura do cartão
            </a>
            <a href="#cap-6.2.1-b" class="sub-chapter-link block mb-1 !pl-10">
                Trabalho associado ao grupo
            </a>
            <a href="#cap-6.2.1-c" class="sub-chapter-link block mb-3 !pl-10">
                Estado e ações do grupo
            </a>

            <a href="#cap-6.2.2" class="sub-chapter-link block mb-1 !pl-7 font-semibold text-gray-700 dark:text-gray-300">
                6.2.2 Cadastro e edição de grupos
            </a>
            <a href="#cap-6.2.2-a" class="sub-chapter-link block mb-1 !pl-10">
                Atribuição de trabalhos ao grupo
            </a>
            <a href="#cap-6.2.2-b" class="sub-chapter-link block mb-1 !pl-10">
                Lista de trabalhos do grupo
            </a>
            <a href="#cap-6.2.2-c" class="sub-chapter-link block mb-3 !pl-10">
                Seleção de membros do grupo
            </a>

            <a href="#cap-6.3" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
                6.3 Gerenciamento de bancas
            </a>

            <a href="#cap-6.3.1" class="sub-chapter-link block mb-1 !pl-7 font-semibold text-gray-700 dark:text-gray-300">
                6.3.1 Visualização das bancas
            </a>
            <a href="#cap-6.3.1-a" class="sub-chapter-link block mb-1 !pl-10">
                Alternância entre bancas e grupos
            </a>
            <a href="#cap-6.3.1-b" class="sub-chapter-link block mb-1 !pl-10">
                Visualização da banca
            </a>
            <a href="#cap-6.3.1-c" class="sub-chapter-link block mb-1 !pl-10">
                Visualização do grupo associado à banca
            </a>
            <a href="#cap-6.3.1-d" class="sub-chapter-link block mb-3 !pl-10">
                Trabalho avaliado pela banca
            </a>

            <a href="#cap-6.3.2" class="sub-chapter-link block mb-1 !pl-7 font-semibold text-gray-700 dark:text-gray-300">
                6.3.2 Cadastro e edição de bancas
            </a>
            <a href="#cap-6.3.2-a" class="sub-chapter-link block mb-1 !pl-10">
                Campos do formulário
            </a>
            <a href="#cap-6.3.2-b" class="sub-chapter-link block mb-1 !pl-10">
                Rubricas
            </a>
            <a href="#cap-6.3.2-c" class="sub-chapter-link block mb-1 !pl-10">
                Tipo de membro
            </a>
            <a href="#cap-6.3.2-d" class="sub-chapter-link block mb-1 !pl-10">
                Membros da banca
            </a>
            <a href="#cap-6.3.2-e" class="sub-chapter-link block mb-1 !pl-10">
                Botão Avaliar / Avaliação
            </a>
            <a href="#cap-6.3.2-f" class="sub-chapter-link block mb-3 !pl-10">
                Notificação por e-mail
            </a>
        @endcan

        <a href="#cap-6.4" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            6.4 Visualização do grupo pelo aluno
        </a>
        <a href="#cap-6.4.1-a" class="sub-chapter-link block mb-1 !pl-10">
            Informações do grupo
        </a>
        <a href="#cap-6.4.1-b" class="sub-chapter-link block mb-1 !pl-10">
            Membros do grupo
        </a>
        <a href="#cap-6.4.1-c" class="sub-chapter-link block mb-3 !pl-10">
            Trabalhos do grupo
        </a>
    </nav>
</aside>
