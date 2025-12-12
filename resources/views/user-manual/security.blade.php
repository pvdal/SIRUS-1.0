<x-documentation-layout>
    <x-slot name="options">
        <x-manual-pages/>
    </x-slot>
    {{-- Seção 1 --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-3xl font-bold">3. Segurança</h1>
    </article>
    {{-- Seção 1: Recuperação de Senha --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-xl font-bold mb-4">Recuperação de Senha</h1>
        <p class="leading-relaxed mb-2 text-gray-800">
            Se você esqueceu sua senha, siga este processo para recuperá-la:
        </p>

        <ol class="list-decimal pl-6 space-y-2 text-gray-800">
            <li>
                <strong>Acesse a Página de Login:</strong> Clique em <strong>"Esqueci minha senha"</strong> na tela de login.
            </li>
            <li>
                <strong>Insira seu E-mail:</strong> Digite o e-mail cadastrado no sistema.
            </li>
            <li>
                <strong>Receba o E-mail de Recuperação:</strong> Verifique sua caixa de entrada (e pasta de spam) por um e-mail de recuperação.
            </li>
            <li>
                <strong>Clique no Link:</strong> Abra o e-mail e clique no link de recuperação de senha.
            </li>
            <li>
                <strong>Defina Uma Nova Senha:</strong> Será redirecionado para uma página onde poderá inserir uma nova senha.
            </li>
            <li>
                <strong>Confirme a Nova Senha:</strong> Repita a senha para confirmar e clique em <strong>"Redefinir Senha"</strong>.
            </li>
            <li>
                <strong>Faça Login com Nova Senha:</strong> Retorne à página de login e acesse o sistema com sua nova senha.
            </li>
        </ol>

        <div class="mt-6 bg-amber-50 border border-amber-200 rounded-lg p-4 text-amber-800">
            <p class="font-semibold">
                Atenção
            </p>
            <p class="text-sm leading-relaxed">
                O link de recuperação de senha expira em 1 hora. Se expirar, será necessário solicitar novamente.
                Sua nova senha deve ter no mínimo 8 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.
            </p>
        </div>
    </article>

    {{-- Seção 2: Autenticação de Dois Fatores --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-xl font-bold mb-4">Autenticação de Dois Fatores (2FA)</h1>
        <p class="leading-relaxed mb-2 text-gray-800">
            A autenticação de dois fatores fornece segurança adicional à sua conta. Ao ativar, você precisará de um código além da sua senha para acessar o sistema.
        </p>

        <h2 class="font-semibold mb-2">Benefícios:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Proteção contra roubo de senha</li>
            <li>Acesso seguro mesmo se dados forem vazados</li>
            <li>Rastreamento de atividades suspeitas</li>
        </ul>

        <h2 class="font-semibold mb-2">Como Funciona:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Código gerado por aplicativo autenticador (ex: Microsoft Authenticator, Google Authenticator)</li>
            <li>Código válido por cerca de 30 segundos, renovando a cada período</li>
            <li>É necessário informar o código gerado pelo app a cada login após ativar o 2FA</li>
            <li>O sistema fornece 8 códigos de recuperação que podem ser usados caso não tenha acesso ao app <br>
                Guarde esses códigos em um local seguro e use somente em situações de emergência. <br>
                Cada código pode ser utilizado apenas uma vez.
                </li>
        </ul>

        <h2 class="font-semibold mb-2">Configurando 2FA:</h2>
        <ol class="list-decimal pl-6 space-y-2 text-gray-800">
            <li><strong>Acesse Configurações de Segurança:</strong> Vá para seu Perfil → Autenticação de Dois Fatores</li>
            <li><strong>Inicie o processo:</strong> Clique em "Habilitar"</li>
            <li><strong>Confirme Seu Telefone/App:</strong> Insira sua chave de configuração ou escaneie o QR code</li>
            <li><strong>Insira o Código de Verificação:</strong> Digite o código gerado e clique em "Confirmar"</li>
            <li><strong>Guarde Códigos de Recuperação:</strong> Salve os códigos em local seguro para caso perca acesso ao seu telefone</li>
        </ol>

    </article>

    {{-- Seção 3: Gerenciamento de Sessões e Dispositivos --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-xl font-bold mb-4">
            Gerenciamento de Sessões e Dispositivos
        </h1>
        <p class="leading-relaxed mb-4 text-gray-800">
            Monitore e controle os dispositivos e sessões ativas em sua conta, conhecendo o endereço IP, sistema operacional e navegador:
        </p>

        <div class="space-y-3 bg-gray-50 p-4 rounded-lg text-gray-800">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-semibold">Ubuntu - Firefox</p>
                    <p class="text-sm">
                        192.168.1.105, <span class="text-green-800 font-semibold">Essa sessão</span>
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

        <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4 text-red-800">
            <p class="font-semibold">
                Atividade Suspeita?
            </p>
            <p class="text-sm leading-relaxed">
                Se vir um dispositivo ou localização desconhecida, clique em "Sair de outras sessões do navegador" para encerrar outras sessões além da atual imediatamente.
                Se você acha que sua conta foi comprometida, você também deve atualizar sua senha.
            </p>
        </div>
    </article>

</x-documentation-layout>
