<div class="max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 11 --}}
    <h1 class="text-3xl font-bold mb-14 text-gray-900 dark:text-gray-100">11. Tokens de API</h1>

    {{-- Capítulo 11.1 --}}
    <h2 id="cap-11.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">11.1 O que são Tokens</h2>
    <p class="mb-10">
        Tokens de API são como <strong>chaves de acesso pessoais</strong>. Em vez de usar sua senha principal em outros
        aplicativos, você cria uma chave específica (o token) que permite que sistemas externos "conversem" com os dados
        da sua conta de forma segura.
    </p>

    {{-- Capítulo 11.2 --}}
    <h2 id="cap-11.2" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">
        11.2 Como gerar um Token
    </h2>
    <p class="mb-2">
        O processo é feito diretamente na interface do sistema:
    </p>
    <ol class="list-decimal pl-6 space-y-1 mb-4">
        <li>Acesse o menu de perfil (canto superior direito)</li>
        <li>Selecione a opção <strong>"API Tokens"</strong></li>
        <li>Defina um nome (ex: <strong>Conexão Power BI</strong>)</li>
        <li>Escolha as permissões (abilities)</li>
        <li>Clique em <strong>"Criar"</strong></li>
    </ol>
    <div class="mb-10 bg-amber-50 dark:bg-stone-800/80 border border-amber-700 dark:border-amber-400/60 rounded-lg p-4 text-amber-800 dark:text-amber-300">
        <p class="font-semibold">Importante</p>
        <p class="text-sm text-gray-800 dark:text-gray-300">
            O token será exibido <strong>apenas uma vez</strong>. Copie e armazene em local seguro,
            pois ele não poderá ser visualizado novamente.
        </p>
    </div>

    {{-- Capítulo 11.3 --}}
    <h2 id="cap-11.3" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">11.3 Como usar (Headers)</h2>
    <p class="mb-2">
        Para que o sistema aceite a conexão do Power BI ou de outra ferramenta, você deve enviar o token através de um
        <strong>"cabeçalho"</strong> (header) na requisição HTTP.
    </p>
    <div class="mb-6 bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
        <code>Authorization: Bearer SEU_TOKEN_AQUI</code>
    </div>
    <p class="mb-10">
        Esse padrão é compatível com ferramentas como Postman, Power BI e integrações personalizadas.
    </p>

    {{-- Capítulo 11.4 --}}
    <h2 id="cap-11.4" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">11.4 Rotas protegidas</h2>
    <p class="mb-2">
        As rotas protegidas são endereços (URLs) que exigem um token válido para entregar qualquer dado.
        Se você tentar acessar esses endereços sem o token, o sistema bloqueará o acesso por segurança.
    </p>
    <h3 id="cap-11.4-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Exemplos de rotas</h3>
    <ul class="list-disc pl-6 space-y-1 mb-10">
        <li><code class="bg-gray-50 dark:bg-gray-800 px-2 py-1 rounded-md">GET /api/user</code> Validar usuário autenticado</li>
        <li><code class="bg-gray-50 dark:bg-gray-800 px-2 py-1 rounded-md">GET /api/events/show</code> Listar eventos</li>
        <li><code class="bg-gray-50 dark:bg-gray-800 px-2 py-1 rounded-md">GET /api/students/show</code> Listar estudantes</li>
    </ul>

    {{-- Capítulo 11.5 --}}
    <h2 id="cap-11.5" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">11.5 Permissões (Abilities)</h2>
    <p class="mb-10">
        Cada token pode ter <strong>"habilidades"</strong> específicas. Isso significa que você pode criar um token que
        só permite ler dados (visualizar), sem risco de o aplicativo externo alterar ou apagar qualquer informação no sistema.
        O sistema verifica automaticamente se o seu token tem a permissão necessária antes de liberar a resposta.
    </p>

    {{-- Capítulo 11.6 --}}
    <h2 id="cap-11.6" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">11.6 Revogação de Token</h2>
    <p class="mb-2">
        Se você não precisar mais de uma integração ou se o seu token for exposto acidentalmente, você pode cancelá-lo
        (revogá-lo) imediatamente.
    </p>
    <ol class="list-decimal pl-6 space-y-1 mb-10">
        <li>Vá novamente até a tela de <strong>"API Tokens"</strong> no seu perfil</li>
        <li>Localize o token desejado</li>
        <li>Clique no botão de <strong>Deletar</strong>. Uma vez excluído, o token para de funcionar instantaneamente
            em qualquer lugar onde esteja configurado
        </li>
    </ol>
    <div class="mb-10 bg-red-50/60 dark:bg-red-900/10 border border-red-400/60 dark:border-red-500/50 rounded-lg p-4 text-red-800 dark:text-red-300">
        <p class="font-semibold">Atenção</p>
        <p class="text-sm text-gray-800 dark:text-gray-300">
            Após a revogação, o token deixa de funcionar imediatamente e qualquer integração será interrompida.
        </p>
    </div>

    {{-- Capítulo 11.7 --}}
    <h2 id="cap-11.7" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">11.7 Exemplos de Uso</h2>

    <h3 id="cap-11.7-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Exemplo via cURL</h3>
    <p class="mb-2">
        Útil para testar a conexão rapidamente.
    </p>
    <div class="mb-6 bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
        <code>
            curl -X GET https://192.168.1.153/api/user \<br>
            &nbsp;&nbsp;-H "Authorization: Bearer SEU_TOKEN" \<br>
            &nbsp;&nbsp;-H "Accept: application/json"
        </code>
    </div>

    <h3 id="cap-11.7-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Exemplo no Postman</h3>
    <ol class="list-decimal pl-6 space-y-1 mb-10">
        <li>Abra o Postman e crie uma nova requisição GET</li>
        <li>Cole a URL da rota protegida (ex: https://192.168.1.153/api/user)</li>
        <li>Na aba <strong>"Authorization"</strong>, escolha o tipo <strong>"Bearer Token"</strong></li>
        <li>Cole o seu token gerado no campo <strong>"Token"</strong></li>
        <li>Clique em <strong>"Enviar"</strong> para visualizar os dados</li>
    </ol>
</div>
<aside class="chapter-aside hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-semibold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-700 dark:text-gray-300 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-11.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
            <span class="font-medium">11.1</span>
            <span>O que são Tokens</span>
        </a>

        <a href="#cap-11.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
            <span class="font-medium">11.2</span>
            <span>Como gerar um Token</span>
        </a>

        <a href="#cap-11.3" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
            <span class="font-medium">11.3</span>
            <span>Como usar (Headers)</span>
        </a>

        <a href="#cap-11.4" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-medium">11.4</span>
            <span>Rotas protegidas</span>
        </a>
        <a href="#cap-11.4-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Exemplos de rotas</span>
        </a>

        <a href="#cap-11.5" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
            <span class="font-medium">11.5</span>
            <span>Permissões (Abilities)</span>
        </a>

        <a href="#cap-11.6" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
            <span class="font-medium">11.6</span>
            <span>Revogação de Token</span>
        </a>

        <a href="#cap-11.7" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-medium">11.7</span>
            <span>Exemplos de uso</span>
        </a>
        <a href="#cap-11.7-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Exemplo via cURL</span>
        </a>
        <a href="#cap-11.7-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Exemplo no Postman</span>
        </a>
    </nav>
</aside>
