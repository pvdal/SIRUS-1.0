<div class="max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 6 --}}
    <h1 class="text-3xl font-bold mb-14 text-gray-900 dark:text-gray-100">6. Configurações Institucionais</h1>

@can('is-admin')
    {{-- Capítulo 6.1 --}}
    <h2 id="cap-6.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">6.1 Gerenciamento de Cursos</h2>
    <p class="mb-4">
        A página de <strong>gerenciamento de cursos</strong> é acessada pelo menu superior do sistema,
        por meio da opção <strong>"Cursos"</strong>. A visualização é apresentada em formato de tabela,
        seguindo o mesmo padrão das demais telas administrativas.
    </p>

    <h3 id="cap-6.1-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Estrutura da tabela</h3>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>ID:</strong> identificador do curso</li>
        <li><strong>Nome:</strong> nome do curso</li>
        <li><strong>Turno:</strong> manhã, Tarde ou Noite</li>
        <li><strong>Coordenador:</strong> responsável pelo curso</li>
        <li><strong>Estado:</strong> ativo ou Inativo</li>
        <li><strong>Ações:</strong> alterar, Inativar ou Ativar</li>
    </ul>

    <h3 id="cap-6.1-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Barra de ações e filtros</h3>
    <p class="mb-2">
        Acima da tabela, encontra-se uma barra de ações e filtros contendo
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>Botão <strong>"Cadastrar curso"</strong>, que abre o modal de criação de curso</li>
        <li>Campo de busca textual</li>
        <li>Filtros disponíveis (<strong>Estado</strong> e <strong>Período</strong>)</li>
        <li>Opção <strong>Limpar filtros</strong></li>
    </ul>

    <h3 id="cap-6.1-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Cadastro e edição</h3>
    <p class="mb-2">
        O modal de cadastro e edição de cursos possui os campos
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Nome do curso</strong></li>
        <li><strong>Turno</strong></li>
        <li><strong>Coordenador</strong></li>
    </ul>
    <p class="mb-10">
        As ações de edição, inativação e paginação seguem o mesmo comportamento descrito no capítulo
        de Gerenciamento de Usuários, com exibição de até <strong>30 registros por página</strong>.
    </p>

    {{-- Capítulo 6.2 --}}
    <h2 id="cap-6.2" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">6.2 Gerenciamento de Grupos</h2>
    <p class="mb-4">
        O gerenciamento de grupos é acessado pelo menu superior do sistema e apresenta uma interface
        que reune informações acadêmicas, trabalhos associados e membros do grupo.
        A visualização é feita por meio de <strong>cartões</strong>.
    </p>

    <h2 id="cap-6.2.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">6.2.1 Visualização dos grupos</h2>
    <p class="mb-4">
        Cada grupo é apresentado em formato de <strong>cartão responsivo</strong>, no qual as
        informações são organizadas verticalmente. A disposição exata dos elementos pode variar
        conforme a largura da tela, sem prejuízo de funcionalidade.
    </p>

    <h3 id="cap-6.2.1-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Estrutura do cartão</h3>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>ID do grupo:</strong> exibido no topo do cartão</li>
        <li><strong>Tema do grupo:</strong> logo abaixo do identificador</li>
        <li><strong>Lista de membros:</strong> relação nominal dos alunos integrantes</li>
    </ul>

    <h3 id="cap-6.2.1-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Trabalho associado ao grupo</h3>
    <p class="mb-2">
        Abaixo da listagem de membros, é exibido um botão contendo o <strong>título do último
            trabalho associado ao grupo</strong>. Ao clicar nesse botão, o arquivo é aberto para
        visualização dentro do próprio sistema.
    </p>
    <p class="mb-2">
        No canto direito desse botão, encontra-se um menu de ações representado por três pontos.
        Ao acioná-lo, são exibidas as seguintes opções:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Visualizar:</strong> abre o arquivo dentro do sistema</li>
        <li><strong>Nova aba:</strong> abre o arquivo em uma nova aba do navegador</li>
        <li><strong>Baixar:</strong> realiza o download do arquivo</li>
    </ul>

    <h3 id="cap-6.2.1-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Estado e ações do grupo</h3>
    <p class="mb-2">
        Na parte inferior do cartão, é exibida uma etiqueta de estado indicando se o grupo está
        <strong>Ativo</strong> (em azul) ou <strong>Inativo</strong> (em cinza), seguida pelos botões
        de ação disponíveis:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Alterar:</strong> abre o modal de edição do grupo</li>
        <li><strong>Inativar:</strong> altera o estado do grupo para inativo</li>
    </ul>
    <p class="mb-4">
        Quando o grupo se encontra no estado <strong>Inativo</strong>, o botão <strong>"Alterar"</strong>
        deixa de ser exibido, permanecendo apenas a opção de <strong>"Ativar"</strong>. Esse
        comportamento é padronizado em todas as tabelas e cartões do sistema.
    </p>

    <h2 id="cap-6.2.2" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">6.2.2 Cadastro e edição de grupos</h2>
    <p class="mb-2">
        Ao clicar em <strong>"Cadastrar grupo"</strong>, é aberto um modal para criação ou edição do grupo,
        contendo os seguintes campos
    </p>
    <ul class="list-disc pl-6 space-y-2 mb-4">
        <li><strong>Tema do grupo</strong></li>
        <li><strong>Atribuir trabalho do grupo</strong></li>
        <li><strong>Busca de membros do grupo</strong></li>
    </ul>

    <h3 id="cap-6.2.2-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Atribuição de trabalhos ao grupo</h3>
    <p class="mb-2">
        A atribuição de trabalhos é realizada por meio do upload de arquivos no formato <strong>PDF</strong>,
        com tamanho máximo de <strong>5 MB</strong>. Ao selecionar um arquivo, é exibida uma área interna
        de configuração do trabalho. Essa área apresenta informações do arquivo selecionado, incluindo nome e
        tamanho, além de campos para definição de
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Ano</strong></li>
        <li><strong>Semestre</strong></li>
        <li><strong>Projeto</strong></li>
        <li><strong>Versão</strong></li>
        <li><strong>Curso</strong></li>
    </ul>
    <p class="mb-2">
        Alguns campos são preenchidos automaticamente, considerando o ano e semestre atuais.
    </p>
    <p class="mb-4">
        O trabalho somente passa a integrar o formulário após o clique no botão <strong>"+"</strong>.
        Caso contrário, o arquivo selecionado é desconsiderado.
    </p>

    <h3 id="cap-6.2.2-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Lista de trabalhos do grupo</h3>
    <p class="mb-2">
        Os trabalhos adicionados são exibidos em uma lista de menus expansíveis.
        Trabalhos recém-adicionados são identificados com a etiqueta <strong>"Pendente"</strong>,
        removida após o salvamento do grupo. Além dos campos já citados, para os trabalhos adicionados
        também é possível
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>Editar o título do trabalho</li>
        <li>Visualizar o arquivo dentro do sistema ou abrir em nova aba</li>
        <li>Realizar download do arquivo</li>
        <li>Inativar o trabalho clicando no botão de exclusão <strong>"X"</strong></li>
    </ul>
    <p class="mb-4">
        O botão <strong>"Fechar todos"</strong> permite colapsar todos os itens da lista simultaneamente.
    </p>

    <h3 id="cap-6.2.2-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Seleção de membros do grupo</h3>
    <p class="mb-2">
        A seleção de membros é realizada por meio de um campo de busca que permite localizar alunos
        pelo nome ou RA. Os resultados são exibidos dinamicamente, com limite de até 20 registros.
    </p>
    <p class="mb-10">
        Ao selecionar um aluno, ele é adicionado à lista de <strong>alunos selecionados</strong>,
        podendo ser removido a qualquer momento pelo botão de exclusão.
    </p>

    {{-- Capítulo 6.3 --}}
    <h2 id="cap-6.3" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">6.3 Gerenciamento de Bancas</h2>
    <p class="mb-4">
        A aba <strong>"Bancas"</strong> apresenta as bancas de avaliação em formato de
        <strong>cartões responsivos</strong>, seguindo o mesmo padrão visual e funcional da
        aba de <strong>grupos</strong>. A tela conta com botão de cadastro, campo de busca, filtros e opção
        para limpar filtros.
    </p>

    <h2 id="cap-6.3.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">6.3.1 Visualização das bancas</h2>
    <p class="mb-4">
        Cada cartão pode alternar dinamicamente entre a <strong>visualização da banca</strong>
        e a <strong>visualização do grupo</strong> associado àquela banca.
    </p>

    <h3 id="cap-6.3.1-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Alternância entre Bancas e Grupos</h3>
    <p class="mb-2">
        Logo abaixo da barra de ações, estão disponíveis os botões <strong>"Bancas"</strong>
        e <strong>"Grupos"</strong>. Esses botões alternam <strong>globalmente</strong> a
        visualização de todos os cartões exibidos na página atual.
    </p>
    <p class="mb-4">
        Além disso, cada cartão possui, em seu topo, um botão individual que permite alternar
        apenas aquele cartão entre a visualização de banca e a visualização de grupo.
    </p>

    <h3 id="cap-6.3.1-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Visualização da banca</h3>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>ID da banca:</strong> exibido no topo do cartão</li>
        <li><strong>Criador:</strong> nome do coordenador responsável pela criação da banca</li>
        <li><strong>Nome da banca:</strong> identificação textual da banca</li>
        <li><strong>Lista de membros:</strong> integrantes da banca com indicação de papel (ex.: Orientador, Membro)</li>
    </ul>
    <p class="mb-2">
        Na parte inferior do cartão são exibidos a etiqueta de estado
        <strong>Ativo</strong> ou <strong>Inativo</strong>, seguida pelos botões de ação
        disponíveis:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Alterar:</strong> edição das informações da banca</li>
        <li><strong>Inativar ou Ativar:</strong> alteração do estado da banca</li>
    </ul>

    <h3 id="cap-6.3.1-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Visualização do grupo associado à banca</h3>
    <p class="mb-2">
        Ao alternar o cartão para a visualização de grupo, são exibidas informações referentes
        ao <strong>grupo que possui o trabalho associado à banca</strong>.
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>ID do grupo</strong></li>
        <li><strong>Tema do grupo</strong></li>
        <li><strong>Lista de membros do grupo</strong></li>
    </ul>

    <h3 id="cap-6.3.1-d" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Trabalho avaliado pela banca</h3>
    <p class="mb-2">
        Abaixo da listagem de membros, é exibido um botão que representa o trabalho associado à
        banca. Esse botão permite acesso ao arquivo e conta com um menu de ações (três pontos),
        contendo as opções:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Visualizar:</strong> abre o arquivo dentro do sistema</li>
        <li><strong>Nova aba:</strong> abre o arquivo em uma nova aba do navegador</li>
        <li><strong>Baixar:</strong> realiza o download do arquivo</li>
    </ul>
    <p class="mb-2">
        Abaixo desse botão, estão disponíveis as opções <strong>"Avaliação"</strong> e
        <strong>"Corrigido"</strong>, que alternam dinamicamente o arquivo exibido:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Avaliação:</strong> versão avaliada pela banca</li>
        <li><strong>Corrigido:</strong> versão corrigida do trabalho após a avaliação</li>
    </ul>

    <h2 id="cap-6.3.2" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">6.3.2 Cadastro e edição de bancas</h2>
    <p class="mb-4">
        O cadastro e a edição de bancas são realizados por meio de um modal, acessado a partir da tela de gerenciamento de bancas.
        O modal concentra todas as configurações necessárias para a definição da banca avaliativa, incluindo grupo, trabalho, rubricas e membros.
    </p>

    <h3 id="cap-6.3.2-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Campos do formulário</h3>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Nome da Banca:</strong> identificação textual da banca</li>
        <li><strong>Grupo:</strong> seleção do grupo associado à banca</li>
        <li><strong>Trabalho para avaliação:</strong> seleção do trabalho do grupo que será avaliado</li>
    </ul>

    <h3 id="cap-6.3.2-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Rubricas</h3>
    <p class="mb-2">
        O campo <strong>Rubricas</strong> funciona como um campo de busca dinâmica. À medida que o usuário digita, são exibidas sugestões de rubricas cadastradas no sistema.
    </p>
    <p class="mb-2">
        Ao clicar em uma rubrica da lista filtrada, ela é adicionada à listagem abaixo do campo de busca. Cada rubrica adicionada possui um campo para definição de <strong>peso</strong>.
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>É obrigatório selecionar, no mínimo, duas rubricas</li>
        <li>Deve existir pelo menos uma rubrica do tipo <strong>Individual</strong> e uma do tipo <strong>Em grupo</strong></li>
        <li>A soma dos pesos de todas as rubricas deve totalizar <strong>100%</strong></li>
    </ul>
    <p class="mb-4">
        Caso essas regras não sejam atendidas, o sistema impede o salvamento da banca.
    </p>

    <h3 id="cap-6.3.2-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Tipo de membro</h3>
    <p class="mb-2">
        O campo <strong>"Tipo de membro"</strong> define o papel que será atribuído aos membros adicionados à banca. As opções disponíveis são:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>Convidado</li>
        <li>Coordenador</li>
        <li>Especialista</li>
        <li>Membro</li>
        <li>Orientador</li>
        <li>Presidente</li>
    </ul>
    <p class="mb-4">
        O tipo selecionado nesse campo será aplicado automaticamente a todos os membros adicionados enquanto ele estiver ativo, podendo ser alterado a qualquer momento.
    </p>

    <h3 id="cap-6.3.2-d" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Membros da banca</h3>
    <p class="mb-2">
        O campo de busca de membros funciona de forma semelhante à busca de membros do grupo. À medida que o usuário digita, são exibidas até <strong>20 sugestões</strong> de coordenadores e professores.
    </p>
    <p class="mb-2">
        Cada item da lista exibe o <strong>tipo do usuário</strong> (Coordenador ou Professor), o nome e o identificador. Ao clicar em um membro, ele é adicionado à lista de membros da banca com o tipo definido no campo <strong>"Tipo de membro"</strong>.
    </p>
    <p class="mb-4">
        Os membros adicionados são exibidos em uma lista abaixo, cada um com um botão de exclusão no canto direito, que permite removê-los da banca. As alterações somente são efetivadas após clicar em <strong>"Salvar"</strong>.
    </p>

    <h3 id="cap-6.3.2-e" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Botão Avaliar / Avaliação</h3>
    <p class="mb-2">
        No topo do modal existe um botão contextual, que pode assumir os rótulos <strong>"Avaliar"</strong> ou
        <strong>"Avaliação"</strong>, dependendo do estado da banca.
    </p>
    <ul class="list-disc pl-6 space-y-2 mb-4">
        <li><strong>Avaliar:</strong> exibido para coordenadores que ainda não realizaram a avaliação</li>
        <li><strong>Avaliação:</strong> exibido quando a avaliação já foi realizada</li>
    </ul>
    <p class="mb-2">
        Ao clicar em <strong>"Avaliar"</strong>, o professor ou coordenador é redirecionado para a tela de avaliação da banca, desde que dentro do prazo.
    </p>
    <p class="mb-4">
        Caso o período de avaliação já tenha sido encerrado e o membro não tenha avaliado, o sistema exibe um aviso no topo da tela informando: <strong>"Banca finalizada!"</strong>.
    </p>

    <h3 id="cap-6.3.2-f" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Notificação por e-mail</h3>
    <p class="mb-2">
        No fim do modal de cadastro e edição de bancas, há uma opção de notificação por e-mail,
        apresentada por meio de uma caixa de seleção (checkbox).
    </p>
    <p class="mb-2">
        O texto exibido nessa opção varia conforme o contexto da operação:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>
            <strong>Criação de banca:</strong>
            <em>"Notificar membros sobre participação na banca"</em>
        </li>
        <li>
            <strong>Edição de banca:</strong>
            <em>"Notificar novo(s) membros sobre participação na banca"</em>
        </li>
    </ul>
    <p class="mb-2">
        Quando a opção está marcada, o sistema envia automaticamente um e-mail de convite aos
        membros envolvidos:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>Na criação da banca, todos os membros selecionados recebem a notificação</li>
        <li>Na edição da banca, apenas os membros adicionados após a criação recebem o convite</li>
    </ul>
    <p class="mb-10">
        Caso a opção não seja marcada, nenhuma notificação por e-mail é enviada, e a banca é
        criada ou atualizada normalmente.
    </p>
