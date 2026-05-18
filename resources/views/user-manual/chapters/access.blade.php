<div class="min-w-0 max-w-4xl w-full xl:pe-24 manual-content" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 2 --}}
    <h1>2. Acesso ao Sistema</h1>

    <section>
        {{-- Capítulo 2.1 --}}
        <h2 id="cap-2.1">2.1 Requisitos de acesso</h2>

        <ul>
            <li>Navegador web atualizado (Chrome, Firefox, Edge ou equivalente)</li>
            <li>Conexão ativa com a internet</li>
            <li>Conta de usuário previamente cadastrada no sistema (ações de cadastro são competência do coordenador acadêmico)</li>
        </ul>
        <p>
            O SIRUS pode ser acessado por diferentes dispositivos, como computadores, tablets
            e smartphones, mantendo as mesmas funcionalidades principais.
        </p>
    </section>

    <section>
        {{-- Capítulo 2.2 --}}
        <h2 id="cap-2.2">2.2 Página Inicial</h2>

        <p>
            Ao acessar o <strong>SIRUS</strong>, o usuário é direcionado à Página Inicial do sistema.
            No topo da tela encontra-se o menu de navegação principal, que disponibiliza os seguintes
            acessos:
        </p>
        <ul>
            <li><strong>Início:</strong> retorna à Página Inicial (também acessível ao clicar no logotipo do sistema)</li>
            <li><strong>Manual:</strong> acesso a este Manual do Usuário</li>
            <li><strong>Termos:</strong> acesso aos Termos de Uso</li>
            <li><strong>Privacidade:</strong> acesso à Política de Privacidade</li>
            <li><strong>Login:</strong> direciona para a tela de autenticação do sistema</li>
        </ul>

        <h3 id="cap-2.2-a">Boas-vindas</h3>
        <p>
            Abaixo do menu de navegação, é exibida uma seção de boas-vindas contendo uma breve descrição
            do sistema, além dos botões <strong>Fazer Login</strong> e <strong>Manual do Usuário</strong>.
        </p>

        <h3 id="cap-2.2-b">Navegação</h3>
        <p>
            O botão de login direciona o usuário para a tela de autenticação, enquanto o botão do manual
            permite o acesso direto a este documento.
            Caso o usuário já esteja autenticado, o texto dos botões relacionados ao login é ajustado
            automaticamente, refletindo o estado atual da sessão.
        </p>

        <h3 id="cap-2.2-c">Conteúdo complementar</h3>
        <p>
            A Página Inicial também apresenta uma seção dedicada às principais funcionalidades do sistema
            e outra com informações institucionais sobre o evento <strong>SIMBAJU</strong>.
        </p>

        <h3 id="cap-2.2-d">Rodapé</h3>
        <p>
            No rodapé da página, estão disponíveis links para os Termos de Uso e Política de Privacidade, além de um botão
            identificado com ícone de sol ou lua que permite alternar entre os temas claro e escuro da interface.
        </p>
    </section>

    <section>
        {{-- Capítulo 2.3 --}}
        <h2 id="cap-2.3">2.3 Autenticação de usuário</h2>

        <p>
            Na tela de login, você deverá:
        </p>
        <ol>
            <li>Inserir seu <strong>E-mail</strong> (endereço de e-mail cadastrado no sistema)</li>
            <li>Inserir sua <strong>Senha</strong></li>
            <li>Clicar em <strong>Entrar</strong> para validar as credenciais</li>
        </ol>
        <p>
            Caso as credenciais informadas estejam incorretas ou a conta não esteja validada,
            o sistema exibirá uma mensagem informativa indicando o motivo da falha no acesso.
        </p>

        <h3 id="cap-2.3-a">Visibilidade da senha</h3>
        <p>
            Você pode optar por manter a <strong>senha oculta</strong> enquanto digita ou
            <strong>visualizá-la</strong> ao clicar no ícone de olho localizado à direita do campo de senha.
        </p>

        <h3 id="cap-2.3-b">Manter conectado</h3>
        <p>
            Ao selecionar a opção <strong>"Manter conectado"</strong>, não será necessário realizar
            o login novamente nesse navegador, a menos que os dados de navegação sejam limpos.
        </p>

        <h3 id="cap-2.3-c">Autenticação em Dois Fatores (2FA)</h3>
        <p>
            Caso a <strong>autenticação em dois fatores (2FA)</strong> esteja ativada, após informar
            o e-mail e a senha na tela de login, você também deverá inserir o código gerado pelo
            aplicativo autenticador configurado ou um dos códigos de recuperação.
            O <strong>capítulo 3.2</strong> deste manual apresenta os detalhes sobre a ativação
            e o funcionamento dessa funcionalidade.
        </p>
        <div class="manual-alert manual-alert-warning">
            <p class="manual-alert-title">
                Dica de segurança
            </p>
            <p class="manual-alert-message">
                Nunca compartilhe sua senha com outras pessoas, pois isso compromete a segurança da sua conta.
                Para aumentar o nível de segurança da conta, recomenda-se a ativação da autenticação em dois fatores.
                Caso esqueça sua senha, siga os procedimentos
                descritos no <strong class="font-semibold"> capítulo 3.1</strong> deste manual para recuperá-la. Persistindo o problema,
                entre em contato com o administrador do sistema.
            </p>
        </div>
    </section>

    <section>
        {{-- Capítulo 2.4 --}}
        <h2 id="cap-2.4">2.4 Primeiro acesso</h2>

        <h3 id="cap-2.4-a">Autenticação de e-mail</h3>
        <p>
            No primeiro acesso ao SIRUS, será necessário validar seu e-mail. Siga os passos:
        </p>
        <ol>
            <li>Receber sua <strong>senha temporária</strong> enviada pelo sistema após o cadastro realizado pelo coordenador</li>
            <li>Fazer login usando a senha temporária</li>
            <li>Solicitar o envio do <strong>e-mail de validação</strong> (o envio pode levar alguns segundos)</li>
            <li>Acessar o link recebido para confirmar seu endereço de e-mail</li>
        </ol>

        <h3 id="cap-2.4-b">Aceite dos Temos de Uso e Política de Privacidade</h3>
        <p>
            Além de validar o e-mail, para ter acesso completo ao SIRUS é necessário aceitar os
            <strong>Termos de Uso</strong> e a <strong>Política de Privacidade</strong> do sistema.
            Essa etapa tem o objetivo de deixar claro as condições de uso do sistema
            e como os seus dados serão tratados.
        </p>
        <p>
            Antes de aceitar, é possível clicar nos termos destacados em azul — <strong>Termos de Uso</strong> e
            <strong>Política de Privacidade</strong> — e ter acesso a esses documentos.
        </p>
        <p>
            Caso concorde com a Política e os Termos, marque a opção <strong>"Eu concordo com os Termos de uso e com a Política
                de Privacidade"</strong> e, em seguida, clique em <strong>"Aceitar e continuar"</strong>.
        </p>
        <div class="manual-alert manual-alert-info">
            <p class="manual-alert-title">
                Lembre-se
            </p>
            <p class="manual-alert-message">
                O link de validação possui validade de <strong class="font-semibold">24 horas</strong>. Após esse período, será necessário
                solicitar um novo link ao realizar o login novamente.
            </p>
        </div>
    </section>

    <section>
        {{-- Capítulo 2.5 --}}
        <h2 id="cap-2.5">2.5 Interface e navegação</h2>

        <p>
            Após a autenticação, você será é direcionado à interface principal do SIRUS.
            Essa interface é composta por um <strong>menu superior fixo</strong>, presente em quase todas
            as páginas internas do sistema, responsável por centralizar a navegação entre
            as funcionalidades disponíveis.
        </p>

        <h3 id="cap-2.5-a">Navegação disponível</h3>
        <p>
            No canto esquerdo do menu encontra-se o <strong>logotipo do sistema</strong>,
            que permite retornar à Página Inicial a qualquer momento.
        </p>
        <p>
            Seguindo da esquerda para a direita, o menu disponibiliza acesso às áreas do sistema,
            conforme o perfil do usuário:
        </p>
        <ul>
            <li><strong>Agenda</strong></li>
            <li><strong>Usuários</strong></li>
            <li><strong>Cursos</strong></li>
            <li><strong>Grupos</strong></li>
            <li><strong>Bancas</strong></li>
            <li><strong>Rubricas</strong></li>
            <li><strong>Trabalhos</strong></li>
        </ul>
        <p>
            Para usuários com perfil de <strong>professor</strong> ou <strong>aluno</strong>,
            o menu é simplificado, exibindo apenas os acessos à <strong>agenda</strong> e às
            <strong>bancas</strong>, que correspondem ao histórico de avaliações. o Aluno também tem acesso
            a uma panorama geral de seu próprio <strong>grupo</strong>.
        </p>

        <h3 id="cap-2.5-b">Acesso ao perfil</h3>
        <p>
            No canto superior direito do menu é exibido o <strong>acesso ao perfil do usuário</strong>.
            Caso não exista uma imagem de perfil cadastrada, o sistema exibe automaticamente
            a <strong>letra inicial do nome do usuário</strong>.
        </p>

        <h3 id="cap-2.5-c">Cabeçalho da página</h3>
        <p>
            Abaixo do menu superior, o sistema apresenta um <strong>cabeçalho da página</strong>,
            responsável por identificar de forma sucinta o conteúdo exibido, por meio de títulos
            como <strong>"Bancas agendadas"</strong> ou <strong>"Alunos cadastrados"</strong>. Nessa cabeçalho se encontra um
            botão identificado por um ícone de sol ou lua. Clicando nele é possível alterar o tema do sistema
            (<strong>claro</strong> ou <strong>escuro</strong>).
        </p>

        <h3 id="cap-2.5-d">Escopo e disponibilidade das funcionalidades</h3>
        <p>
            A disponibilidade de menus e funcionalidades varia conforme o perfil de acesso
            do usuário. A descrição detalhada de cada área e seus respectivos fluxos é
            apresentada nos capítulos específicos deste manual.
        </p>
    </section>
