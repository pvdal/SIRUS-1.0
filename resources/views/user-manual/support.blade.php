<x-documentation-layout>
    <x-slot name="options">
        <x-manual-pages/>
    </x-slot>
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-3xl font-bold">11. Suporte</h1>
    </article>

    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-xl font-bold mb-4">Perguntas Frequentes</h1>

        <div class="space-y-4 text-gray-800">
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
    </article>

    {{-- Seção 2: Contato e Suporte
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-xl font-bold mb-4">Contato e Suporte</h1>
        <p class="leading-relaxed mb-6 text-gray-800">
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

    {{-- Seção 3: Glossário de Termos --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-xl font-bold mb-4">Glossário de Termos</h1>

        <div class="space-y-4 text-gray-800">
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
    </article>
</x-documentation-layout>
