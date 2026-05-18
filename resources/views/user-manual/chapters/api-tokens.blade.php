<div class="min-w-0 max-w-4xl w-full xl:pe-24 manual-content" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 12 --}}
    <h1>12. Tokens de API</h1>

    {{-- Capítulo 12.1 --}}
    <section>
        <h2 id="cap-12.1">12.1 O que são Tokens</h2>

        <p>
            Tokens de API são como <strong>chaves de acesso pessoais</strong>. Em vez de usar sua senha principal em outros
            aplicativos, você cria uma chave específica (o token) que permite que sistemas externos "conversem" com os dados
            da sua conta de forma segura.
        </p>
    </section>

    {{-- Capítulo 12.2 --}}
    <section>
        <h2 id="cap-12.2">12.2 Como gerar um Token</h2>

        <p>
            O processo é feito diretamente na interface do sistema:
        </p>
        <ol>
            <li>Acesse o menu de perfil (canto superior direito)</li>
            <li>Selecione a opção <strong>"API Tokens"</strong></li>
            <li>Defina um nome (ex: <strong>Conexão Power BI</strong>)</li>
            <li>Escolha as permissões (abilities)</li>
            <li>Clique em <strong>"Criar"</strong></li>
        </ol>
        <div class="manual-alert manual-alert-danger">
            <p class="manual-alert-title">
                Atenção
            </p>
            <p class="manual-alert-message">
                O token será exibido <strong class="font-semibold">apenas uma vez</strong>. Copie e armazene em local seguro,
                pois ele não poderá ser visualizado novamente.
            </p>
        </div>
    </section>

    {{-- Capítulo 12.3 --}}
    <section>
        <h2 id="cap-12.3">12.3 Como usar (Headers)</h2>

        <p>
            Para que o sistema aceite a conexão do Power BI ou de outra ferramenta, você deve enviar o token através de um
            <strong>"cabeçalho"</strong> (header) na requisição HTTP.
        </p>
        <div class="my-4 bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
            <code>Authorization: Bearer SEU_TOKEN_AQUI</code>
        </div>
        <p>
            Esse padrão é compatível com ferramentas como Postman, Power BI e integrações personalizadas.
        </p>
    </section>

    {{-- Capítulo 12.4 --}}
    <section>
        <h2 id="cap-12.4">12.4 Rotas protegidas</h2>

        <p>
            As rotas protegidas são endereços (URLs) que exigem um token válido para entregar qualquer dado.
            Se você tentar acessar esses endereços sem o token, o sistema bloqueará o acesso por segurança.
        </p>
        <h3 id="cap-12.4-a">Exemplos de rotas</h3>
        <ul class="list-disc pl-6 space-y-2 mb-10">
            <li><code class="bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-md">GET /api/user</code> Validar usuário autenticado</li>
            <li><code class="bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-md">GET /api/events/show</code> Listar eventos</li>
            <li><code class="bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded-md">GET /api/students/show</code> Listar estudantes</li>
        </ul>
    </section>

    {{-- Capítulo 12.5 --}}
    <section>
        <h2 id="cap-12.5">12.5 Permissões (Abilities)</h2>

        <p>
            Cada token pode ter <strong>"habilidades"</strong> específicas. Isso significa que você pode criar um token que
            só permite ler dados (visualizar), sem risco de o aplicativo externo alterar ou apagar qualquer informação no sistema.
            O sistema verifica automaticamente se o seu token tem a permissão necessária antes de liberar a resposta.
        </p>
    </section>

    {{-- Capítulo 12.6 --}}
    <section>
        <h2 id="cap-12.6">12.6 Revogação de Token</h2>

        <p>
            Se você não precisar mais de uma integração ou se o seu token for exposto acidentalmente, você pode cancelá-lo
            (revogá-lo) imediatamente.
        </p>
        <ol>
            <li>Vá novamente até a tela de <strong>"API Tokens"</strong> no seu perfil</li>
            <li>Localize o token desejado</li>
            <li>Clique no botão de <strong>Deletar</strong>. Uma vez excluído, o token para de funcionar instantaneamente
                em qualquer lugar onde esteja configurado
            </li>
        </ol>
        <div class="manual-alert manual-alert-danger">
            <p class="manual-alert-title">Atenção</p>
            <p class="manual-alert-message">
                Após a revogação, o token deixa de funcionar imediatamente e qualquer integração será interrompida.
            </p>
        </div>
    </section>

    {{-- Capítulo 12.7 --}}
    <section>
        <h2 id="cap-12.7">12.7 Exemplos de Uso</h2>

        <h3 id="cap-12.7-a">cURL</h3>
        <p>
            Útil para testar a conexão rapidamente.
        </p>
        <div class="mb-4 bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
            <code class="break-words">
                curl -X GET https://192.168.1.153/api/user \<br>
                &nbsp;&nbsp;-H "Authorization: Bearer SEU_TOKEN" \<br>
                &nbsp;&nbsp;-H "Accept: application/json"
            </code>
        </div>

        <h3 id="cap-12.7-b">Postman</h3>
        <ol>
            <li>Abra o Postman e crie uma nova requisição GET</li>
            <li>Cole a URL da rota protegida (ex: <code class="break-words">https://192.168.1.153/api/user</code>)</li>
            <li>Na aba <strong>"Authorization"</strong>, escolha o tipo <strong>"Bearer Token"</strong></li>
            <li>Cole o seu token gerado no campo <strong>"Token"</strong></li>
            <li>Clique em <strong>"Enviar"</strong> para visualizar os dados</li>
        </ol>

        <h3 id="cap-12.7-c">Power BI</h3>
        <p>
            Permite consumir a API diretamente e visualizar os dados em dashboards.
        </p>
        <ol>
            <li>Abra o Power BI Desktop</li>
            <li>Clique em <strong>"Obter Dados"</strong> → <strong>"Web"</strong></li>
            <li>Selecione a opção <strong>"Avançado"</strong></li>
            <li>Insira a URL da API:
                <code class="break-words">https://192.168.1.153/api/user</code>
            </li>
            <li>Adicione o cabeçalho HTTP:</li>
        </ol>
        <div class="mb-4 bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
            <code>
                Authorization: Bearer SEU_TOKEN
            </code>
        </div>
        <ol start="6">
            <li>Clique em <strong>"OK"</strong></li>
            <li>Os dados serão carregados no Power Query</li>
            <li>Faça os tratamentos necessários e clique em <strong>"Fechar e Aplicar"</strong></li>
            <li>Use os dados para criar relatórios e dashboards</li>
        </ol>
    </section>
</div>
<aside class="chapter-aside flex-1 hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-bold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-500 dark:text-gray-400 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-12.1" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
            12.1 O que são Tokens
        </a>

        <a href="#cap-12.2" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
            12.2 Como gerar um Token
        </a>

        <a href="#cap-12.3" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
            12.3 Como usar (Headers)
        </a>

        <a href="#cap-12.4" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            12.4 Rotas protegidas
        </a>
        <a href="#cap-12.4-a" class="sub-chapter-link block mb-3 !pl-10">
            Exemplos de rotas
        </a>

        <a href="#cap-12.5" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
            12.5 Permissões (Abilities)
        </a>

        <a href="#cap-12.6" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
            12.6 Revogação de Token
        </a>

        <a href="#cap-12.7" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            12.7 Exemplos de uso
        </a>
        <a href="#cap-12.7-a" class="sub-chapter-link block mb-1 !pl-10 ">
            cURL
        </a>
        <a href="#cap-12.7-b" class="sub-chapter-link block mb-1 !pl-10">
            Postman
        </a>
        <a href="#cap-12.7-c" class="sub-chapter-link block mb-3 !pl-10">
            Power BI
        </a>
    </nav>
</aside>
