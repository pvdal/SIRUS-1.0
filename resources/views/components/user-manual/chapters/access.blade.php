<div class="max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 2 --}}
    <h1 class="text-3xl font-bold mb-14 text-gray-900 dark:text-gray-100">2. Acesso ao Sistema</h1>

    {{-- Capítulo 2.1 --}}
    <h2 id="cap-2.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">2.1 Requisitos de acesso</h2>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>Navegador web atualizado (Chrome, Firefox, Edge ou equivalente)</li>
        <li>Conexão ativa com a internet</li>
        <li>Conta de usuário previamente cadastrada no sistema</li>
    </ul>
    <p class="mb-10">
        O SIRUS pode ser acessado por diferentes dispositivos, como computadores, tablets
        e smartphones, mantendo as mesmas funcionalidades principais.
    </p>

    {{-- Capítulo 2.2 --}}
    <h2 id="cap-2.2" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">2.2 Página Inicial</h2>
    <p class="mb-2">
        Ao acessar o <strong>SIRUS</strong>, o usuário é direcionado à Página Inicial do sistema.
        No topo da tela encontra-se o menu de navegação principal, que disponibiliza os seguintes
        acessos
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Início:</strong> Retorna à Página Inicial (também acessível ao clicar no logotipo do sistema)</li>
        <li><strong>Manual:</strong> Acesso ao Manual do Usuário</li>
        <li><strong>Termos:</strong> Acesso aos Termos de Uso</li>
        <li><strong>Privacidade:</strong> Acesso às Políticas de Privacidade</li>
        <li><strong>Login:</strong> Direciona para a tela de autenticação do sistema</li>
    </ul>

    <h3 id="cap-2.2-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Boas-vindas</h3>
    <p class="mb-4">
        Abaixo do menu de navegação, é exibida uma seção de boas-vindas contendo uma breve descrição
        do sistema, além dos botões <strong>Fazer Login</strong> e <strong>Manual do Usuário</strong>.
    </p>

    <h3 id="cap-2.2-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Navegação</h3>
    <p class="mb-4">
        O botão de login direciona o usuário para a tela de autenticação, enquanto o botão do manual
        permite o acesso direto a este documento.
        Caso o usuário já esteja autenticado, o texto dos botões relacionados ao login é ajustado
        automaticamente, refletindo o estado atual da sessão.
    </p>

    <h3 id="cap-2.2-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Conteúdo complementar</h3>
    <p class="mb-4">
        A Página Inicial também apresenta uma seção dedicada às principais funcionalidades do sistema
        e outra com informações institucionais sobre o evento <strong>SIMBAJU</strong>.
    </p>

    <h3 id="cap-2.2-d" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Rodapé</h3>
    <p class="mb-10">
        No rodapé da página, estão disponíveis um texto institucional do sistema, links para os
        Termos de Uso e Políticas de Privacidade, além de um botão com ícone de sol/lua que permite
        alternar entre os temas claro e escuro da interface.
    </p>

    {{-- Capítulo 2.3 --}}
    <h2 id="cap-2.3" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">2.3 Autenticação de Usuário</h2>
    <p class="mb-2">
        Na tela de login, você deverá
    </p>
    <ol class="list-decimal pl-6 space-y-1 mb-4">
        <li>Inserir seu <strong>E-mail</strong> (endereço de e-mail cadastrado no sistema)</li>
        <li>Inserir sua <strong>Senha</strong></li>
        <li>Clicar em <strong>Entrar</strong> para validar as credenciais</li>
    </ol>
    <p class="mb-4">
        Caso as credenciais informadas estejam incorretas ou a conta não esteja validada,
        o sistema exibirá uma mensagem informativa indicando o motivo da falha no acesso.
    </p>

    <h3 id="cap-2.3-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Visibilidade da senha</h3>
    <p class="mb-4">
        Você pode optar por manter a <strong>senha oculta</strong> enquanto digita ou
        <strong>visualizá-la</strong> ao clicar no ícone de olho localizado à direita do campo de senha.
    </p>

    <h3 id="cap-2.3-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Manter conectado</h3>
    <p class="mb-4">
        Ao selecionar a opção <strong>Manter conectado</strong>, não será necessário realizar
        o login novamente nesse navegador, a menos que os dados de navegação sejam limpos.
    </p>

    <h3 id="cap-2.3-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Autenticação de dois fatores (2FA)</h3>
    <p class="mb-4">
        Caso a <strong>autenticação de dois fatores (2FA)</strong> esteja ativada, após informar
        o e-mail e a senha na tela de login, você também deverá inserir o código gerado pelo
        aplicativo autenticador configurado ou um dos códigos de recuperação.
        O capítulo <strong>3.2</strong> deste manual apresenta os detalhes sobre a ativação
        e o funcionamento dessa funcionalidade.
    </p>
    <div class="mb-10 bg-amber-50 dark:bg-stone-800/80 border border-amber-700 dark:border-amber-400/60 rounded-lg p-4 text-amber-800 dark:text-amber-300">
        <p class="font-semibold">
            Dica de segurança
        </p>
        <p class="text-sm leading-relaxed text-gray-800 dark:text-gray-300">
            Nunca compartilhe sua senha com outras pessoas, pois isso compromete a segurança da sua conta.
            Para aumentar o nível de segurança da conta, recomenda-se a ativação da autenticação de dois fatores,
            citada em detalhes no capítulo <strong>3.2</strong> deste manual. Caso esqueça sua senha, siga os procedimentos
            descritos no capítulo <strong>3.1</strong> deste manual para recuperá-la. Persistindo o problema,
            entre em contato com o administrador do sistema.
        </p>
    </div>

    {{-- Capítulo 2.4 --}}
    <h2 id="cap-2.4" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">2.4 Primeiro Acesso</h2>
    <p class="mb-2">
        No primeiro acesso ao SIRUS, será necessário validar seu e-mail. Siga os passos:
    </p>
    <ol class="list-decimal pl-6 space-y-1 mb-4">
        <li>Receber sua <strong>senha temporária</strong> enviada pelo sistema após o cadastro realizado pelo coordenador</li>
        <li>Fazer login usando a senha temporária</li>
        <li>Solicitar o envio do <strong>e-mail de validação</strong></li>
        <li>Acessar o link enviado para confirmar seu endereço de e-mail</li>
        <li>Aceitar os <strong>Termos de Uso</strong> e <strong>Políticas de Privacidade</strong></li>
        <li>Acessar o SIRUS com acesso completo</li>
    </ol>
    <p class="mb-10">
        O link de validação possui validade de <strong>24 horas</strong>. Após esse período, será necessário
        solicitar um novo link ao realizar o login novamente.
    </p>

    {{-- Capítulo 2.5 --}}
    <h2 id="cap-2.5" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">
        2.5 Interface e Navegação
    </h2>
    <p class="mb-4">
        Após a autenticação, o usuário é direcionado à interface principal do SIRUS.
        Essa interface é composta por um <strong>menu superior fixo</strong>, presente em todas
        as páginas internas do sistema, responsável por centralizar a navegação entre
        as funcionalidades disponíveis.
    </p>

    <h3 id="cap-2.5-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Navegação disponível</h3>
    <p class="mb-2">
        No canto esquerdo do menu encontra-se o <strong>logotipo do sistema</strong>,
        que permite retornar à Página Inicial a qualquer momento.
    </p>
    <p class="mb-2">
        Seguindo da esquerda para a direita, o menu disponibiliza acesso às áreas do sistema,
        conforme o perfil do usuário
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Agenda</strong></li>
        <li><strong>Usuários</strong></li>
        <li><strong>Cursos</strong></li>
        <li><strong>Grupos</strong></li>
        <li><strong>Bancas</strong></li>
        <li><strong>Rubricas</strong></li>
        <li><strong>Trabalhos</strong></li>
    </ul>
    <p class="mb-4">
        Para usuários com perfil de <strong>professor</strong> ou <strong>aluno</strong>,
        o menu é simplificado, exibindo apenas os acessos à <strong>Agenda</strong> e às
        <strong>Bancas</strong>.
    </p>

    <h3 id="cap-2.5-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Acesso ao perfil</h3>
    <p class="mb-4">
        No canto superior direito do menu é exibido o <strong>acesso ao perfil do usuário</strong>.
        Caso não exista uma imagem de perfil cadastrada, o sistema exibe automaticamente
        a <strong>letra inicial do nome do usuário</strong>.
    </p>

    <h3 id="cap-2.5-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Cabeçalho da página</h3>
    <p class="mb-4">
        Abaixo do menu superior, o sistema apresenta um <strong>cabeçalho da página</strong>,
        responsável por identificar de forma sucinta o conteúdo exibido, por meio de títulos
        como <em>"Bancas agendadas"</em> ou <em>"Alunos cadastrados"</em>. Nessa cabeçalho se encontra um
        botão identificado por um ícone de sol/lua, clicando nele é possível alterar o tema do sistema
        (<strong>claro</strong> ou <strong>escuro</strong>).
    </p>

    <h3 id="cap-2.5-d" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Escopo e disponibilidade das funcionalidades</h3>
    <p>
        A disponibilidade de menus e funcionalidades varia conforme o perfil de acesso
        do usuário. A descrição detalhada de cada área e seus respectivos fluxos é
        apresentada nos capítulos específicos deste manual.
    </p>
