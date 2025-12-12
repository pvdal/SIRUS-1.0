<x-documentation-layout>
    <x-slot name="options">
        <x-manual-pages/>
    </x-slot>
    {{-- Seção 1 --}}
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-3xl font-bold">9. Perfil</h1>
    </article>

    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h2 class="text-xl font-semibold mb-4">Dados do Perfil</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            Acesse e edite suas informações pessoais.
        </p>

        <h2 class="font-semibold mb-2">Como Acessar:</h2>
        <ol class="list-decimal pl-6 mb-4 space-y-2 text-gray-800">
            <li>Clique no ícone de <strong>Perfil</strong> (canto superior direito)</li>
            <li>Selecione <strong>"Meu Perfil"</strong> ou <strong>"Editar Perfil"</strong></li>
        </ol>

        <h2 class="font-semibold mb-2">Informações editáveis:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Nome completo</li>
            <li>E-mail</li>
            <li>Telefone</li>
            <li>Foto de perfil</li>
        </ul>
    </article>

    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h2 class="text-xl font-semibold mb-4">Foto de Perfil</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            Personalize sua foto de perfil no sistema.
        </p>

        <ol class="list-decimal pl-6 mb-4 space-y-2 text-gray-800">
            <li>Acesse Editar Perfil: Vá para seu Perfil → Editar Perfil</li>
            <li>Clique na Foto Atual: Clique no avatar para trocar a imagem</li>
            <li>Selecione Uma Imagem: Escolha uma foto do seu computador (JPG, PNG - máx. 5MB)</li>
            <li>Corte e Confirme: Ajuste o corte da imagem conforme necessário e salve</li>
        </ol>

        <div class="mt-6 bg-amber-50 border border-amber-200 rounded-lg p-4 text-amber-800">
            <p class="font-semibold">
                Requisitos da Foto
            </p>
            <p class="text-sm leading-relaxed">
                Formatos aceitos: jpg, jpeg, png | Tamanho máximo: 1MB | Recomendado: 200x200px ou maior
            </p>
        </div>
    </article>

    <!-- Section 3: Preferences -->
    <article class="bg-white dark:bg-slate-900 rounded-lg p-6 shadow-sm border border-slate-200 dark:border-slate-800">
        <h2 class="text-xl font-semibold mb-4">Preferências Pessoais</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
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
    </article>
</x-documentation-layout>