</div>
<aside class="chapter-aside flex-1 hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-bold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-500 dark:text-gray-400 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-2.1" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
            2.1 Requisitos de acesso
        </a>

        <a href="#cap-2.2" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            2.2 Página Inicial
        </a>
        <a href="#cap-2.2-a" class="sub-chapter-link block mb-1 !pl-10">
            Boas-vindas
        </a>
        <a href="#cap-2.2-b" class="sub-chapter-link block mb-1 !pl-10">
            Navegação
        </a>
        <a href="#cap-2.2-c" class="sub-chapter-link block mb-1 !pl-10">
            Conteúdo complementar
        </a>
        <a href="#cap-2.2-d" class="sub-chapter-link block mb-3 !pl-10">
            Rodapé
        </a>

        <a href="#cap-2.3" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            2.3 Autenticação de usuário
        </a>
        <a href="#cap-2.3-a" class="sub-chapter-link block mb-1 !pl-10">
            Visibilidade da senha
        </a>
        <a href="#cap-2.3-b" class="sub-chapter-link block mb-1 !pl-10">
            Manter conectado
        </a>
        <a href="#cap-2.3-c" class="sub-chapter-link block mb-3 !pl-10">
            Autenticação em Dois Fatores (2FA)
        </a>

        <a href="#cap-2.4" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
            2.4 Primeiro acesso
        </a>
        <a href="#cap-2.4-a" class="sub-chapter-link block mb-1 !pl-10">
            Autenticação de e-mail
        </a>
        <a href="#cap-2.4-b" class="sub-chapter-link block mb-3 !pl-10">
            Aceite dos Temos de Uso e Política de Privacidade
        </a>

        <a href="#cap-2.5" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            2.5 Interface e navegação
        </a>
        <a href="#cap-2.5-a" class="sub-chapter-link block mb-1 !pl-10">
            Navegação disponível
        </a>
        <a href="#cap-2.5-b" class="sub-chapter-link block mb-1 !pl-10">
            Acesso ao perfil
        </a>
        <a href="#cap-2.5-c" class="sub-chapter-link block mb-1 !pl-10">
            Cabeçalho da página
        </a>
        <a href="#cap-2.5-d" class="sub-chapter-link block mb-3 !pl-10">
            Escopo e disponibilidade das funcionalidades
        </a>
    </nav>
</aside>
