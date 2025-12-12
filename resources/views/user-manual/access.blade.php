<x-documentation-layout>
    <x-slot name="options">
        <x-manual-pages/>
    </x-slot>
    {{-- Seção 1 --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-3xl font-bold">2. Acesso ao Sistema</h1>
    </article>

    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h2 class="text-xl font-semibold mb-4">Tela de Boas-vindas</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            Ao acessar o SIRUS pela primeira vez, você verá a tela inicial que apresenta:
        </p>
        <ul class="list-disc pl-6 space-y-1 text-gray-800">
            <li>Menu de navegação, que permite navegar dentro da própria página, acessar o <strong>manual de usuário</strong>, <strong>termos</strong> e <strong>políticas</strong> do sistema, ou <strong>fazer login</strong></li>
            <li>Nome do sistema: <strong>SIRUS - Sistema de Rubricas para Gestão Avaliativa do SIMBAJU</strong></li>
            <li>Descrição da plataforma</li>
            <li>Botões: <strong>Fazer Login</strong> e <strong>Manual do Usuário</strong></li>
            <li>Descrição das principais funcionalidades que o sistema oferece</li>
            <li>Breve descrição sobre o <strong>SIMBAJU</strong></li>
        </ul>
        <p class="leading-relaxed mt-2 text-gray-800">
            Clique em "<strong>Fazer Login</strong>" para acessar a autenticação do sistema.
        </p>
    </article>

    {{-- Seção Público-Alvo --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h2 class="text-xl font-semibold mb-4">Autenticação de Usuário</h2>

        <p class="leading-relaxed mb-2 text-gray-800">
            Na tela de login, você deverá:
        </p>
        <ol class="list-decimal pl-6 space-y-1 text-gray-800">
            <li>Inserir seu <strong>E-mail</strong> - Seu endereço de e-mail cadastrado no sistema</li>
            <li>Inserir sua <strong>Senha</strong> - Sua senha de acesso</li>
            <li>Clicar em <strong>"Entrar"</strong> - Para validar suas credenciais</li>
        </ol>

        <p class="leading-relaxed mt-2 text-gray-800">
            O usuário pode escolher manter sua senha oculta enquanto digita ou visualizá-la <br>
            Ao clicar em <strong>"Manter conectado"</strong>, não será mais necessário fazer login naquele navegador até uma limpeza de cache.
        </p>
        <div class="mt-6 bg-amber-50 border border-amber-200 rounded-lg p-4 text-amber-800">
            <p class="font-semibold">
                Dica de segurança
            </p>
            <p class="text-sm leading-relaxed">
                Nunca compartilhe sua senha com outras pessoas. Se esqueceu sua senha, contate o administrador do sistema.
            </p>
        </div>
    </article>

    <!-- Primeiro Acesso – Validação de E-mail -->
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h2 class="text-xl font-semibold mb-4">Primeiro Acesso – Validação de E-mail</h2>

        <p class="leading-relaxed mb-2 text-gray-800">
            No primeiro acesso ao SIRUS, será necessário validar seu e-mail. Siga os passos:
        </p>

        <ol class="list-decimal pl-6 space-y-1 text-gray-800">
            <li>Receber sua <strong>senha temporária</strong> enviada pelo sistema após cadastro <do></do> coordenador</li>
            <li>Fazer login usando a senha temporária</li>
            <li>Solicitar o envio do <strong>e-mail de validação</strong></li>
            <li>Acessar o link enviado para confirmar seu endereço de e-mail</li>
            <li>Aceitar os <strong>termos de uso</strong> e <strong>políticas do sistema</strong></li>
            <li>Acessar o SIRUS com acesso completo</li>
        </ol>

        <p class="leading-relaxed mt-3 text-gray-800">
            O link de validação expira em 24 horas. Caso expire, é possível solicitar um novo na página de login.
        </p>
    </article>
</x-documentation-layout>