</div>
<aside class="chapter-aside hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed text-gray-700 dark:text-gray-300 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-2.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
            <span class="font-semibold">2.1</span>
            <span>Requisitos de acesso</span>
        </a>

        <a href="#cap-2.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-semibold">2.2</span>
            <span>Página Inicial</span>
        </a>
        <a href="#cap-2.2-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Boas-vindas</span>
        </a>
        <a href="#cap-2.2-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Navegação</span>
        </a>
        <a href="#cap-2.2-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Conteúdo complementar</span>
        </a>
        <a href="#cap-2.2-d" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Rodapé</span>
        </a>

        <a href="#cap-2.3" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-semibold">2.3</span>
            <span>Autenticação de Usuário</span>
        </a>
        <a href="#cap-2.3-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Visibilidade da senha</span>
        </a>
        <a href="#cap-2.3-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Manter conectado</span>
        </a>
        <a href="#cap-2.3-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Autenticação de dois fatores (2FA)</span>
        </a>

        <a href="#cap-2.4" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
            <span class="font-semibold">2.4</span>
            <span>Primeiro Acesso</span>
        </a>

        <a href="#cap-2.5" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-semibold">2.5</span>
            <span>Interface e Navegação</span>
        </a>
        <a href="#cap-2.5-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Navegação disponível</span>
        </a>
        <a href="#cap-2.5-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Acesso ao perfil</span>
        </a>
        <a href="#cap-2.5-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Cabeçalho da página</span>
        </a>
        <a href="#cap-2.5-d" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Escopo e disponibilidade das funcionalidades</span>
        </a>
    </nav>
</aside>
