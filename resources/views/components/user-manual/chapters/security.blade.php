<div class="max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 3 --}}
    <h1 class="text-3xl font-bold mb-14 text-gray-900 dark:text-gray-100">3. Segurança</h1>

    {{-- Capítulo 3.1 --}}
    <h2 id="cap-3.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">3.1 Recuperação de Senha</h2>
    <p class="mb-2">
        Caso tenha esquecido sua senha, siga o procedimento abaixo para recuperá-la:
    </p>
    <ol class="list-decimal pl-6 space-y-1 mb-4">
        <li>
            Acesse a Página de Login e clique em <strong>"Esqueceu sua senha?"</strong>
        </li>
        <li>
            Digite o e-mail cadastrado no sistema no local indicado e clique em <strong>"Enviar link para redefinir senha por e-mail"</strong>
        </li>
        <li>
            Verifique sua caixa de entrada (e pasta de spam), buscando por o e-mail de recuperação enviado pelo sistema
        </li>
        <li>
            Abra o e-mail e clique em <strong>"Modificar senha"</strong>
        </li>
        <li>
            Você será redirecionado para uma página onde poderá inserir uma nova senha
        </li>
        <li>
            Repita a senha para confirmar e clique em <strong>"Modificar senha"</strong>
        </li>
        <li>
            Retorne à página de login e acesse o sistema com sua nova senha
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
    <h2 id="cap-3.2" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">3.2 Autenticação em Dois Fatores (2FA)</h2>
    <p class="mb-4">
        A autenticação em dois fatores fornece segurança adicional à sua conta. Ao ativar, você precisará de um código além da sua senha para acessar o sistema.
    </p>

    <h3 id="cap-3.2-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Como Funciona</h3>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>Código gerado por aplicativo autenticador (ex: Microsoft Authenticator, Google Authenticator)</li>
        <li>Código válido por cerca de 30 segundos, renovando a cada período</li>
        <li>É necessário informar o código gerado pelo app a cada login após ativar o 2FA</li>
        <li>O sistema fornece 8 códigos de recuperação que podem ser usados caso não tenha acesso ao app.
            Guarde esses códigos em um local seguro e use somente em situações de emergência.
            Cada código pode ser utilizado apenas uma vez.
        </li>
    </ul>

    <h3 id="cap-3.2-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Configurando 2FA</h3>
    <ol class="list-decimal pl-6 space-y-1 mb-10">
        <li>
            Na página de perfil — acessível pelo menu superior, conforme exposto no <strong>capítulo 2.5</strong>
            deste manual —, localize a seção <strong>"Autenticação em dois fatores"</strong>
        </li>
        <li>Clique em <strong>"Habilitar"</strong></li>
        <li>Insira sua chave de configuração ou escaneie o QR code</li>
        <li>Digite o código gerado e clique em <strong>"Confirmar"</strong></li>
        <li>Salve os códigos em local seguro para caso perca acesso ao seu telefone</li>
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
    <p class="mb-2">
        Por motivos de segurança, sessões inativas são encerradas automaticamente após duas horas. Essa medida reduz
        o risco de acesso não autorizado, especialmente em dispositivos compartilhados. Recomenda-se revisar periodicamente
        as sessões ativas e manter apenas dispositivos reconhecidos, contribuindo para a segurança contínua da conta.
    </p>
    <p class="mb-4">
        <strong>OBS.:</strong> Ao selecionar a opção <strong>"Manter conectado"</strong>, sua sessão não será submetida
        a limite de tempo de inatividade, permanecendo ativa no navegador até que você decida encerrá-la, por meio de
        funcionalidade específica do sistema, conforme disposto no <strong>capítulo 9.1</strong> desde manual.
    </p>
    <div class="mb-10 bg-red-50/60 dark:bg-red-900/10 border border-red-400/60 dark:border-red-500/50 rounded-lg p-4 text-red-800 dark:text-red-300">
        <p class="font-semibold">
            Atividade Suspeita?
        </p>
        <p class="text-sm text-gray-800 dark:text-gray-300">
            Se vir um dispositivo ou navegador desconhecido, clique em <strong>"Sair de outras sessões do navegador"</strong>
            para encerrar outras sessões além da atual imediatamente. Se você acha que sua conta foi comprometida, você
            também deve atualizar sua senha.
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
        <li>Utilize senhas fortes e exclusivas, contendo caracteres alfanuméricos e especiais</li>
        <li>Ative a autenticação em dois fatores sempre que possível</li>
        <li>Finalize a sessão ao utilizar computadores públicos</li>
        <li>Verifique regularmente os dispositivos conectados à sua conta</li>
    </ul>
</div>
<aside class="chapter-aside hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-semibold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-700 dark:text-gray-300 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-3.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
            <span class="font-medium">3.1</span>
            <span>Recuperação de Senha</span>
        </a>

        <a href="#cap-3.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-medium">3.2</span>
            <span>Autenticação em Dois Fatores (2FA)</span>
        </a>
        <a href="#cap-3.2-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Como funciona</span>
        </a>
        <a href="#cap-3.2-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
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

        <a href="#cap-3.5"  class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
            <span class="font-medium">3.5</span>
            <span>Boas práticas de segurança</span>
        </a>
    </nav>
</aside>
