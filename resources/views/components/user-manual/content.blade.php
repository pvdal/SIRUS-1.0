<div>
    {{-- Configuração do texto --}}
    @php
        $textSettings = "
            'text-base': fontSize === 1,
            'text-lg': fontSize === 2,
            'text-xl': fontSize === 3,

            'leading-normal': leadingHeight === 1,
            'leading-relaxed': leadingHeight === 2,
            'leading-loose': leadingHeight === 3,
            '[line-height:2.2]': leadingHeight === 4,

            'tracking-normal': letterSpacing === 1,
            'tracking-wide': letterSpacing === 2,
            'tracking-wider': letterSpacing === 3,
            'tracking-widest': letterSpacing === 4,

            '[word-spacing:0]': wordSpacing === 1,
            '[word-spacing:0.05em]': wordSpacing === 2,
            '[word-spacing:0.1em]': wordSpacing === 3,
            '[word-spacing:0.2em]': wordSpacing === 4,
        "
    @endphp
    {{-- Capítulos do manual --}}
    <div class="space-y-2">
        {{-- Seção 1 --}}
        <article id="introduction" class="chapter flex bg-white shadow md:rounded-sm border border-white px-8 py-20 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0 text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-400 lg:scroll-mt-[4rem]">
            <div class="max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
                {{-- Capítulo 1 --}}
                <h1 class="text-3xl font-bold mb-14 text-gray-900 dark:text-gray-100">1. Introdução</h1>

                {{-- Capítulo 1.1 --}}
                <h2 id="cap-1.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">1.1 Sobre o Sistema</h2>
                <p class="mb-4">
                    O <strong>SIRUS (Sistema de Rubricas para Gestão Avaliativa do SIMBAJU)</strong>
                    é uma plataforma web desenvolvida com o propósito de otimizar e padronizar o processo
                    de avaliação acadêmica dos trabalhos apresentados no <strong>SIMBAJU.</strong>
                    A solução propõe a centralização das informações avaliativas, a organização dos critérios
                    de desempenho e a uniformização das rubricas utilizadas pelas bancas, proporcionando maior
                    clareza, objetividade e confiabilidade ao processo avaliativo, tanto para avaliadores quanto para alunos.
                </p>

                <h3 id="cap-1.1-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Objetivos Principais</h3>
                <ul class="list-disc pl-6 space-y-1 mb-10">
                    <li>Centralizar o gerenciamento das avaliações acadêmicas em uma única plataforma</li>
                    <li>Padronizar critérios, rubricas e métodos de atribuição de notas</li>
                    <li>Facilitar a organização e o acompanhamento das bancas avaliativas e dos grupos avaliados</li>
                    <li>Organizar e disponibilizar dados de alunos, professores e coordenadores de forma estruturada</li>
                    <li>Fornecer registros, análises e relatórios que apoiem a tomada de decisão e o feedback aos alunos</li>
                </ul>

                {{-- Capítulo 1.2 --}}
                <h2 id="cap-1.2" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">1.2 Público-Alvo</h2>
                <p class="mb-2">
                    O sistema foi projetado para os seguintes usuários
                </p>
                <ul class="list-disc pl-6 space-y-1 mb-10 text-gray-800 dark:text-gray-300">
                    <li><strong>Coordenadores acadêmicos:</strong> Gerenciam toda a plataforma</li>
                    <li><strong>Professores e avaliadores:</strong> Realizam avaliações de alunos</li>
                    <li><strong>Alunos (organizados em grupos):</strong> Participam de avaliações e acompanham resultados</li>
                </ul>

                {{-- Capítulo 1.3 --}}
                <h2 id="cap-1.3" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">1.3 Sobre o SIMBAJU</h2>
                <p class="mb-10">
                    O <strong>SIMBAJU (Simpósio da Bacia do Juquery)</strong> é um evento acadêmico-científico realizado semestralmente
                    na Faculdade de Tecnologia de Franco da Rocha, no estado de São Paulo. A instituição de ensino superior
                    promove, com a apresentação dos trabalhos dos alunos, uma troca de conhecimento entre alunos e
                    especialistas, ajudando os participantes e ouvintes a terem uma formação mais sólida na área em um ambiente
                    de inovação. Para mais informações, visite o site da instituição:
                    <a
                        target="_blank"
                        rel="noopener noreferrer"
                        href="https://fatecfrancodarocha.cps.sp.gov.br/simbaju/"
                        class="text-secondary-blue dark:text-blue-400 font-medium hover:underline break-all xl:break-normal"
                    >https://fatecfrancodarocha.cps.sp.gov.br/simbaju/</a>.
                </p>

                {{-- Capítulo 1.4 --}}
                <h2 id="cap-1.4" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">1.4 Sobre este Manual do Usuário</h2>

                <h3 id="cap-1.4-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Finalidade do Manual</h3>
                <p class="mb-4">
                    Este manual do usuário tem como objetivo orientar os usuários do sistema SIRUS na utilização correta
                    e eficiente de suas funcionalidades. O documento apresenta, de forma clara e organizada, as principais
                    operações disponíveis na plataforma, considerando os diferentes perfis de acesso existentes.
                </p>

                <h3 id="cap-1.4-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Conteúdo Abordado</h3>
                <p class="mb-4">
                    Ao longo do manual, são descritos os procedimentos necessários para navegação no sistema, realização
                    de cadastros, acompanhamento das bancas avaliativas, visualização de trabalhos e registro ou consulta
                    das avaliações, conforme as permissões de cada tipo de usuário.
                </p>

                <h3 id="cap-1.4-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Público e Objetivo de Uso</h3>
                <p class="mb-8">
                    O conteúdo foi elaborado com foco na usabilidade e na compreensão prática do sistema, servindo como
                    material de apoio tanto para novos usuários quanto para aqueles que já utilizam a plataforma,
                    contribuindo para a padronização dos processos e para o uso adequado das funcionalidades disponibilizadas.
                </p>

                {{-- Capítulo 1.4.1 --}}
                <h2 id="cap-1.4.1" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">1.4.1 Navegação</h2>

                <h3 id="cap-1.4.1-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Navegação do manual</h3>
                <p class="mb-2">
                    O Manual do Usuário possui um menu de navegação que se adapta conforme o tamanho da tela do
                    dispositivo utilizado. Em tela maiores é visível na lateral esquerda da página, em telas menores,
                    é visível logo no início, antes de qualquer capítulo. Seu objetivo é possibilitar acesso rápido aos
                    capítulos deste manual.
                </p>
                <p class="mb-4">
                    No topo desse menu é exibido o título <strong>"Manual do Usuário"</strong>, acompanhado
                    de um ícone de configurações.
                    Abaixo do título, encontra-se a lista de capítulos do manual. O capítulo atualmente
                    selecionado permanece destacado, permitindo ao usuário identificar facilmente
                    sua posição no conteúdo.
                </p>

                <h3 id="cap-1.4.1-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Navegação do capítulo</h3>
                <p class="mb-4">
                    A navegação interna entre seções dos capítulos é disponibilizada apenas em telas com largura a partir
                    de <strong>1280 pixels</strong>. Nessa resolução, o controle de sua exibição e layout encontra-se
                    disponível no painel de preferências.
                </p>

                <h3 id="cap-1.4.1-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Voltar ao topo</h3>
                <p class="mb-8">
                    Para facilitar a navegação, especialmente em dispositivos móveis onde não há um
                    menu lateral fixo, o manual disponibiliza um botão de retorno ao topo da página.
                </p>

                {{-- Capítulo 1.4.2 --}}
                <h2 id="cap-1.4.2" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">1.4.2 Preferências de leitura</h2>
                <p class="mb-4">
                    Ao clicar no ícone de configurações localizado no topo do menu lateral, é exibido
                    o painel <strong>"Preferências de leitura"</strong>. Esse painel permite personalizar
                    a forma como o conteúdo do manual é apresentado, de acordo com as preferências
                    individuais de leitura.
                </p>

                <h3 id="cap-1.4.2-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Restaurar configurações</h3>
                <p class="mb-4">
                    No cabeçalho do painel de preferências, está disponível o botão <strong>Restaurar</strong>,
                    que permite redefinir todas as configurações de leitura para os valores padrão.
                </p>

                <h3 id="cap-1.4.2-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Opções disponíveis</h3>
                <ul class="list-disc pl-6 space-y-2 mb-4">
                    <li>
                        <strong>Navegação do capítulo:</strong> permite exibir ou ocultar o controle de navegação
                        interna entre seções do capítulo.
                    </li>
                    <li>
                        <strong>Tamanho da fonte:</strong> possibilita ajustar o tamanho do texto
                        (<em>A</em>, <em>A+</em> ou <em>A++</em>) para maior conforto visual.
                    </li>
                    <li>
                        <strong>Espaçamento entre linhas:</strong> ajusta a densidade vertical do texto,
                        com níveis progressivos.
                    </li>
                    <li>
                        <strong>Espaçamento entre letras:</strong> melhora a legibilidade das palavras
                        ao aumentar o espaço entre caracteres.
                    </li>
                    <li>
                        <strong>Espaçamento entre palavras:</strong> facilita a separação visual entre termos,
                        tornando a leitura mais confortável.
                    </li>
                </ul>
                <p>
                    Essas configurações afetam exclusivamente a visualização do manual.
                </p>
            </div>
            <aside class="chapter-aside hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
                <h2 class="font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-4">
                    Neste capítulo
                </h2>
                <nav class="leading-relaxed text-gray-700 dark:text-gray-300 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
                    <a href="#cap-1.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
                        <span class="font-semibold">1.1</span>
                        <span>Sobre o sistema</span>
                    </a>
                    <a href="#cap-1.1-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Objetivos Principais</span>
                    </a>

                    <a href="#cap-1.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
                        <span class="font-semibold">1.2</span>
                        <span>Público-Alvo</span>
                    </a>

                    <a href="#cap-1.3" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
                        <span class="font-semibold">1.3</span>
                        <span>Sobre o SIMBAJU</span>
                    </a>

                    <a href="#cap-1.4" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
                        <span class="font-semibold">1.4</span>
                        <span>Sobre este Manual do Usuário</span>
                    </a>
                    <a href="#cap-1.4-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Finalidade do Manual</span>
                    </a>
                    <a href="#cap-1.4-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Conteúdo Abordado</span>
                    </a>
                    <a href="#cap-1.4-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Público e Objetivo de Uso</span>
                    </a>

                    <a href="#cap-1.4.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
                        <span class="font-semibold">1.4.1</span>
                        <span>Navegação</span>
                    </a>
                    <a href="#cap-1.4.1-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Navegação do manual</span>
                    </a>
                    <a href="#cap-1.4.1-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Navegação do capítulo</span>
                    </a>
                    <a href="#cap-1.4.1-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Voltar ao topo</span>
                    </a>

                    <a href="#cap-1.4.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
                        <span class="font-semibold">1.4.1</span>
                        <span>Preferências de leitura</span>
                    </a>
                    <a href="#cap-1.4.2-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Restaurar configurações</span>
                    </a>
                    <a href="#cap-1.4.2-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Opções disponíveis</span>
                    </a>
                </nav>
            </aside>
        </article>

        {{-- Seção 2 --}}
        <article id="access" class="chapter flex bg-white shadow md:rounded-sm border border-white px-8 py-20 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0 text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-400 lg:scroll-mt-[4rem]">
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
                    2.5 Interface Principal do Sistema
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
                    como <em>"Bancas agendadas"</em> ou <em>"Alunos cadastrados"</em>.
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
                        <span>Interface Principal do Sistema</span>
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
                    <a href="#cap-2.5-d" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Escopo e disponibilidade das funcionalidades</span>
                    </a>
                </nav>
            </aside>
        </article>

        {{-- Seção 3 --}}
        <article id="security" class="chapter flex bg-white shadow md:rounded-sm border border-white px-8 py-20 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0 text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-400 lg:scroll-mt-[4rem]">
            <div class="max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
                {{-- Capítulo 3 --}}
                <h1 class="text-3xl font-bold mb-14 text-gray-900 dark:text-gray-100">3. Segurança</h1>

                {{-- Capítulo 3.1 --}}
                <h2 id="cap-3.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">3.1 Recuperação de Senha</h2>
                <p class="mb-2">
                    Caso tenha esquecido sua senha, siga o procedimento abaixo para recuperá-la.
                </p>
                <ol class="list-decimal pl-6 space-y-1 mb-4">
                    <li>
                        Acesse a Página de Login e clique em <strong>Esqueceu sua senha?</strong>.
                    </li>
                    <li>
                        Digite o e-mail cadastrado no sistema no local indicado e clique em <strong>Enviar link para redefinir senha por e-mail</strong>.
                    </li>
                    <li>
                        Verifique sua caixa de entrada (e pasta de spam), buscando por o e-mail de recuperação enviado pelo sistema.
                    </li>
                    <li>
                        Abra o e-mail e clique em <strong>Modificar senha</strong>.
                    </li>
                    <li>
                        Você será redirecionado para uma página onde poderá inserir uma nova senha.
                    </li>
                    <li>
                        Repita a senha para confirmar e clique em <strong>Modificar senha</strong>.
                    </li>
                    <li>
                        Retorne à página de login e acesse o sistema com sua nova senha.
                    </li>
                </ol>
                <div class="mb-10 bg-amber-50 dark:bg-stone-800/80 border border-amber-700 dark:border-amber-400/60 rounded-lg p-4 text-amber-800 dark:text-amber-300">
                    <p class="font-semibold">
                        Atenção
                    </p>
                    <p class="text-sm text-gray-800 dark:text-gray-300">
                        O link de recuperação de senha expira em 1 hora. Se expirar, será necessário solicitar novamente.
                        Sua nova senha deve ter no mínimo 8 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.
                    </p>
                </div>

                {{-- Capítulo 3.2 --}}
                <h2 id="cap-3.2" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">3.2 Autenticação de Dois Fatores (2FA)</h2>
                <p class="mb-4">
                    A autenticação de dois fatores fornece segurança adicional à sua conta. Ao ativar, você precisará de um código além da sua senha para acessar o sistema.
                </p>

                <h3 id="cap-3.2-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Benefícios</h3>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li>Proteção contra roubo de senha</li>
                    <li>Acesso seguro mesmo se dados forem vazados</li>
                    <li>Rastreamento de atividades suspeitas</li>
                </ul>

                <h3 id="cap-3.2-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Como Funciona</h3>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li>Código gerado por aplicativo autenticador (ex: Microsoft Authenticator, Google Authenticator)</li>
                    <li>Código válido por cerca de 30 segundos, renovando a cada período</li>
                    <li>É necessário informar o código gerado pelo app a cada login após ativar o 2FA</li>
                    <li>O sistema fornece 8 códigos de recuperação que podem ser usados caso não tenha acesso ao app.
                        Guarde esses códigos em um local seguro e use somente em situações de emergência.
                        Cada código pode ser utilizado apenas uma vez.
                    </li>
                </ul>

                <h3 id="cap-3.2-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Configurando 2FA</h3>
                <ol class="list-decimal pl-6 space-y-1 mb-10">
                    <li><strong>Acesse Configurações de Segurança:</strong> Vá para seu Perfil → Autenticação de Dois Fatores</li>
                    <li><strong>Inicie o processo:</strong> Clique em "Habilitar"</li>
                    <li><strong>Confirme Seu Telefone/App:</strong> Insira sua chave de configuração ou escaneie o QR code</li>
                    <li><strong>Insira o Código de Verificação:</strong> Digite o código gerado e clique em "Confirmar"</li>
                    <li><strong>Guarde Códigos de Recuperação:</strong> Salve os códigos em local seguro para caso perca acesso ao seu telefone</li>
                </ol>

                {{-- Capítulo 3.3 --}}
                <h2 id="cap-3.3" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">3.3 Gerenciamento de Sessões e Dispositivos</h2>
                <p class="mb-4">
                    Monitore e controle os dispositivos e sessões ativas em sua conta, conhecendo o endereço IP, sistema operacional e navegador
                </p>
                <div class="space-y-3 mb-4 bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold">Ubuntu - Firefox</p>
                            <p class="text-sm">
                                192.168.1.105, <span class="text-green-800 dark:text-green-600 font-semibold">Essa sessão</span>
                            </p>
                        </div>
                    </div>
                    <hr class="border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold">AndroidOS - Chrome</p>
                            <p class="text-sm">192.168.42.129, Última atividade há 11 segundos </p>
                        </div>
                    </div>
                </div>

                <h3 id="cap-3.3-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Sessão inativa</h3>
                <p class="mb-4">
                    Por motivos de segurança, sessões inativas são encerradas automaticamente após
                    duas horas. Essa medida reduz o risco de acesso não autorizado,
                    especialmente em dispositivos compartilhados.
                    Recomenda-se revisar periodicamente as sessões ativas e manter apenas dispositivos reconhecidos,
                    contribuindo para a segurança contínua da conta.
                </p>
                <div class="mb-10 bg-red-50/60 dark:bg-red-900/10 border border-red-400/60 dark:border-red-500/50 rounded-lg p-4 text-red-800 dark:text-red-300">
                    <p class="font-semibold">
                        Atividade Suspeita?
                    </p>
                    <p class="text-sm text-gray-800 dark:text-gray-300">
                        Se vir um dispositivo ou navegador desconhecido, clique em "Sair de outras sessões do navegador" para encerrar outras sessões além da atual imediatamente.
                        Se você acha que sua conta foi comprometida, você também deve atualizar sua senha.
                    </p>
                </div>

                {{-- Capítulo 3.4 --}}
                <h2 id="cap-3.4" class="text-2xl font-semibold mb-2">3.4 Tentativas de Acesso</h2>
                <p class="mb-10">
                    Para proteger as contas contra tentativas de acesso indevidas, o sistema aplica
                    um limite de tentativas consecutivas de login. Caso esse limite de
                    <strong>5 tentativas por minuto</strong>
                    seja excedido, novas tentativas serão automaticamente bloqueadas.
                    Após o período de bloqueio, o acesso poderá ser tentado novamente.
                    Essa medida contribui para a prevenção de ataques de força bruta.
                </p>

                {{-- Capítulo 3.5 --}}
                <h2 id="cap-3.5" class="text-2xl font-semibold mb-2">3.5 Boas Práticas de Segurança</h2>
                <ul class="list-disc pl-6 space-y-1">
                    <li>Não compartilhe suas credenciais com terceiros</li>
                    <li>Utilize senhas fortes e exclusivas</li>
                    <li>Ative a autenticação de dois fatores sempre que possível</li>
                    <li>Finalize a sessão ao utilizar computadores públicos</li>
                    <li>Verifique regularmente os dispositivos conectados à sua conta</li>
                </ul>
            </div>
            <aside class="chapter-aside hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
                <h2 class="font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-4">
                    Neste capítulo
                </h2>
                <nav class="leading-relaxed text-gray-700 dark:text-gray-300 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
                    <a href="#cap-3.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
                        <span class="font-medium">3.1</span>
                        <span>Recuperação de Senha</span>
                    </a>

                    <a href="#cap-3.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
                        <span class="font-medium">3.2</span>
                        <span>Autenticação de Dois Fatores (2FA)</span>
                    </a>
                    <a href="#cap-3.2-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Benefícios</span>
                    </a>
                    <a href="#cap-3.2-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Como funciona</span>
                    </a>
                    <a href="#cap-3.2-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Configurando 2FA</span>
                    </a>

                    <a href="#cap-3.3" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
                        <span class="font-medium">3.3</span>
                        <span>Gerenciamento de Sessões e Dispositivos</span>
                    </a>
                    <a href="#cap-3.3-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Sessão inativa</span>
                    </a>

                    <a href="#cap-3.4" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
                        <span class="font-medium">3.4</span>
                        <span>Tentativas de acesso</span>
                    </a>

                    <a href="#cap-3.5"  class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
                        <span class="font-medium">3.5</span>
                        <span>Boas práticas de segurança</span>
                    </a>
                </nav>
            </aside>
        </article>

        {{-- Seção 4 --}}
        <article id="schedule" class="chapter flex bg-white shadow md:rounded-sm border border-white px-8 py-20 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0 text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-400 lg:scroll-mt-[4rem]">
            <div class="max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
                {{-- Capítulo 4 --}}
                <h1 class="text-3xl font-bold mb-14 text-gray-900 dark:text-gray-100">4. Agenda de Avaliações</h1>

                {{-- Capítulo 4.1 --}}
                <h2 id="cap-4.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">4.1 Visão Geral da Agenda</h2>
                <p class="mb-4">
                    A <strong>Agenda de Avaliações</strong> é a primeira tela exibida ao usuário após o login no sistema.
                    Ela centraliza o agendamento e a visualização das bancas avaliativas do evento SIMABJU.
                </p>

                <h3 id="cap-4.1.1" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Exibição</h3>
                <p class="mb-2">
                    A agenda é apresentada na forma de um calendário interativo, baseado em visualização temporal,
                    permitindo ao usuário acompanhar facilmente as bancas programadas durante o evento.
                    Por padrão, a agenda é exibida na visualização mensal, mas o usuário pode alternar entre
                    diferentes modos de exibição.
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
                    4.2 Interação com o Calendário
                </h2>

                <h3 id="cap-4.2.1" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Alternância de visualização</h3>
                <p class="mb-4">
                    No canto superior esquerdo do calendário, estão disponíveis botões que permitem ao usuário
                    alternar o modo de visualização da agenda <strong>(mensal, semanal, diária)</strong>,
                    conforme a necessidade de análise ou planejamento.
                </p>

                <h3 id="cap-4.2.2" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Navegação por datas</h3>
                <p class="mb-2">
                    No canto superior direito do calendário, estão disponíveis controles de navegação
                    que auxiliam na localização das datas desejadas.
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

                <h3 id="cap-4.2.3" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Seleção de datas e horários</h3>
                <p class="mb-2">
                    Ao clicar em uma <strong>célula do calendário</strong> (dia ou horário), o sistema
                    responde de acordo com o contexto.
                </p>
                <ul class="list-disc pl-6 space-y-1 mb-10">
                    <li>
                        Horários livres permitem iniciar um <strong>novo agendamento</strong>
                    </li>
                    <li>
                        Eventos já cadastrados exibem os <strong>detalhes da banca agendada</strong>
                    </li>
                </ul>

                {{-- Capítulo 4.3 --}}
                <h2 id="cap-4.3" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">4.3 Agendamento de Nova Banca</h2>
                <p class="mb-2">
                    A criação de novos agendamentos é uma funcionalidade <strong>exclusiva do coordenador</strong>.
                    Ao clicar em um horário disponível no calendário, é aberto um <strong>modal de agendamento</strong>, onde o coordenador deve
                </p>
                <ol class="list-decimal pl-6 space-y-1 mb-4">
                    <li>Selecionar a banca avaliativa (por meio de um seletor ou informando seu identificador)</li>
                    <li>Após a seleção, o sistema preenche automaticamente as seguintes informações
                        <ul class="list-disc pl-4 space-y-1">
                            <li>Identificador da banca</li>
                            <li>Nome da banca</li>
                            <li>Nome do grupo</li>
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

                {{-- Capítulo 4.4 --}}
                <h2 id="cap-4.4" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">4.4 Visualização de Bancas Agendadas</h2>
                <p class="mb-4">
                    Ao clicar em uma banca já agendada, o sistema abre um modal de visualização, exibindo as mesmas
                    informações do agendamento.
                </p>

                <h3 id="cap-4.4.1" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Modo visualização</h3>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li>Não é possível alterar os dados</li>
                    <li>O modal apresenta botões de ação de acordo com o perfil do usuário e o estado da banca</li>
                </ul>
                <p class="mb-10">
                    Usuários com perfil de aluno e professor possuem acesso apenas à visualização das informações da banca.
                </p>

                {{-- Capítulo 4.5 --}}
                <h2 id="cap-4.5" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">4.5 Edição e Cancelamento de Agendamentos</h2>
                <p class="mb-2">
                    O coordenador pode <strong>editar</strong> ou <strong>cancelar</strong> um agendamento existente,
                    desde que <strong>nenhuma avaliação tenha sido submetida</strong> para aquela banca. No modal de
                    visualização, o coordenador pode clicar em Editar, localizado no canto superior direito. Ao entrar
                    no modo de edição, é possível
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

                {{-- Capítulo 4.6 --}}
                <h2 id="cap-4.6" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">4.6 Controle de Acesso e Permissões</h2>
                <p class="mb-2">
                    O comportamento da agenda varia conforme o perfil do usuário
                </p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li><strong>Coordenador</strong>
                        <ul class="list-disc pl-4 space-y-1">
                            <li>Criar, editar e cancelar agendamentos</li>
                            <li>Visualizar todas as bancas</li>
                        </ul>
                    </li>
                    <li><strong>Professor</strong>
                        <ul class="list-disc pl-4 space-y-1">
                            <li>Visualizar apenas bancas das quais participa</li>
                        </ul>
                    </li>
                    <li><strong>Aluno</strong>
                        <ul class="list-disc pl-4 space-y-1">
                            <li>Visualizar apenas bancas relacionadas ao seu trabalho</li>
                        </ul>
                    </li>
                </ul>
                <div class="mb-10 bg-blue-50/60 dark:bg-blue-900/10 border border-blue-400/60 dark:border-blue-500/50 rounded-lg p-4 text-blue-800 dark:text-blue-300">
                    <p class="font-semibold">
                        Importante
                    </p>
                    <p class="text-sm text-gray-800 dark:text-gray-300">
                        Tentativas de acesso a bancas não autorizadas são automaticamente bloqueadas pelo sistema.
                    </p>
                </div>

                {{-- Capítulo 4.7 --}}
                <h2 id="cap-4.7" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">4.7 Considerações Importantes</h2>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li>A agenda é o ponto central de organização das avaliações do evento</li>
                    <li>Todas as ações são registradas e controladas conforme permissões</li>
                    <li>A edição de horários é restrita para evitar inconsistências após o início das avaliações</li>
                </ul>
                <p>
                    Os detalhes sobre o <strong>processo de avaliação</strong>, preenchimento de fichas e visualização
                    de notas são abordados em um capítulo específico deste manual.
                </p>
            </div>
            <aside class="chapter-aside hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
                <h2 class="font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-4">
                    Neste capítulo
                </h2>
                <nav class="leading-relaxed text-gray-700 dark:text-gray-300 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
                    <a href="#cap-4.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
                        <span class="font-medium">4.1</span>
                        <span>Visão Geral da Agenda</span>
                    </a>
                    <a href="#cap-4.1.1" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Exibição</span>
                    </a>

                    <a href="#cap-4.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
                        <span class="font-medium">4.2</span>
                        <span>Interação com o Calendário</span>
                    </a>
                    <a href="#cap-4.2.1" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Alternância de visualização</span>
                    </a>
                    <a href="#cap-4.2.2" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Navegação por datas</span>
                    </a>
                    <a href="#cap-4.2.3" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Seleção de datas e horários</span>
                    </a>

                    <a href="#cap-4.3" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
                        <span class="font-medium">4.3</span>
                        <span>Agendamento de Nova Banca</span>
                    </a>

                    <a href="#cap-4.4" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
                        <span class="font-medium">4.4</span>
                        <span>Visualização de Bancas Agendadas</span>
                    </a>
                    <a href="#cap-4.4.1" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
                        <span>Modo visualização</span>
                    </a>

                    <a href="#cap-4.5" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
                        <span class="font-medium">4.5</span>
                        <span>Edição e Cancelamento de Agendamentos</span>
                    </a>

                    <a href="#cap-4.6" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
                        <span class="font-medium">4.6</span>
                        <span>Controle de Acesso e Permissões</span>
                    </a>

                    <a href="#cap-4.7" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
                        <span class="font-medium">4.7</span>
                        <span>Considerações Importantes</span>
                    </a>
                </nav>
            </aside>
        </article>

        {{-- Seção 5 --}}
        <article id="users" class="chapter flex bg-white shadow md:rounded-sm border border-white px-8 py-20 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0 text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-400 lg:scroll-mt-[4rem]">
            <div class="max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
                {{-- Capítulo 5 --}}
                <h1 class="text-3xl mb-14 font-bold text-gray-900 dark:text-gray-100">5. Gerenciamento de Usuários</h1>

                {{-- Capítulo 5.1 --}}
                <h2 id="cap-5.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">5.1 Acesso à página</h2>
                <p class="mb-10">
                    A página de <strong>Gerenciamento de Usuários</strong> é acessada por meio do menu superior do sistema,
                    selecionando a opção <strong>Usuários</strong>. Logo abaixo do cabeçalho principal, é exibida uma
                    <strong>subnavegação</strong> que permite alternar entre os diferentes tipos de usuários do sistema.
                </p>

                {{-- Capítulo 5.2 --}}
                <h2 id="cap-5.2" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">5.2 Subnavegação entre tipos de usuários</h2>
                <p class="mb-2">
                    A subnavegação apresenta três abas
                </p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li><strong>Alunos</strong></li>
                    <li><strong>Professores</strong></li>
                    <li><strong>Coordenadores</strong></li>
                </ul>
                <p class="mb-10">
                    Por padrão, a aba <strong>Alunos</strong> é exibida inicialmente. A alternância entre abas atualiza
                    dinamicamente a tabela, os filtros e o formulário de cadastro, de acordo com o perfil selecionado.
                </p>

                {{-- Capítulo 5.3 --}}
                <h2 id="cap-5.3" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">5.3 Barra de ações e filtros</h2>
                <p class="mb-2">
                    Abaixo da subnavegação, encontra-se uma barra de ações organizada em layout flexível (<em>flex-wrap</em>),
                    que se adapta a diferentes resoluções de tela.
                </p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li><strong>Botão Cadastrar:</strong> abre um modal para criação de um novo usuário</li>
                    <li><strong>Campo de busca:</strong> permite pesquisa direta na tabela</li>
                    <li><strong>Filtros:</strong> refinam os resultados exibidos</li>
                    <li><strong>Limpar filtros:</strong> restaura a visualização padrão</li>
                </ul>
                <p class="mb-10">
                    Dependendo do tamanho da tela, os botões e filtros podem ser organizados em mais de uma linha,
                    mantendo a usabilidade da interface.
                </p>

                {{-- Capítulo 5.4 --}}
                <h2 id="cap-5.4" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">5.4 Gerenciamento de Alunos</h2>

                <h3 id="cap-5.4.1" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Cadastro</h3>
                <p class="mb-2">
                    Ao clicar em <strong>Cadastrar</strong>, é aberto um modal contendo os seguintes campos:
                </p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li><strong>RA:</strong> número obrigatório de 13 dígitos</li>
                    <li><strong>Nome</strong></li>
                    <li><strong>E-mail</strong></li>
                    <li><strong>Grupo</strong> (opcional)</li>
                    <li><strong>Curso</strong> (opcional)</li>
                </ul>
                <p class="mb-4">
                    Os campos de Grupo e Curso são apresentados como seletores, enquanto os demais utilizam campos de texto.
                    O salvamento é realizado pelo botão <strong>Salvar</strong>, localizado no canto inferior direito do modal,
                    com a opção <strong>Voltar</strong> ao lado para cancelamento.
                </p>

                <h3 id="cap-5.4.2" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Busca, filtros e listagem</h3>
                <p class="mb-2">
                    A tabela de alunos exibe até <strong>30 registros por página</strong>, contendo as colunas:
                </p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li>RA</li>
                    <li>Nome</li>
                    <li>E-mail</li>
                    <li>Grupo</li>
                    <li>Curso</li>
                    <li>Estado</li>
                    <li>Ações</li>
                </ul>
                <p class="mb-2">
                    O campo de busca permite localizar alunos por <strong>RA, nome ou e-mail</strong>. Os filtros disponíveis são:
                </p>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li>Curso</li>
                    <li>Grupo</li>
                    <li>Estado (ativo ou inativo)</li>
                    <li>Período de cadastro (hoje, últimos 7 dias, últimos 30 dias)</li>
                </ul>

                <h3 id="cap-5.4.3" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Edição, inativação e paginação</h3>
                <p class="mb-2">
                    A ação <strong>Alterar</strong> abre um modal com os dados do aluno para edição.
                    A ação <strong>Inativar</strong> exibe um modal de confirmação, no qual a operação
                    pode ser confirmada, cancelada pelo botão Voltar, clique externo ou tecla ESC.
                </p>
                <p class="mb-10">
                    A navegação entre páginas é feita por um sistema de paginação que permite avançar ou retroceder
                    por meio de setas laterais ou selecionar páginas numeradas, exibindo até cinco números por vez.
                </p>

                {{-- Capítulo 5.5 --}}
                <h2 id="cap-5.5" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">5.5 Gerenciamento de Professores e Coordenadores</h2>
                <p class="mb-4">
                    O gerenciamento de <strong>Professores</strong> e <strong>Coordenadores</strong> segue o mesmo padrão
                    de funcionamento da tela de alunos, com diferenças nos campos e filtros.
                </p>

                <h3 id="cap-5.5.1" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Campos de cadastro</h3>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li>Nome</li>
                    <li>E-mail</li>
                </ul>

                <h3 id="cap-5.5.2" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Filtros disponíveis</h3>
                <ul class="list-disc pl-6 space-y-1 mb-4">
                    <li>Estado (ativo ou inativo)</li>
                    <li>Período de cadastro</li>
                </ul>

                <div class="bg-blue-50/60 dark:bg-blue-900/10 border border-blue-400/60 dark:border-blue-500/50 rounded-lg p-4 text-blue-800 dark:text-blue-300">
                    <p class="font-semibold">
                        Permissões
                    </p>
                    <p class="text-sm leading-relaxed text-gray-800 dark:text-gray-300">
                        Coordenadores possuem acesso a funcionalidades administrativas adicionais, como gerenciamento
                        de cursos, grupos, bancas e rubricas.
                    </p>
                </div>
            </div>
            <aside class="chapter-aside hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
                <h2 class="font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-4">
                    Neste capítulo
                </h2>
                <nav class="leading-relaxed text-gray-800 dark:text-gray-300 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
                    <a href="#cap-5.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
                        <span class="font-medium">5.1</span>
                        <span>Acesso à página</span>
                    </a>

                    <a href="#cap-5.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
                        <span class="font-medium">5.2</span>
                        <span>Subnavegação entre tipos de usuários</span>
                    </a>

                    <a href="#cap-5.3" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
                        <span class="font-medium">5.3</span>
                        <span>Barra de ações e filtros</span>
                    </a>

                    <a href="#cap-5.4" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
                        <span class="font-medium">5.4</span>
                        <span>Gerenciamento de Alunos</span>
                    </a>
                    <a href="#cap-5.4.1" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
                        <span>Cadastro</span>
                    </a>
                    <a href="#cap-5.4.2" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
                        <span>Busca, filtros e listagem</span>
                    </a>
                    <a href="#cap-5.4.3" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-600 dark:text-gray-400">
                        <span>Edição, inativação e paginação</span>
                    </a>

                    <a href="#cap-5.5" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
                        <span class="font-medium">5.5</span>
                        <span>Gerenciamento de Professores e Coordenadores</span>
                    </a>
                    <a href="#cap-5.5.1" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
                        <span>Campos de cadastro</span>
                    </a>
                    <a href="#cap-5.5.2" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-600 dark:text-gray-400">
                        <span>Filtros disponíveis</span>
                    </a>
                </nav>
            </aside>
        </article>

        {{-- Seção 6 --}}
        <article id="institutional" class="chapter flex bg-white shadow md:rounded-sm border border-white px-8 py-20 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0 text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-400 lg:scroll-mt-[4rem]">
            <div class="max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
                <h1 class="text-3xl mb-8 font-bold">6. Configurações Institucionais</h1>

                <h1 class="text-xl font-bold mb-4">Gerenciamento de Cursos</h1>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    A tela <strong>"Cursos Cadastrados"</strong> centraliza todos os cursos oferecidos.
                </p>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    <strong>Tabela de Cursos contém:</strong>
                </p>
                <ul class="list-disc pl-6 space-y-2 mb-8 text-gray-800 dark:text-gray-300">
                    <li>
                        <strong>ID -</strong> Nome do curso
                    </li>
                    <li>
                        <strong>Nome -</strong> Manhã, Tarde ou Noite
                    </li>
                    <li>
                        <strong>Coordenador -</strong> Coordenador responsável
                    </li>
                    <li>
                        <strong>Estado -</strong> Ativo ou Inativo
                    </li>
                    <li>
                        <strong>Ações -</strong> ALTERAR / INATIVAR / ATIVAR
                    </li>
                </ul>

                <h1 class="text-xl font-bold mb-4">Gerenciamento de Grupos</h1>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    A tela <strong>"Cadastro de Grupos"</strong> exibe os grupos em formato de cartões.
                </p>
                <h2 class="font-semibold mb-2">Informações em cada cartão:</h2>
                <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800 dark:text-gray-300">
                    <li>Nome do grupo</li>
                    <li>Número de membros</li>
                    <li>Lista de integrantes</li>
                    <li>Status (Ativo/Inativo)</li>
                </ul>
                <h2 class="font-semibold mb-2">Ações por grupo:</h2>
                <ul class="list-disc pl-6 mb-8 space-y-2 text-gray-800 dark:text-gray-300">
                    <li>ALTERAR - Editar informações e membros</li>
                    <li>INATIVAR - Desativar o grupo</li>
                    <li>ATIVAR - Reativar grupos inativos</li>
                </ul>

                <h1 class="text-xl font-bold mb-4">
                    Gerenciamento de Bancas
                </h1>
                <p class="leading-relaxed mb-4 text-gray-800 dark:text-gray-300">
                    A tela <strong>"Bancas Cadastradas"</strong> gerencia todas as bancas de avaliação.
                </p>
                <h2 class="font-semibold mb-2">Informações em cada cartão:</h2>
                <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800 dark:text-gray-300">
                    <li>Nome da banca (Ex: "Banca 01", "Banca 02")</li>
                    <li>Criador - Quem criou a banca</li>
                    <li>Número de membros</li>
                    <li>Lista de integrantes com papéis (Coordenador ou Membro)</li>
                </ul>
                <h2 class="font-semibold mb-2">Ações por grupo:</h2>
                <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800 dark:text-gray-300">
                    <li>ALTERAR - Editar informações e membros</li>
                    <li>INATIVAR - Desativar o grupo</li>
                    <li>ATIVAR - Reativar grupos inativos</li>
                </ul>
            </div>
            <aside class="chapter-aside hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
                <h2 class="font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-4">
                    Neste capítulo
                </h2>
                <nav class="leading-relaxed space-y-2 text-gray-600 dark:text-gray-400">
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.1</span>
                        <span>Sobre o sistema</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Objetivos Principais</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.2</span>
                        <span>Público-Alvo</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.3</span>
                        <span>Sobre o SIMBAJU</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.4</span>
                        <span>Sobre este Manual do Usuário</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Finalidade do Manual</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Conteúdo Abordado</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Público e Objetivo de Uso</span>
                    </div>
                </nav>
            </aside>
        </article>

        {{-- Seção 7 --}}
        <article id="rubrics" class="chapter flex bg-white shadow md:rounded-sm border border-white px-8 py-20 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0 text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-400 lg:scroll-mt-[4rem]">
            <div class="max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
                <h1 class="text-3xl mb-8 font-bold">7. Critérios e Rubricas</h1>

                <h2 class="text-xl font-semibold mb-4">Conceitos Fundamentais</h2>
                <div class="space-y-1 mb-8 text-gray-800 dark:text-gray-300">
                    <p><strong>Critério:</strong> Um aspecto específico do desempenho que será avaliado (Ex: "Qualidade da documentação técnica")</p>
                    <p><strong>Eixo:</strong> Agrupamento de critérios relacionados (Ex: "Eixo 1: Documentação e Apresentação")</p>
                    <p><strong>Rubrica:</strong> Conjunto completo de eixos e critérios para avaliar grupos ou indivíduos</p>
                </div>


                <h2 class="text-xl font-semibold mb-4">Cadastro de Critérios</h2>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    A tela <strong>"Critérios Cadastrados"</strong> permite:
                </p>
                <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800 dark:text-gray-300">
                    <li>Visualizar todos os critérios do sistema</li>
                    <li>Criar novos critérios de avaliação</li>
                    <li>Editar critérios existentes</li>
                    <li>Associar critérios aos eixos</li>
                </ul>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    <strong>Exemplo de critério:</strong>
                </p>
                <ul class="list-disc pl-6 mb-8 space-y-2 text-gray-800 dark:text-gray-300">
                    <li>Nome: Qualidade da documentação técnica</li>
                    <li>Descrição: Avalia a clareza, completude e precisão</li>
                    <li>Tipo: Técnico</li>
                </ul>

                <h2 class="text-xl font-semibold mb-4">Cadastro de Eixos</h2>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    A tela <strong>"Eixos Cadastrados"</strong> organiza os critérios:
                </p>
                <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800 dark:text-gray-300">
                    <li>Criar novos eixos de avaliação</li>
                    <li>Agrupar critérios relacionados</li>
                    <li>Definir a ordem de apresentação</li>
                    <li>Gerenciar eixos ativos e inativos</li>
                </ul>
            </div>
            <aside class="chapter-aside hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
                <h2 class="font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-4">
                    Neste capítulo
                </h2>
                <nav class="leading-relaxed space-y-2 text-gray-600 dark:text-gray-400">
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.1</span>
                        <span>Sobre o sistema</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Objetivos Principais</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.2</span>
                        <span>Público-Alvo</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.3</span>
                        <span>Sobre o SIMBAJU</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.4</span>
                        <span>Sobre este Manual do Usuário</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Finalidade do Manual</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Conteúdo Abordado</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Público e Objetivo de Uso</span>
                    </div>
                </nav>
            </aside>
        </article>

        {{-- Seção 8 --}}
        <article id="evaluation" class="chapter flex bg-white shadow md:rounded-sm border border-white px-8 py-20 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0 text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-400 lg:scroll-mt-[4rem]">
            <div class="max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
                <h1 class="text-3xl mb-8 font-bold">8. Processo de avaliação</h1>

                <h2 class="text-xl font-semibold mb-2">Avaliação de Grupo</h2>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    <strong>Acessando a Rubrica de Grupo:</strong>
                </p>
                <ol class="list-decimal pl-6 space-y-1 mb-4 text-gray-800 dark:text-gray-300">
                    <li>Navegue até a seção de avaliações</li>
                    <li>Selecione o grupo a ser avaliado</li>
                    <li>Clique em "INICIAR AVALIAÇÃO"</li>
                </ol>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    <strong>Preenchendo a Rubrica:</strong>
                </p>
                <p class="leading-relaxed mb-4 text-gray-800 dark:text-gray-300">
                    A rubrica é organizada por Eixos, cada um contendo vários critérios.
                </p>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    <strong>Preenchendo a Rubrica:</strong>
                </p>
                <ol class="list-decimal pl-6 space-y-1 mb-8 text-gray-800 dark:text-gray-300">
                    <li>Para cada critério, selecione o nível de desempenho</li>
                    <li>Insatisfatório - Desempenho abaixo do esperado</li>
                    <li>Regular - Desempenho aceitável"</li>
                    <li>Bom - Desempenho acima da expectativa</li>
                    <li>Excelente - Desempenho excepcional</li>
                </ol>

                <h2 class="text-xl font-semibold mb-2">Avaliação individual</h2>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    <strong>Acessando a Rubrica Individual:</strong>
                </p>
                <p class="leading-relaxed mb-4 text-gray-800 dark:text-gray-300">
                    Após avaliar o grupo, você passará para a <strong>avaliação individual</strong> dos membros.
                </p>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    <strong>Procedimento:</strong>
                </p>
                <ol class="list-decimal pl-6 space-y-1 mb-4 text-gray-800 dark:text-gray-300">
                    <li>Localize cada aluno na tabela</li>
                    <li>Para cada critério, selecione o nível de desempenho</li>
                    <li>As seleções aparecem destacadas indicando notas individuais</li>
                    <li>Você pode adicionar comentários ou notas específicas</li>
                </ol>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    <strong>Preenchendo a Rubrica:Finalizando a Avaliação:</strong>
                </p>
                <ol class="list-decimal pl-6 space-y-1 mb-2 text-gray-800 dark:text-gray-300">
                    <li>Revise todas as notas e critérios</li>
                    <li>Clique em "SALVAR AVALIAÇÃO" para registrar tudo no sistema</li>
                    <li>Ou "FECHAR" para sair sem salvar</li>
                </ol>
                <div class="mt-6 bg-red-50 dark:bg-red-200 border border-red-200 dark:border-red-300 rounded-lg p-4 text-red-800">
                    <p class="font-semibold">
                        Importante
                    </p>
                    <p class="text-sm leading-relaxed">
                        Importante: Clique em "SALVAR AVALIAÇÃO" para que todas as informações sejam gravadas no sistema.
                        Sem isso, os dados serão perdidos.
                    </p>
                </div>
            </div>
            <aside class="chapter-aside hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
                <h2 class="font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-4">
                    Neste capítulo
                </h2>
                <nav class="leading-relaxed space-y-2 text-gray-600 dark:text-gray-400">
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.1</span>
                        <span>Sobre o sistema</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Objetivos Principais</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.2</span>
                        <span>Público-Alvo</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.3</span>
                        <span>Sobre o SIMBAJU</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.4</span>
                        <span>Sobre este Manual do Usuário</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Finalidade do Manual</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Conteúdo Abordado</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Público e Objetivo de Uso</span>
                    </div>
                </nav>
            </aside>
        </article>

        {{-- Seção 9 --}}
        <article id="profile" class="chapter flex bg-white shadow md:rounded-sm border border-white px-8 py-20 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0 text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-400 lg:scroll-mt-[4rem]">
            <div class="max-w-4xl w-full xl:pe-24">
                <h1 class="text-3xl mb-8 font-bold">9. Perfil</h1>
                <hr class="border-gray-200 dark:border-gray-700 mb-10">

                <h2 class="text-xl font-semibold mb-4">Dados do Perfil</h2>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    Acesse e edite suas informações pessoais.
                </p>
                <h2 class="font-semibold mb-2">Como Acessar:</h2>
                <ol class="list-decimal pl-6 mb-4 space-y-2 text-gray-800 dark:text-gray-300">
                    <li>Clique no ícone de <strong>Perfil</strong> (canto superior direito)</li>
                    <li>Selecione <strong>"Meu Perfil"</strong> ou <strong>"Editar Perfil"</strong></li>
                </ol>
                <h2 class="font-semibold mb-2">Informações editáveis:</h2>
                <ul class="list-disc pl-6 mb-8 space-y-2 text-gray-800 dark:text-gray-300">
                    <li>Nome completo</li>
                    <li>E-mail</li>
                    <li>Telefone</li>
                    <li>Foto de perfil</li>
                </ul>

                <h2 class="text-xl font-semibold mb-4">Foto de Perfil</h2>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    Personalize sua foto de perfil no sistema.
                </p>
                <ol class="list-decimal pl-6 mb-4 space-y-2 text-gray-800 dark:text-gray-300">
                    <li>Acesse Editar Perfil: Vá para seu Perfil → Editar Perfil</li>
                    <li>Clique na Foto Atual: Clique no avatar para trocar a imagem</li>
                    <li>Selecione Uma Imagem: Escolha uma foto do seu computador (JPG, PNG - máx. 5MB)</li>
                    <li>Corte e Confirme: Ajuste o corte da imagem conforme necessário e salve</li>
                </ol>
                <div class="mb-10 bg-blue-50/60 dark:bg-blue-900/10 border border-blue-400/60 dark:border-blue-500/50 rounded-lg p-4 text-blue-800 dark:text-blue-300">
                    <p class="font-semibold">
                        Requisitos da Foto
                    </p>
                    <p class="text-sm leading-relaxed text-gray-800 dark:text-gray-300">
                        Formatos aceitos: jpg, jpeg, png | Tamanho máximo: 1MB | Recomendado: 200x200px ou maior
                    </p>
                </div>

                <h2 class="text-xl font-semibold mb-4">Preferências Pessoais</h2>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    Customize suas preferências de experiência no SIRUS:
                </p>
                <div class="space-y-4">
                    <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-slate-900 dark:text-white">Notificações por E-mail</h4>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Receba alertas sobre atividades importantes</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-slate-900 dark:text-white">Resumos Semanais</h4>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Receba um resumo das atividades da semana</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-slate-900 dark:text-white">Lembretes de Avaliações</h4>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Aviso antecipado sobre avaliações agendadas</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden xl:block text-sm px-5 min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky top-[86px] self-start': stickyNav, '!hidden': !showChapterNav }">
                <h2 class="font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-4">
                    Neste capítulo
                </h2>
                <div class="leading-relaxed space-y-2 text-gray-600 dark:text-gray-400">
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.1</span>
                        <span>Sobre o sistema</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Objetivos Principais</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.2</span>
                        <span>Público-Alvo</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.3</span>
                        <span>Sobre o SIMBAJU</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.4</span>
                        <span>Sobre este Manual do Usuário</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Finalidade do Manual</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Conteúdo Abordado</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Público e Objetivo de Uso</span>
                    </div>
                </div>
            </div>
        </article>

        {{-- Seção 10 --}}
        <article id="accessibility" class="chapter flex bg-white shadow md:rounded-sm border border-white px-8 py-20 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0 text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-400 lg:scroll-mt-[4rem]">
            <div class="max-w-4xl w-full xl:pe-24">
                <h1 class="text-3xl mb-8 font-bold">10. Acessibilidade</h1>
                <hr class="border-gray-200 dark:border-gray-700 mb-10">

                <h1 class="text-xl font-bold mb-4">Modo Escuro</h1>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    Reduz o cansaço visual em ambientes com pouca luz e melhora a experiência de uso à noite.
                </p>
                <ol class="list-decimal pl-6 space-y-2 mb-4 text-gray-800 dark:text-gray-300">
                    <li>
                        <strong>Acesse Configurações:</strong> Vá para seu Perfil → Preferências
                    </li>
                    <li>
                        <strong>Procure por Tema:</strong> Vá para seu Perfil → Preferências
                    </li>
                    <li>
                        <strong>Escolha Uma Opção:</strong> Claro (padrão) | Escuro
                    </li>
                </ol>

                <h1 class="text-xl font-bold mb-4">Filtros para Daltonismo</h1>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    O SIRUS oferece filtros especiais para usuários com deficiência de visão de cores.
                    O daltonismo é uma condição visual que altera a forma como as cores são percebidas.
                    Ele afeta cerca de 8% dos homens e 0,5% das mulheres. Para tornar a navegação mais confortável,
                    oferecemos filtros de simulação que ajudam a ajustar a visualização conforme cada tipo de daltonismo.
                </p>
                <ul class="list-disc pl-6 space-y-2 mb-4 text-gray-800 dark:text-gray-300">
                    <li>
                        <strong>Acromatopsia:</strong> É a forma mais rara e severa de daltonismo. Pessoas com acromatopsia veem apenas em escala
                        de cinza, sendo insensíveis a todas as cores. Uma condição extremamente desafiadora.
                    </li>
                    <li>
                        <strong>Deuteranopia:</strong> Afeta a percepção da cor verde. Similar à protanopia, mas afeta principalmente
                        os receptores de cor verde, resultando em dificuldade similar com vermelho e verde.
                    </li>
                    <li>
                        <strong>Protanopia:</strong> Afeta principalmente a percepção da cor vermelha. Pessoas com protanopia têm dificuldade
                        em distinguir entre vermelho e verde, muitas vezes vendo-os em tons de amarelo e azul.
                    </li>
                    <li>
                        <strong>Tritanopia:</strong> É o tipo mais raro de daltonismo, afetando a percepção das cores azul e amarelo.
                        Pessoas afetadas dificilmente conseguem distinguir entre azul e amarelo, verde e rosa.
                    </li>
                </ul>
                <h2 class="font-semibold mb-2">Como ativar:</h2>
                <ol class="list-decimal pl-6 space-y-2 mb-4 text-gray-800 dark:text-gray-300">
                    <li>
                        Vá para Perfil → Acessibilidade
                    </li>
                    <li>
                        Abra "Filtros de Daltonismo"
                    </li>
                    <li>
                        Escolha o tipo que melhor se aplica
                    </li>
                    <li>
                        As cores serão ajustadas automaticamente
                    </li>
                </ol>

                <h1 class="text-xl font-bold mb-4">Assistente de Libras</h1>
                <p class="leading-relaxed mb-2 text-gray-800 dark:text-gray-300">
                    Libras (Língua Brasileira de Sinais) é a língua natural da comunidade surda.
                    Nosso sistema disponibiliza o VLibras, uma tecnologia desenvolvida pelo Ministério da Economia e pela UFPE,
                    que traduz textos, elementos da interface e partes do conteúdo multimídia para Libras por meio de um avatar animado.
                    Ele auxilia na compreensão de páginas, documentos e conteúdos digitais, ampliando significativamente a acessibilidade
                    para pessoas surdas.
                </p>
                <h2 class="font-semibold mb-2">Como ativar:</h2>
                <ol class="list-decimal pl-6 space-y-2 mb-4 text-gray-800 dark:text-gray-300">
                    <li>
                        <strong>Ativar Assistente:</strong> Clique no ícone no canto inferior direito
                    </li>
                    <li>
                        <strong>Selecionar Conteúdo:</strong> O assistente interpreta o conteúdo da página
                    </li>
                    <li>
                        <strong>Ativar Legendas:</strong> As legendas aparecem automaticamente
                    </li>
                    <li>
                        <strong>Ajustar Velocidade:</strong> Controle a velocidade conforme necessário
                    </li>
                </ol>
                <h2 class="font-semibold mb-2">Visibilidade:</h2>
                <p class="leading-relaxed mb-4 text-gray-800 dark:text-gray-300">
                    O ícone do assistente aparece em todas as páginas, no lado direito da tela, próximo ao ícone de daltonismo.
                    Você pode ocultá-lo a qualquer momento acessando Perfil → Acessibilidade.
                    Essa preferência é salva apenas no navegador atual. Se você ocultar o ícone e depois acessar o sistema em outro navegador, ele voltará a aparecer.
                </p>

                <h1 class="text-xl font-bold mb-4">Outros Recursos de Acessibilidade</h1>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <h3 class="font-semibold dark:text-white mb-2">Zoom de Texto</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Aumente ou diminua usando Ctrl + (+/-)</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <h3 class="font-semibold dark:text-white mb-2">Navegação por Teclado</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Use Tab e Enter para navegar</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <h3 class="font-semibold dark:text-white mb-2">Design Responsivo</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Interface adaptável a qualquer dispositivo</p>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <h3 class="font-semibold dark:text-white mb-2">Linguagem Clara</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Textos simples e diretos</p>
                    </div>
                </div>
            </div>
            <div class="hidden xl:block text-sm px-5 min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky top-[86px] self-start': stickyNav, '!hidden': !showChapterNav }">
                <h2 class="font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-4">
                    Neste capítulo
                </h2>
                <div class="leading-relaxed space-y-2 text-gray-600 dark:text-gray-400">
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.1</span>
                        <span>Sobre o sistema</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Objetivos Principais</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.2</span>
                        <span>Público-Alvo</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.3</span>
                        <span>Sobre o SIMBAJU</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.4</span>
                        <span>Sobre este Manual do Usuário</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Finalidade do Manual</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Conteúdo Abordado</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Público e Objetivo de Uso</span>
                    </div>
                </div>
            </div>
        </article>

        {{-- Seção 11 --}}
        <article id="support" class="chapter flex bg-white shadow md:rounded-sm border border-white px-8 py-20 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0 text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-400 lg:scroll-mt-[4rem]">
            <div class="max-w-4xl w-full xl:pe-24">
                <h1 class="text-3xl mb-8 font-bold">11. Suporte</h1>
                <hr class="border-gray-200 dark:border-gray-700 mb-10">

                <h1 class="text-xl font-bold mb-4">Perguntas Frequentes</h1>
                <div class="space-y-4 mb-4 text-gray-800 dark:text-gray-300">
                    <div class="border-l-4 border-blue-600 pl-4 py-2">
                        <h3 class="font-semibold mb-1">Esqueci minha senha. O que fazer?</h3>
                        <p>Contate o administrador do sistema para resetar sua senha. Você receberá um e-mail com instruções.</p>
                    </div>

                    <div class="border-l-4 border-blue-600 pl-4 py-2">
                        <h3 class="font-semibold mb-1">Não consigo fazer login</h3>
                        <p>Verifique se o e-mail e a senha estão corretos. Confira se está utilizando as credenciais fornecidas pelo administrador.</p>
                    </div>

                    <div class="border-l-4 border-blue-600 pl-4 py-2">
                        <h3 class="font-semibold mb-1">A página não carrega</h3>
                        <p>Atualize o navegador (F5) ou limpe o cache. Se o problema persistir, tente outro navegador.</p>
                    </div>

                    <div class="border-l-4 border-blue-600 pl-4 py-2">
                        <h3 class="font-semibold mb-1">Erro ao salvar avaliação</h3>
                        <p>Verifique sua conexão com a internet. Caso persista, anote o código do erro e contate o suporte.</p>
                    </div>

                    <div class="border-l-4 border-blue-600 pl-4 py-2">
                        <h3 class="font-semibold mb-1">Não vejo os alunos no meu grupo</h3>
                        <p>Confirme se o grupo foi criado e se os alunos foram atribuídos corretamente. Em caso de dúvidas, procure o administrador.</p>
                    </div>
                </div>

                {{-- Seção 2: Contato e Suporte
                <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
                    <h1 class="text-xl font-bold mb-4">Contato e Suporte</h1>
                    <p class="leading-relaxed mb-6 text-gray-800 dark:text-gray-300">
                        Para dúvidas ou problemas técnicos, entre em contato através dos canais abaixo:
                    </p>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="font-semibold text-blue-900 flex items-center gap-2 mb-2">
                                📧 E-mail
                            </h3>
                            <p class="text-blue-800">suporte@institucao.edu.br</p>
                        </div>

                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h3 class="font-semibold text-green-900 flex items-center gap-2 mb-2">
                                📞 Telefone
                            </h3>
                            <p class="text-green-800">(XX) XXXX-XXXX</p>
                        </div>

                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <h3 class="font-semibold text-purple-900 flex items-center gap-2 mb-2">
                                🏢 Presencialmente
                            </h3>
                            <p class="text-purple-800">Sala de TI - Bloco A, 2º andar</p>
                        </div>

                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                            <h3 class="font-semibold text-orange-900 flex items-center gap-2 mb-2">
                                ⏰ Horário de Atendimento
                            </h3>
                            <p class="text-orange-800">Segunda a Sexta, 8h às 18h</p>
                        </div>
                    </div>
                </article>--}}

                <h1 class="text-xl font-bold mb-4">Glossário de Termos</h1>
                <div class="space-y-4 text-gray-800 dark:text-gray-300">
                    <div class="border-l-4 border-gray-300 pl-4">
                        <strong>Banca</strong>
                        <p class="text-sm">Grupo de avaliadores responsável por avaliar grupos/alunos.</p>
                    </div>

                    <div class="border-l-4 border-gray-300 pl-4">
                        <strong>Rubrica</strong>
                        <p class="text-sm">Conjunto de critérios e eixos utilizados para avaliar desempenho.</p>
                    </div>

                    <div class="border-l-4 border-gray-300 pl-4">
                        <strong>Eixo</strong>
                        <p class="text-sm">Agrupamento temático de critérios relacionados.</p>
                    </div>

                    <div class="border-l-4 border-gray-300 pl-4">
                        <strong>Critério</strong>
                        <p class="text-sm">Aspecto específico do desempenho avaliado.</p>
                    </div>

                    <div class="border-l-4 border-gray-300 pl-4">
                        <strong>RA</strong>
                        <p class="text-sm">Registro Acadêmico – identificação única do aluno.</p>
                    </div>

                    <div class="border-l-4 border-gray-300 pl-4">
                        <strong>Estado</strong>
                        <p class="text-sm">Situação do usuário no sistema (Ativo/Inativo).</p>
                    </div>

                    <div class="border-l-4 border-gray-300 pl-4">
                        <strong>Modal</strong>
                        <p class="text-sm">Janela sobreposta utilizada para exibir formulários ou ações rápidas.</p>
                    </div>
                </div>
            </div>
            <div class="hidden xl:block text-sm px-5 min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky top-[86px] self-start': stickyNav, '!hidden': !showChapterNav }">
                <h2 class="font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-4">
                    Neste capítulo
                </h2>
                <div class="leading-relaxed space-y-2 text-gray-600 dark:text-gray-400">
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.1</span>
                        <span>Sobre o sistema</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Objetivos Principais</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.2</span>
                        <span>Público-Alvo</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.3</span>
                        <span>Sobre o SIMBAJU</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.4</span>
                        <span>Sobre este Manual do Usuário</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Finalidade do Manual</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Conteúdo Abordado</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Público e Objetivo de Uso</span>
                    </div>
                </div>
            </div>
        </article>
    </div>
    {{-- Atribui scroll margin a todos os títulos, e estilização de navegação interna --}}
    <style>
        article.chapter h2,
        article.chapter h3,
        article.chapter h4 {
            scroll-margin-top: 4.5rem;
        }

        .chapter-aside h2,
        .chapter-aside nav a {
            padding: 0 1.25rem; /* 20px */
            border-left: transparent solid 2px;
        }
        .chapter-aside nav a:hover {
            border-left: #6b7280 solid 2px;
        }
        .chapter-aside nav a.active {
            padding: 0 1.25rem; /* 20px */
            border-left: #4169E1 solid 2px;
        }
    </style>
    {{-- Padroniza estruturas do menu aside dos capitulos --}}
    <style>
        .hidden-chapter-aside {
            display: none !important;
        }
        .sticky-chapter-aside {
            position: sticky;
            top: 86px;
            align-self: start;
        }
    </style>
    {{-- Controla paginação interna dos capítulos --}}
    <script>
        window.addEventListener("load", () => {
            const sections = [...document.querySelectorAll('[id^="cap-"]')];
            const links = document.querySelectorAll('.sub-chapter-link');

            let lockScroll = false;

            function highlight(id) {
                links.forEach(link => {
                    link.classList.toggle(
                        'active',
                        link.getAttribute('href') === `#${id}`
                    );
                });
            }

            const observer = new IntersectionObserver(
                (entries) => {
                    if (lockScroll) return;

                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            highlight(entry.target.id);
                        }
                    });
                },
                {
                    root: null,
                    // cria uma "linha" a 150px do topo
                    rootMargin: '-25% 0px -75% 0px',
                    threshold: 0
                }
            );

            sections.forEach(section => observer.observe(section));

            links.forEach(link => {
                link.addEventListener('click', () => {
                    const id = link.getAttribute('href').replace('#', '');

                    lockScroll = true;
                    highlight(id);

                    setTimeout(() => {
                        lockScroll = false;
                    }, 120);
                });
            });
        });
    </script>
</div>