@endcan
    <h2 id="cap-6.4" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">
        6.4 Visualização do Grupo pelo Aluno
    </h2>
    <p class="mb-4">
        @can('is-admin')
            Diferentemente do coordenador, que visualiza os grupos em formato de <strong>cartões</strong>,
            o aluno possui acesso à aba <strong>"Grupo"</strong>, no singular, disponível no menu superior
            do sistema.
        @endcan
        Essa página apresenta exclusivamente as informações referentes ao grupo ao qual
        o aluno está vinculado.
    </p>

    <h2 id="cap-6.4.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">
        6.4.1 Estrutura da página
    </h2>
    <p class="mb-4">
        A interface é organizada em blocos informativos e listagem de trabalhos, mantendo o padrão
        visual do sistema.
    </p>

    <h3 id="cap-6.4.1-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">
        Informações do grupo
    </h3>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>ID do grupo:</strong> identificador exibido no topo da página</li>
        <li><strong>Tema do grupo:</strong> título principal do grupo</li>
        <li><strong>Quantidade de membros:</strong> total de integrantes vinculados</li>
        <li><strong>Quantidade de trabalhos:</strong> total de arquivos cadastrados</li>
        <li><strong>Status:</strong> indicação se o grupo está Ativo ou Inativo</li>
        <li><strong>Data de criação:</strong> registro da criação do grupo</li>
        <li><strong>Última atualização:</strong> data da modificação mais recente</li>
    </ul>

    <h3 id="cap-6.4.1-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">
        Membros do grupo
    </h3>
    <p class="mb-2">
        A seção de membros do grupo apresenta a listagem nominal dos integrantes do grupo.
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Nome completo</strong> de cada integrante</li>
        <li><strong>Identificação visual</strong> (avatar ou iniciais)</li>
    </ul>
    <p class="mb-4">
        O aluno possui permissão exclusivamente de <strong>visualização</strong>, não sendo possível
        alterar a composição do grupo.
    </p>

    <h3 id="cap-6.4.1-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">
        Trabalhos do grupo
    </h3>
    <p class="mb-2">
        A página exibe a listagem de trabalhos vinculados ao grupo.
        Cada trabalho é apresentado como um <strong>item expansível</strong>.
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Nome do arquivo</strong></li>
        <li><strong>Ano</strong></li>
        <li><strong>Semestre</strong></li>
        <li><strong>Projeto</strong></li>
        <li><strong>Versão</strong></li>
    </ul>
    <p class="mb-2">
        Os itens da lista são clicáveis. Ao clicar sobre o nome do trabalho,
        é exibido um painel expandido logo abaixo do próprio item,
        contendo informações adicionais e ações disponíveis.
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Visualizar:</strong> abre o arquivo dentro do sistema</li>
        <li><strong>Nova aba:</strong> abre o arquivo em uma nova aba do navegador</li>
        <li><strong>Baixar:</strong> realiza o download do arquivo</li>
    </ul>
    <p>
        Trabalhos marcados como <strong>Inativo</strong> permanecem visíveis na listagem,
        identificados por etiqueta específica, porém sem alteração estrutural
        na organização da página.
    </p>
