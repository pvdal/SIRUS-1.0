<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{config('app.name') . ($title ?? '' ? ' | ' .$title : '')}}</title>
        <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}?v=1">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="relative">
        @if(config('accessibility.daltonism'))
            <x-accessibility.daltonism-filters/>
        @endif
        {{--<header class="bg-white shadow fixed z-10 w-full">
            <nav x-data="{ open: false }" class=" border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <x-application-mark size="40" />
                            </div>
                        </div>
                        <!-- Botão de login -->
                        <div class="py-4 hidden sm:-my-px sm:ms-10 md:flex">
                            <a class="text-white flex items-center justify-center px-4 py-2 bg-primary-blue border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90 focus:opacity-90 active:strong-blue focus:outline-none focus:ring-2 focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150" href="@auth /calendar @else /login @endauth">
                                @auth
                                    Agenda do SIMBAJU
                                @else
                                    Fazer Login
                                @endauth
                            </a>
                        </div>
                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center md:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
                    <!-- Botão de login -->
                    <div class="pt-2 pb-3 space-y-1">
                        <a class="text-white btn btn-primary-custom btn-lg inline-flex items-center justify-center px-4 py-2 bg-primary-blue border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest hover:opacity-90 focus:opacity-90 active:strong-blue focus:outline-none focus:ring-2 focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150" href="@auth /calendar @else /login @endauth">
                            @auth
                                Agenda do SIMBAJU
                            @else
                                Fazer Login
                            @endauth
                        </a>
                    </div>
                </div>
            </nav>
        </header>--}}
        <main id="app">
            {{-- Login Section --}}
            <section
                class="relative bg-cover bg-center min-h-screen flex items-center px-5 py-5 lg:px-20 border-b-2 border-strong-blue shadow-inner drop-shadow-2xl bg-gradient-to-tr from-strong-blue/80 to-primary-blue/80 overflow-hidden"
            >
                <!-- Ícones flutuantes -->
                <x-lucide-graduation-cap class="absolute top-10 left-10 text-white opacity-30 w-16 h-16" />
                <x-lucide-book class="absolute bottom-10 left-1/3 text-white opacity-20 w-20 h-20 " />
                <x-lucide-pencil class="absolute top-1/3 right-10 text-white opacity-25 w-14 h-14 animate-spin-slow" />
                <x-lucide-users class="absolute bottom-10 right-1/4 text-white opacity-20 w-24 h-24 animate-float" />

                <div class="shadow-2xl drop-shadow-2xl mx-auto border-4 border-gray-700 rounded-xl overflow-hidden bg-white max-w-[1480px] relative z-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 items-center">
                        <!-- Logo e título -->
                        <div class="text-center lg:text-left h-full">
                            <div class="flex flex-col items-center justify-center text-center py-20 px-10 h-full bg-primary-blue rounded-e-lg">
                                <x-authentication-card-logo class="w-[227px] h-[120px] xlg:w-[265px] lg:h-[140px]"/>
                                <h1 class="text-white mt-3 mb-0 text-[3.5rem] lg:text-[4rem] xlg::text-[4.5rem] font-bold leading-tight">
                                    SIRUS
                                </h1>
                                <p class="text-white text-lg opacity-80 mb-0 upper">
                                    Sistema de Rubricas para Gestão Avaliativa do SIMBAJU
                                </p>
                            </div>
                        </div>

                        <!-- Texto de boas-vindas -->
                        <div class="flex flex-col justify-between gap-5 h-full px-10 py-10 md:py-24">
                            <div class="text-center lg:text-left">
                                <h2 class="text-[2.5rem] lg:text-[3rem] font-semibold mb-4 uppercase text-gray-800">
                                    Bem-vindo ao SIRUS
                                </h2>
                                <p class="text-lg opacity-80 mb-4 lg:text-xl">
                                    Uma plataforma intuitiva para gerenciar, aplicar e analisar avaliações acadêmicas com eficiência e padronização.
                                </p>
                            </div>
                            <div class="w-full max-h-[100px] mb-0 text-center lg:text-left">
                                <a class="text-white inline-flex items-center gap-3 px-5 p-5  py-2
                                    bg-primary-blue border border-transparent rounded-lg font-semibold text-[15px]
                                    md:text-[20px] lg:text-[25px] uppercase tracking-widest hover:opacity-90
                                    focus:opacity-90 active:strong-blue focus:outline-none focus:ring-2
                                    focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50 transition
                                    ease-in-out duration-150"
                                    href="@auth /calendar @else /login @endauth">

                                    <x-lucide-log-in class="text-white h-6 w-6 md:h-8 lg:w-8 lg:h-10"/>
                                    <span>
                                        @auth
                                            Agenda SIMBAJU
                                        @else
                                            Fazer Login
                                        @endauth
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section
                class="relative bg-cover bg-center min-h-screen flex items-start px-5 py-16 bg-gray-100 shadow-inner drop-shadow-2xl"
                style="background-image: url('{{ asset('/img/FATEC_Franco.jpg') }}')"
            >
                <!-- overlay escuro -->
                <div class="absolute inset-0 bg-black/20"></div>

                <div class="relative z-10 mx-auto px-4">
                    <!-- Grid de cards -->
                    <div class=" mx-auto px-4 pb-10">

                        <!-- Título da seção -->
                        <div class="text-center mb-12">
                            <h2 class="text-3xl md:text-4xl 2xl:text-5xl font-semibold text-gray-900 mb-3 uppercase">
                                Recursos Principais
                            </h2>
                            <span class="block w-20 h-1 bg-secondary-blue rounded-full mx-auto mb-3"></span>
                            <p class="text-gray-700 text-lg md:text-xl 2xl:text-2xl">
                                Descubra as principais funcionalidades que o SIRUS oferece
                            </p>
                        </div>

                        <!-- Grid de cards -->
                        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

                            <!-- Feature Card 1 -->
                            <div class="bg-white/90 border-b-2 border-b-primary-blue rounded-lg p-5 lg:p-7 shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 hover:scale-101">
                                <div class="bg-secondary-blue p-3 w-12 h-12 lg:w-16 lg:h-16 flex items-center justify-center rounded-xl mb-4">
                                    <x-lucide-clipboard-check class="text-white w-5 h-5 lg:w-6 lg:h-6"/>
                                </div>
                                <h4 class="text-gray-900 font-semibold text-lg lg:text-xl 2xl:text-3xl mb-3">Criação de Avaliações</h4>
                                <p class="text-gray-500 text-sm lg:text-base 2xl:text-xl 2xl:leading-8">
                                    Crie avaliações personalizadas com diferentes tipos de critérios, como apresentação, argumentação, clareza conceitual e participação.
                                </p>
                            </div>

                            <!-- Feature Card 2 -->
                            <div class="bg-white/90 border-b-2 border-b-primary-blue rounded-lg p-5 lg:p-7 shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 hover:scale-101">
                                <div class="bg-secondary-blue p-3 w-12 h-12 lg:w-16 lg:h-16 flex items-center justify-center rounded-xl mb-4">
                                    <x-lucide-users class="text-white w-5 h-5 lg:w-6 lg:h-6"/>
                                </div>
                                <h4 class="text-gray-900 font-semibold text-lg lg:text-xl 2xl:text-3xl mb-3">Gestão</h4>
                                <p class="text-gray-500 text-sm lg:text-base 2xl:text-xl 2xl:leading-8">
                                    Cadastro e gerenciamento completo de grupos, trabalhos acadêmicos, cursos e usuários com permissões específicas para cada perfil.
                                </p>
                            </div>

                            <!-- Feature Card 3 -->
                            <div class="bg-white/90 border-b-2 border-b-primary-blue rounded-lg p-5 lg:p-7 shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 hover:scale-101">
                                <div class="bg-secondary-blue p-3 w-12 h-12 lg:w-16 lg:h-16 flex items-center justify-center rounded-xl mb-4">
                                    <x-lucide-calendar class="text-white w-5 h-5 lg:w-6 lg:h-6"/>
                                </div>
                                <h4 class="text-gray-900 font-semibold text-lg lg:text-xl 2xl:text-3xl mb-3">Agenda de Bancas</h4>
                                <p class="text-gray-500 text-sm lg:text-base 2xl:text-xl 2xl:leading-8">
                                    Organização e agendamento de bancas avaliadoras com definição de membros, datas e grupos, facilitando o acompanhamento das apresentações.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-7/12 mx-auto p-5">
                        <div class="bg-white/90 border-b-4 border-b-primary-blue rounded-lg p-8 lg:p-7 shadow-xl hover:shadow-xl transition transform hover:-translate-y-0.5 hover:scale-101">
                            <div class="text-center">
                                <h2 class="text-3xl md:text-4xl 2xl:text-4xl font-semibold text-gray-900 mb-3 uppercase">
                                    O que é o SIMBAJU?
                                </h2>
                            </div>

                            <div class="indent-5 text-center">
                                <p class="text-gray-500 text-sm lg:text-base 2xl:text-xl leading-relaxed lg:leading-7 2xl:leading-9">
                                    O Simpósio da Bacia do Juquery (SIMBAJU) é um evento acadêmico-científico realizado semestralmente na Faculdade de Tecnologia de Franco da Rocha,
                                    no estado de São Paulo. A instituição de ensino superior promove, com a apresentação dos trabalhos dos alunos, uma troca de conhecimento
                                    entre alunos e especialistas, ajudando os participantes e ouvintes a terem uma formação mais sólida na área.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- Footer -->
        <footer class="bg-primary-blue text-white py-6 border-t-2 border-strong-blue">
            <div class="max-w-[1580px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">

                    <!-- Logo + Nome -->
                    <div class="flex flex-col items-start">
                        <div class="flex flex-row items-center">
                            <x-authentication-card-logo class="w-10 h-10 mr-2"/>
                            <span class="font-semibold text-lg">SIRUS</span>
                        </div>
                        <!-- Copyright -->
                        <p class=" text-sm text-gray-400">
                            &copy; 2025. Todos os direitos reservados.
                        </p>
                    </div>

                    <!-- Links -->
                    <div class="flex gap-4 mt-3 md:mt-0">
                        <a target="_blank" href="{{ route('policy.show') }}" class="text-gray-400 hover:text-white text-sm">Política de Privacidade</a>
                        <a target="_blank"  href="{{ route('terms.show') }}" class="text-gray-400 hover:text-white text-sm">Termos de Uso</a>
                        {{-- <a href="#" class="text-gray-400 hover:text-white text-sm">Suporte</a> --}}
                    </div>
                </div>
            </div>
        </footer>
        @livewireScripts
        @if(config('accessibility.libras'))
            {{-- Assistente de libras --}}
            <div x-data="{ vlActive: localStorage.getItem('vlibras_enabled') === 'true' }"
                 class="flex">

                <div vw class="enabled" x-show="vlActive" x-cloak>
                    <div vw-access-button class="active"></div>
                    <div vw-plugin-wrapper>
                        <div class="vw-plugin-top-wrapper"></div>
                    </div>
                </div>
                <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        new window.VLibras.Widget('https://vlibras.gov.br/app');
                    });
                </script>
            </div>
        @endif
        @if(config('accessibility.daltonism'))
            {{-- script dos filtros de daltonismo --}}
            <script>
                const app = document.getElementById('app');
                const select = document.getElementById('type-daltonism');

                const filters = {
                    normal: 'none',
                    achromatomaly: 'url(#achromatomaly)',
                    achromatopsia: 'url(#achromatopsia)',
                    deuteranomaly: 'url(#deuteranomaly)',
                    deuteranopia: 'url(#deuteranopia)',
                    protanomaly: 'url(#protanomaly)',
                    protanopia: 'url(#protanopia)',
                    tritanomaly: 'url(#tritanomaly)',
                    tritanopia: 'url(#tritanopia)',
                };

                // Recupera o filtro salvo (ou "normal" por padrão)
                const savedFilter = localStorage.getItem('daltonismFilter') || 'normal';

                // Aplica o filtro salvo imediatamente
                app.style.filter = filters[savedFilter] || 'none';
                select.value = savedFilter;

                // Quando o usuário muda o filtro
                select.addEventListener('change', () => {
                    const selected = select.value;
                    app.style.filter = filters[selected] || 'none';
                    localStorage.setItem('daltonismFilter', selected);
                });
            </script>
        @endif
    </body>
</html>
