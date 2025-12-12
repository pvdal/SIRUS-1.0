<x-guest-layout>
    <nav x-data="{ open:false }" id="navigation" class="flex flex-col justify-center items-center w-full fixed shadow bg-white z-50">
        <div class="flex items-center w-full max-w-[2100px] h-14 lg:h-16 px-5 md:px-3">
            <x-application-logo
                size="40"
                class="flex-shrink-0 transform transition-all"
            />
            <div class="hidden md:flex items-center w-full max-w-[2100px]">
                <ul class="mx-4 lg:ms-10 inline-flex items-center overflow-x-auto no-scrollbar gap-6 h-full">
                    <li>
                        <a href="#features" class="text-sm lg:text-base font-medium text-gray-700 hover:text-secondary-blue whitespace-nowrap">Funcionalidades</a>
                    </li>
                    <li>
                        <a href="#about" class="text-sm lg:text-base font-medium text-gray-700 hover:text-secondary-blue whitespace-nowrap">Sobre o evento</a>
                    </li>
                    <li>
                        <a href="#" class="text-sm lg:text-base font-medium text-gray-700 hover:text-secondary-blue whitespace-nowrap">Manual</a>
                    </li>
                    <li>
                        <a href="{{ route('terms.show') }}" class="text-sm lg:text-base font-medium text-gray-700 hover:text-secondary-blue whitespace-nowrap">Termos</a>
                    </li>
                    <li>
                        <a href="{{ route('policy.show') }}" class="text-sm lg:text-base font-medium text-gray-700 hover:text-secondary-blue whitespace-nowrap">Privacidade</a>
                    </li>
                </ul>
                <div class="hidden ms-auto sm:flex">
                    <a class="text-white inline-flex items-center gap-3 px-4 py-2
                        bg-secondary-blue border border-transparent rounded-lg font-semibold text-xs lg:text-sm
                         uppercase tracking-widest hover:opacity-90 shadow-[0_2px_5px_rgba(0,0,0,0.28)]
                        focus:opacity-90 active:strong-blue focus:outline-none focus:ring-2 whitespace-nowrap
                        focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50
                        transition ease-in-out duration-150"
                       href="@auth /calendar @else /login @endauth">
                        <span class="inline-flex items-center gap-2">
                            @auth
                                <x-lucide-book-text class="flex-shrink-0 h-4 w-4 transition-all"/>
                                Agenda SIMBAJU
                            @else
                                <x-lucide-log-in class="flex-shrink-0 h-4 w-4 transition-all"/>
                                Fazer Login
                            @endauth
                        </span>
                    </a>
                </div>
            </div>
            <div class="-me-2 flex items-center ms-auto md:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md
                    text-gray-400 hover:text-gray-500 hover:bg-gray-100
                    focus:outline-none focus:bg-gray-100 focus:text-gray-500
                    dark:text-gray-300 dark:hover:text-gray-200 dark:hover:bg-gray-700
                    dark:focus:bg-gray-700 dark:focus:text-gray-200
                    transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="w-full p-5 pt-2 hidden md:hidden" :class="{ 'hidden':!open, 'flex flex-col':open }">
            <ul class="flex flex-col items-start justify-start gap-4 pb-5 no-scrollbar">
                <li>
                    <a href="#features" class="text-sm lg:text-base font-medium text-gray-700 hover:text-secondary-blue whitespace-nowrap">Funcionalidades</a>
                </li>
                <li>
                    <a href="#about" class="text-sm lg:text-base font-medium text-gray-700 hover:text-secondary-blue whitespace-nowrap">Sobre o evento</a>
                </li>
                <li>
                    <a href="#" class="text-sm lg:text-base font-medium text-gray-700 hover:text-secondary-blue whitespace-nowrap">Manual</a>
                </li>
                <li>
                    <a href="{{ route('terms.show') }}" class="text-sm lg:text-base font-medium text-gray-700 hover:text-secondary-blue whitespace-nowrap">Termos</a>
                </li>
                <li>
                    <a href="{{ route('policy.show') }}" class="text-sm lg:text-base font-medium text-gray-700 hover:text-secondary-blue whitespace-nowrap">Privacidade</a>
                </li>
            </ul>
            <a class="text-white inline-flex items-center gap-3 px-4 py-2 justify-center
                bg-secondary-blue border border-transparent rounded-lg font-semibold text-xs lg:text-sm
                 uppercase tracking-widest hover:opacity-90 shadow-[0_2px_5px_rgba(0,0,0,0.28)]
                focus:opacity-90 active:strong-blue focus:outline-none focus:ring-2 whitespace-nowrap
                focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50
                transition ease-in-out duration-150"
               href="@auth /calendar @else /login @endauth">
                <span class="inline-flex items-center gap-2">
                    @auth
                        <x-lucide-book-text class="flex-shrink-0 h-4 w-4 transition-all"/>
                        Agenda SIMBAJU
                    @else
                        <x-lucide-log-in class="flex-shrink-0 h-4 w-4 transition-all"/>
                        Fazer Login
                    @endauth
                </span>
            </a>
        </div>
    </nav>
    <div class="flex flex-col min-h-screen">
        <main class="flex flex-1 flex-col w-full bg-gradient-to-br from-gray-50 to-gray-100 text-gray-900">
            {{-- Container principal --}}
            <div class="flex flex-1 flex-col min-h-full max-w-[1536px] mx-auto px-6 pt-16 m-2 gap-10 lg:flex-row">
                {{-- Menu lateral --}}
                <aside class="w-full lg:w-1/4">
                    <div class="bg-white h-full shadow rounded-xl border border-gray-200 px-4 py-6 ">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4">Manual de Usuário</h2>
                        <nav class="space-y-1">

                            <a href="#" class="flex items-center justify-between px-3 py-2 rounded-lg bg-blue-50 text-blue-600 font-medium border border-blue-200">
                                <span>1. Introdução</span>
                                <span class="text-blue-500">›</span>
                            </a>

                            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                                2. Acesso ao Sistema
                            </a>

                            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                                3. Tela Inicial - Agenda de Avaliações
                            </a>

                            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                                4. Gerenciamento de Usuários
                            </a>

                            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                                5. Configurações Institucionais
                            </a>

                            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                                6. Critérios e Rubricas
                            </a>

                            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                                7. Processo de Avaliação
                            </a>

                            <a href="#" class="block px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700">
                                8. Contato e Suporte
                            </a>
                        </nav>
                    </div>
                </aside>

                {{-- Conteúdo principal --}}
                <div class="w-full lg:w-3/4 space-y-8">
                    {{-- Seção 1 --}}
                    <article class="bg-white shadow rounded-xl border border-gray-200 p-8">
                        <h1 class="text-3xl font-bold">1. Introdução</h1>
                    </article>

                    <article class="bg-white shadow rounded-xl border border-gray-200 p-8">
                        <h2 class="text-xl font-semibold mb-2">Sobre o Sistema</h2>
                        <p class="leading-relaxed mb-6">
                            O <strong>SIRUS</strong> é uma plataforma intuitiva para gerenciar, aplicar e analisar
                            avaliações acadêmicas com eficiência e padronização. O sistema foi desenvolvido para
                            facilitar o processo de avaliação de alunos, organizando cronogramas, cadastros e
                            critérios de desempenho.
                        </p>

                        <h3 class="font-semibold mb-2">Objetivos Principais:</h3>
                        <ul class="list-disc pl-6 space-y-1 text-gray-700">
                            <li>Centralizar o gerenciamento de avaliações acadêmicas</li>
                            <li>Padronizar critérios e rubricas de avaliação</li>
                            <li>Facilitar o agendamento de bancas avaliativas</li>
                            <li>Organizar dados de alunos, professores e coordenadores</li>
                            <li>Gerar análises e relatórios de desempenho</li>
                        </ul>
                    </article>

                    {{-- Seção Público-Alvo --}}
                    <article class="bg-white shadow rounded-xl border border-gray-200 p-8">
                        <h2 class="text-xl font-semibold mb-4">Público-Alvo</h2>

                        <p class="leading-relaxed mb-6">
                            O sistema foi projetado para os seguintes usuários:
                        </p>

                        <ul class="list-disc pl-6 space-y-2 text-gray-700">
                            <li><strong>Coordenadores acadêmicos:</strong> Gerenciam cursos, grupos e bancas</li>
                            <li><strong>Professores e avaliadores:</strong> Realizam avaliações de alunos</li>
                            <li><strong>Alunos e grupos:</strong> Participam de avaliações e acompanham resultados</li>
                            <li><strong>Administradores:</strong> Gerenciam toda a plataforma</li>
                        </ul>
                    </article>
                </div>
            </div>
        </main>
        {{-- Rodapé --}}
        <footer class="bg-white text-white py-6 border-t border-gray-200">
            <div class="max-w-[2200px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <!-- Logo + Nome -->
                    <div class="flex flex-col items-center">
                        <!-- Copyright -->
                        <p class=" text-sm lg:text-base text-gray-500 text-center">
                            &copy; 2025. Todos os direitos reservados.
                        </p>
                    </div>

                    <!-- Links -->
                    <div class="flex flex-col sm:flex-row items-center gap-1 sm:gap-4">
                        <a target="_blank" href="{{ route('policy.show') }}" class="text-gray-500 hover:text-gray-600 text-sm 2xl:text-base">Política de Privacidade</a>
                        <a target="_blank"  href="{{ route('terms.show') }}" class="text-gray-500 hover:text-gray-600 text-sm 2xl:text-base">Termos de Uso</a>
                        {{-- <a href="#" class="text-gray-400 hover:text-white text-sm">Suporte</a> --}}
                    </div>
                </div>
            </div>
        </footer>
    </div>
</x-guest-layout>