</div>
<aside class="chapter-aside hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-semibold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-800 dark:text-gray-300 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
    @can('is-admin')
        <a href="#cap-6.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-medium">6.1</span>
            <span>Gerenciamento de Cursos</span>
        </a>
        <a href="#cap-6.1-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Estrutura da tabela</span>
        </a>
        <a href="#cap-6.1-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Barra de ações e filtros</span>
        </a>
        <a href="#cap-6.1-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Cadastro e edição</span>
        </a>

        <a href="#cap-6.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-medium">6.2</span>
            <span>Gerenciamento de Grupos</span>
        </a>
        <a href="#cap-6.2.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 !pl-7 font-medium">
            <span class="font-medium">6.2.1</span>
            <span>Visualização dos grupos</span>
        </a>
        <a href="#cap-6.2.1-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Estrutura do cartão</span>
        </a>
        <a href="#cap-6.2.1-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Trabalho associado ao grupo</span>
        </a>
        <a href="#cap-6.2.1-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Estado e ações do grupo</span>
        </a>

        <a href="#cap-6.2.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 !pl-7 font-medium">
            <span class="font-medium">6.2.2</span>
            <span>Cadastro e edição de grupos</span>
        </a>
        <a href="#cap-6.2.2-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Atribuição de trabalhos ao grupo</span>
        </a>
        <a href="#cap-6.2.2-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Lista de trabalhos do grupo</span>
        </a>
        <a href="#cap-6.2.2-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Seleção de membros do grupo</span>
        </a>

        <a href="#cap-6.3" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-medium">6.3</span>
            <span>Gerenciamento de Bancas</span>
        </a>

        <a href="#cap-6.3.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 !pl-7 font-medium">
            <span class="font-medium">6.3.1</span>
            <span>Visualização das bancas</span>
        </a>
        <a href="#cap-6.3.1-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Alternância entre Bancas e Grupos</span>
        </a>
        <a href="#cap-6.3.1-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Visualização da banca</span>
        </a>
        <a href="#cap-6.3.1-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Visualização do grupo associado à banca</span>
        </a>
        <a href="#cap-6.3.1-d" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Trabalho avaliado pela banca</span>
        </a>

        <a href="#cap-6.3.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 !pl-7 font-medium">
            <span class="font-medium">6.3.2</span>
            <span>Cadastro e edição de bancas</span>
        </a>
        <a href="#cap-6.3.2-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Campos do formulário</span>
        </a>
        <a href="#cap-6.3.2-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Rubricas</span>
        </a>
        <a href="#cap-6.3.2-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Tipo de membro</span>
        </a>
        <a href="#cap-6.3.2-d" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Membros da banca</span>
        </a>
        <a href="#cap-6.3.2-e" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Botão Avaliar / Avaliação</span>
        </a>
        <a href="#cap-6.3.2-f" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Notificação por e-mail</span>
        </a>
    @endcan
        <a href="#cap-6.4" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-medium">6.4</span>
            <span>Visualização do Grupo pelo Aluno</span>
        </a>

        <a href="#cap-6.4.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 !pl-7 font-medium">
            <span class="font-medium">6.4.1</span>
            <span>Estrutura da página</span>
        </a>
        <a href="#cap-6.4.1-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Informações do grupo</span>
        </a>
        <a href="#cap-6.4.1-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Membros do grupo</span>
        </a>
        <a href="#cap-6.4.1-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-600 dark:text-gray-400">
            <span>Trabalhos do grupo</span>
        </a>
    </nav>
</aside>
