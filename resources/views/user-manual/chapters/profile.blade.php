<div class="min-w-0 max-w-4xl w-full xl:pe-24 manual-content" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 10 --}}
    <h1>10. Perfil</h1>

    {{-- Capítulo 10.1 --}}
    <section>
        <h2 id="cap-10.1">10.1 Acesso ao perfil e Logout</h2>

        <h3 id="cap-10.1-a">Como acessar</h3>
        <p>
            A área de perfil permite ao usuário gerenciar informações pessoais, segurança da conta
            e preferências de acessibilidade:
        </p>
        <ol>
            <li>Clique na foto de perfil localizada no canto superior direito da tela, no menu superior</li>
            <li>No menu suspenso, selecione a opção <strong>"Perfil"</strong></li>
        </ol>

        <h3 id="cap-10.1-b">Encerrar sessão</h3>
        <p>
            Para sair do sistema, clique na foto de perfil no menu superior e selecione a opção
            <strong>"Sair"</strong>. Essa ação encerra a sessão atual e redireciona o usuário para a
            página inicial.
        </p>
    </section>

    {{-- Capítulo 10.2 --}}
    <section>
        <h2 id="cap-10.2">10.2 Seções do perfil</h2>

        <h3 id="cap-10.2-a">Informações do perfil</h3>
        <p>
            Nesta seção, o usuário pode atualizar seus dados básicos de identificação no sistema. Os campos disponíveis
            para edição são:
        </p>
        <ul>
            <li>Nome</li>
            <li>E-mail</li>
            <li>Foto de perfil</li>
            <li>Curso vinculado (coordenadores e alunos)</li>
        </ul>
        @if(auth()->user()->access_level === 2 || auth()->user()->access_level === 3)
            <p>
                Coordenadores e professores possuem, em seu perfil, a seção <strong>"Formação"</strong>, onde podem cadastrar
                seus principais cursos de graduação, especialização, mestrado ou doutorado. Após atualizar essas informações,
                o usuário deverá aguardar ao menos duas horas antes de realizar uma nova atualização.
            </p>
        @endif
        <div class="manual-alert manual-alert-danger">
            <p class="manual-alert-title">
                Atenção
            </p>
            <p class="manual-alert-message">
                <strong class="font-semibold">Ao alterar o e-mail cadastrado, certifique-se de que o novo endereço seja válido e esteja ativo.</strong>
                A conta precisará passar por uma nova validação e, caso o e-mail informado não exista, o acesso poderá ser bloqueado até a regularização junto ao suporte.
            </p>
        </div>

        <h3 id="cap-10.2-b">Foto de perfil</h3>
        <p>
            A foto de perfil é exibida no menu superior do sistema e pode ser alterada a qualquer momento.
            Caso já exista uma imagem cadastrada, também é possível removê-la:
        </p>
        <ol>
            <li>Clique em <strong>"Selecionar uma nova imagem"</strong> para escolher um arquivo do computador</li>
            <li>Para remover a imagem atual, utilize o botão <strong>"Remover imagem"</strong></li>
            <li>Após realizar as alterações desejadas, clique em <strong>"Salvar"</strong></li>
        </ol>
        <div class="manual-alert manual-alert-info">
            <p class="manual-alert-title">
                Requisitos da imagem
            </p>
            <p class="manual-alert-message">
                Formatos aceitos: <code>JPG</code>, <code>JPEG</code> ou <code>PNG</code><br>
                Tamanho máximo: <code>256KB</code>
            </p>
        </div>

        <h3 id="cap-10.2-c">Alteração de senha</h3>
        <p>
            O usuário pode alterar sua senha informando a senha atual e definindo uma nova senha de acesso.
        </p>

        <h3 id="cap-10.2-d">Critérios da senha</h3>
        <p>
            A senha deve conter pelo menos <strong>oito caracteres</strong>, incluindo
            <strong>uma letra maiúscula</strong>, <strong>uma letra minúscula</strong>,
            <strong>um número</strong> e <strong>um caractere especial</strong>.
        </p>

        <h3 id="cap-10.2-e">Autenticação em Dois Fatores (2FA)</h3>
        <p>
            Nesta seção é possível habilitar a autenticação em dois fatores, adicionando uma camada extra
            de segurança à conta. O funcionamento detalhado dessa funcionalidade é descrito no
            <strong>capítulo 3.2</strong> deste manual.
        </p>

        <h3 id="cap-10.2-f">Sessões do navegador</h3>
        <p>
            A área de sessões permite visualizar dispositivos conectados e encerrar sessões ativas em
            outros navegadores ou dispositivos. O comportamento dessa funcionalidade está descrito no
            <strong>capítulo 3.3</strong> deste manual.
        </p>

        <h3 id="cap-10.2-g">Acessibilidade</h3>
        <p>
            O sistema disponibiliza recursos de acessibilidade, como filtros de daltonismo e integração
            com o VLibras, visando melhorar a experiência de uso para diferentes perfis de usuários.
            O funcionamento detalhado desses recursos é apresentado no <strong>capítulo 11</strong> deste manual.
        </p>
    </section>
</div>
<aside class="chapter-aside flex-1 hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-bold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-500 dark:text-gray-400 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-10.1" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            10.1 Acesso ao perfil e Logout
        </a>
        <a href="#cap-10.1-a" class="sub-chapter-link block mb-1 !pl-10">
            Como acessar
        </a>
        <a href="#cap-10.1-b" class="sub-chapter-link block mb-3 !pl-10">
            Encerrar sessão
        </a>

        <a href="#cap-10.2" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            10.2 Seções do perfil
        </a>
        <a href="#cap-10.2-a" class="sub-chapter-link block mb-1 !pl-10">
            Informações do perfil
        </a>
        <a href="#cap-10.2-b" class="sub-chapter-link block mb-1 !pl-10">
            Foto de perfil
        </a>
        <a href="#cap-10.2-c" class="sub-chapter-link block mb-1 !pl-10">
            Alteração de senha
        </a>
        <a href="#cap-10.2-d" class="sub-chapter-link block mb-1 !pl-10">
            Critérios da senha
        </a>
        <a href="#cap-10.2-e" class="sub-chapter-link block mb-1 !pl-10">
            Autenticação em Dois Fatores (2FA)
        </a>
        <a href="#cap-10.2-f" class="sub-chapter-link block mb-1 !pl-10">
            Sessões do navegador
        </a>
        <a href="#cap-10.2-g" class="sub-chapter-link block mb-3 !pl-10">
            Acessibilidade
        </a>
    </nav>
</aside>
