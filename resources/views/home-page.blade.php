<x-guest-layout>
    <x-slot name="title">
        Início
    </x-slot>

    <nav x-data="{ open:false }" id="navigation" class="bg-white border-b border-gray-100 dark:bg-gray-900 dark:border-gray-700 transition duration-150 ease-in-out">
        @php
            $links = [
                ['label' => 'Início', 'href' => route('home'), 'route' => 'home'],
                ['label' => 'Manual', 'href' => route('manual.show','#introduction'), 'route' => 'manual.show'],
                ['label' => 'Termos', 'href' => route('terms.show'), 'route' => 'terms.show'],
                ['label' => 'Privacidade', 'href' => route('policy.show'), 'route' => 'policy.show']
            ];
        @endphp
        {{-- Menu primário --}}
        <div class="flex items-center mx-auto max-w-[1850px] h-16 px-4 sm:px-6 lg:px-8">
            {{-- Logotipo --}}
            <div class="shrink-0 flex items-center relative me-20 h-16">
                <a href="{{ route('home') }}">
                    <!-- Logo claro -->
                    <x-application-logo
                        size="40"
                        class="absolute mt-3 inset-0 transform transition-all duration-300 ease-in-out
                            opacity-100 scale-100 dark:opacity-0 dark:scale-100"
                    />

                    <!-- Logo escuro -->
                    <x-authentication-card-logo
                        size="40"
                        class="absolute mt-3 inset-0 transform transition-all duration-300 ease-in-out
                            opacity-0 scale-100 dark:opacity-100 dark:scale-100"
                    />
                </a>
            </div>
            {{-- Options --}}
            <div class="hidden md:flex items-center w-full min-h-full max-w-[1850px]">
                <ul class="mx-4 lg:ms-10 inline-flex items-center overflow-x-auto no-scrollbar gap-5 lg:gap-7 h-16">
                    @foreach($links as $link)
                        <li class="h-full">
                            <x-nav-link href="{{ $link['href'] }}" class="h-full !text-base !border-b" :active="request()->routeIs($link['route'])">
                                {{ $link['label'] }}</x-nav-link>
                        </li>
                    @endforeach
                </ul>

                <div class="hidden ms-auto md:flex">
                    <a
                        rel="noreferrer noopener"
                        class="text-white inline-flex items-center gap-3 px-4 py-2 bg-gradient-to-b from-secondary-blue to-blue-600
                        dark:from-primary-blue dark:to-blue-900 rounded-lg font-semibold text-xs
                        uppercase tracking-widest hover:opacity-90 shadow-[0_2px_5px_rgba(0,0,0,0.28)] dark:focus:ring-offset-gray-900
                        focus:opacity-90 active:strong-blue focus:outline-none focus:ring-2 whitespace-nowrap
                        focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50
                        transition ease-in-out duration-150"
                        href="@auth /calendar @else /login @endauth"
                    >
                        <span class="inline-flex items-center gap-2">
                            <x-lucide-log-in class="flex-shrink-0 h-4 w-4 transition-all"/>
                            @auth
                                Acessar SIRUS
                            @else
                                Fazer Login
                            @endauth
                        </span>
                    </a>
                </div>
            </div>
            {{-- Ícone para colapsar menu --}}
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
        {{-- Menu mobile --}}
        <div class="hidden md:hidden flex-col w-full py-5 pt-2" :class="{'block': open, 'hidden': ! open}">
            <ul class="flex flex-col items-start justify-start gap-2 pb-5 no-scrollbar">
                @foreach($links as $link)
                    <li class="w-full">
                        <x-responsive-nav-link href="{{ $link['href'] }}" class="pl-5" :active="request()->routeIs($link['route'])">
                            {{ $link['label'] }}</x-responsive-nav-link>
                    </li>
                @endforeach
            </ul>
            <hr class="mx-5 mb-4 border-gray-200 dark:border-gray-700">
            <div class="flex w-full px-5">
                <a
                    rel="noreferrer noopener"
                    class="text-white inline-flex items-center gap-3 px-4 py-2 justify-center w-full
                    bg-gradient-to-b from-secondary-blue to-blue-600
                    dark:from-primary-blue dark:to-blue-900
                    rounded-lg font-semibold text-xs lg:text-sm
                    uppercase tracking-widest hover:opacity-90 shadow-[0_2px_5px_rgba(0,0,0,0.28)]
                    focus:opacity-90 active:strong-blue focus:outline-none focus:ring-2 whitespace-nowrap
                    focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50
                    transition ease-in-out duration-150"
                    href="@auth /calendar @else /login @endauth"
                >
                <span class="inline-flex items-center gap-2">
                    @auth
                        <x-lucide-log-in class="flex-shrink-0 h-4 w-4 transition-all"/>
                        Acessar
                    @else
                        <x-lucide-log-in class="flex-shrink-0 h-4 w-4 transition-all"/>
                        Fazer Login
                    @endauth
                </span>
                </a>
            </div>
        </div>
    </nav>
    {{-- Sessão inicial --}}
    <section id="hero" class="flex justify-center items-center sm:py-6 lg:py-10 xl:py-16 bg-white dark:bg-gray-900 transition duration-150 ease-in-out">
        <div class="grid items-center justify-center lg:grid-cols-10 xl:min-h-[750px] xlg:min-h-[800px] max-w-[1900px] xs:px-5 sm:px-10 py-16 mb-2 2xl:px-16 2xl:pt-20 lg:pb-20 xl:pb-28">
            {{-- Logo para telas < 1024px --}}
            <div x-data="{ show: false }" x-init="$nextTick(() => show = true)"
                 class="lg:hidden flex flex-col items-center justify-center lg:col-span-4 w-full lg:max-h-[70%] max-h-full xl:max-h-[80%] 2xl:max-h-[90%] 3xl:max-h-full mx-auto shadow-[2px_2px_5px_rgba(0,0,0,0.40)]
                 rounded-xl py-10 md:py-20 px-10 min-h-[280px] md:min-h-[362px] h-full bg-gradient-to-b from-secondary-blue to-blue-700 dark:from-primary-blue dark:to-blue-950 border border-gray-500 dark:border-slate-900">
                <x-authentication-card-logo
                    x-show="show"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-20"
                    x-transition:enter-end="opacity-100"
                    class="w-[152px] h-[80px] md:w-[190px] md:h-[100px] xl:w-[228px] lg:h-[120px] 2xl:w-[266px] xl:h-[140px]"/>
                <h1
                    x-show="show"
                    x-transition:enter="transition ease-out duration-500 delay-200"
                    x-transition:enter-start="opacity-0 translate-y-20"
                    x-transition:enter-end="opacity-100"
                    class="text-white mt-3 mb-0 text-[2.5rem] md:text-[3rem] lg:text-[3.5rem] xlg::text-[4.5rem] font-bold leading-tight">
                    SIRUS
                </h1>
                <p
                    x-show="show"
                    x-transition:enter="transition ease-out duration-500 delay-500"
                    x-transition:enter-start="opacity-0 translate-y-20"
                    x-transition:enter-end="opacity-100"
                    class="text-gray-100 dark:text-gray-300 text-xl font-medium mb-0 text-center">
                    Sistema de Rubricas para Gestão Avaliativa do SIMBAJU
                </p>
            </div>
            {{-- Conteúdo principal --}}
            <div class="pt-10 md:pt-16 lg:pt-0 flex flex-col gap-5 h-full lg:col-span-6 lg:pe-16 xl:pe-20 lg:pb-0">
                <div class="mb-4 mx-auto sm:m-0">
                    <span class="rounded-full px-5 py-1 font-medium text-sm xs:text-base lg:text-lg xl:text-xl whitespace-nowrap
                        bg-blue-100 text-blue-500 dark:bg-blue-900/40 dark:text-blue-300 transition duration-150 ease-in-out">
                        Sistema de gestão do SIMBAJU
                    </span>
                </div>
                <div class="mb-4 px-4 xs:px-0">
                    <h2 class="text-[2.8rem] xs:text-6xl sm:text-7xl md:text-[5rem] xl:text-[5.5rem] 3xl:text-[7rem] leading-[1.2] font-extrabold mb-8 text-gray-900 dark:text-gray-100
                        transition duration-150 ease-in-out">
                        Simplificando a gestão avaliativa
                    </h2>
                    <p class="text-lg xs:text-xl md:text-2xl 3xl:text-3xl leading-[1.5] opacity-80 mb-4 text-gray-700 dark:text-gray-200
                        transition duration-150 ease-in-out">
                        Uma plataforma intuitiva para gerenciar, aplicar e analisar avaliações acadêmicas com eficiência e padronização.
                    </p>
                </div>
                {{-- Botões de ação --}}
                <div class="flex flex-col sm:flex-row gap-2 w-full lg:mt-auto mb-8 px-4 xs:px-0">
                    {{-- Botão para entrar no sistema --}}
                    <a
                        rel="noreferrer noopener"
                        class="text-white inline-flex items-center px-4 lg:px-5 py-3 justify-center sm:justify-start
                        bg-gradient-to-b from-secondary-blue to-blue-600 rounded-lg
                        dark:from-primary-blue dark:to-blue-900 dark:focus:ring-offset-gray-800
                        font-semibold text-sm xl:text-lg 2xl:text-xl uppercase tracking-widest
                        hover:opacity-90 shadow-[0_2px_5px_rgba(0,0,0,0.28)] overflow-hidden
                        focus:opacity-90 active:strong-blue focus:outline-none focus:ring-2 sm:max-w-fit
                        focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50 w-full
                        self-center sm:self-start transition ease-in-out duration-150"
                        href="@auth /calendar @else /login @endauth"
                    >
                        <span class="inline-flex items-center gap-2 text-left">
                            @auth
                                <x-lucide-calendar-days class="flex-shrink-0 h-5 w-5 lg:h-6 lg:w-6 transition-all"/>
                                Agenda SIMBAJU
                            @else
                                <x-lucide-log-in class="flex-shrink-0 h-5 w-5 lg:h-6 lg:w-6 transition-all"/>
                                Fazer Login
                            @endauth
                        </span>
                    </a>
                    {{-- Botão para abrir manual do usuário --}}
                    <a
                        rel="noreferrer noopener"
                        class="text-gray-900 hover:text-white inline-flex items-center justify-center sm:justify-start gap-2 px-4 lg:px-5 py-3
                        bg-transparent-blue border border-gray-900 hover:bg-gradient-to-b w-full
                        hover:from-secondary-blue hover:to-blue-600 rounded-lg font-semibold text-sm xl:text-lg 2xl:text-xl
                        dark:text-gray-100 dark:border-gray-100 dark:hover:border-slate-900 dark:hover:from-primary-blue dark:hover:to-dark-blue
                        uppercase tracking-widest hover:opacity-90 hover:border-transparent dark:focus:ring-offset-gray-800
                        focus:opacity-90 active:strong-blue focus:outline-none focus:ring-2
                        focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50
                        self-center sm:self-start hover:shadow-[0_2px_5px_rgba(0,0,0,0.28)] overflow-hidden sm:max-w-fit
                        transition duration-150 ease-in-out"
                        href="{{ route('manual.show','#introduction') }}"
                    >
                        <x-lucide-book-text class="flex-shrink-0 h-5 w-5 lg:h-6 lg:w-6 transition-all"/>
                        <span class="block text-left">
                            Manual do usuário
                        </span>
                    </a>
                </div>
                {{-- Descrição concisa de algumas características do sistema --}}
                <div class="hidden sm:grid grid-cols-2 xs:grid-cols-3 md:grid-cols-4 gap-8 w-full">
                    <div class="flex flex-col">
                        <span class="text-gray-900 dark:text-gray-100 font-bold text-base lg:text-lg xl:text-xl">Rápido</span>
                        <span class="text-gray-500 dark:text-gray-400 font-medium text-sm lg:text-base xl:text-lg">Interface interativa</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-900 dark:text-gray-100 font-bold text-base lg:text-lg xl:text-xl">Eficiente</span>
                        <span class="text-gray-500 dark:text-gray-400 font-medium text-sm lg:text-base xl:text-lg">Tudo automatizado</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-900 dark:text-gray-100 font-bold text-base lg:text-lg xl:text-xl">Centralizado</span>
                        <span class="text-gray-500 dark:text-gray-400 font-medium text-sm lg:text-base xl:text-lg">Informações consolidadas</span>
                    </div>
                </div>
            </div>
            {{-- Logo para telas > 1024px --}}
            <div x-data="{ show: false }" x-init="$nextTick(() => show = true)"
                class="hidden lg:flex flex-col items-center justify-center lg:col-span-4 w-full lg:max-h-[70%] max-h-full xl:max-h-[80%] 2xl:max-h-[90%] 3xl:max-h-full mx-auto shadow-[2px_2px_5px_rgba(0,0,0,0.40)]
                rounded-xl py-20 px-10 h-full bg-gradient-to-b from-secondary-blue to-blue-700 dark:from-primary-blue dark:to-blue-950 border border-gray-500 dark:border-slate-900">
                <x-authentication-card-logo
                    x-show="show"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 translate-y-20"
                    x-transition:enter-end="opacity-100"
                    class="w-[190px] h-[100px] xl:w-[228px] lg:h-[120px] 2xl:w-[266px] xl:h-[140px]"/>
                <h1
                    x-show="show"
                    x-transition:enter="transition ease-out duration-500 delay-200"
                    x-transition:enter-start="opacity-0 translate-y-20"
                    x-transition:enter-end="opacity-100"
                    class="text-white mt-3 mb-0 text-[3.5rem] xlg::text-[4.5rem] font-bold leading-tight">
                    SIRUS
                </h1>
                <span
                    x-show="show"
                    x-transition:enter="transition ease-out duration-500 delay-500"
                    x-transition:enter-start="opacity-0 translate-y-20"
                    x-transition:enter-end="opacity-100"
                    class="text-gray-100 dark:text-gray-300 text-xl font-medium mb-0 text-center">
                    Sistema de Rubricas para Gestão Avaliativa do SIMBAJU
                </span>
            </div>
        </div>
    </section>
    {{-- Funcionalidades --}}
    <section id="features" class="bg-gray-50 dark:bg-gray-900 opacity-[0.98] transition duration-150 ease-in-out py-16">
        <div class="p-5 xs:p-16 sm:p-10 xl:p-10 2xl:p-16 max-w-[1900px] mx-auto">
            {{-- Cabeçalho --}}
            <div class="flex w-full flex-col gap-5 justify-center items-center mb-16">
                <span class="rounded-full px-5 py-1 font-medium text-base lg:text-xl 2xl:text-2xl whitespace-nowrap
                    bg-blue-100 text-blue-500 dark:bg-blue-900/40 dark:text-blue-300 transition duration-150 ease-in-out">
                    O que oferecemos
                </span>
                <h2 class="text-center text-gray-900 leading-[1.2] font-extrabold text-3xl sm:text-4xl md:text-5xl xl:text-7xl
                    dark:text-gray-100 transition duration-150 ease-in-out">
                    Funcionalidades principais
                </h2>
                <p class="text-center px-10 xs:px-0 text-gray-500 text-base xs:text-lg sm:text-xl xl:text-2xl font-normal
                    dark:text-gray-200 transition duration-150 ease-in-out">
                    Descubra os principais recursos que o SIRUS oferece
                </p>
            </div>
            {{-- Cards --}}
            <div class="grid gap-x-8 gap-y-16 sm:grid-cols-2 lg:grid-cols-3">
                @foreach(
                    [   ['icon' =>'users', 'title' => 'Gestão', 'text' => 'Cadastro e administração completa de grupos, cursos, trabalhos
                        acadêmicos e usuários. Cada perfil conta com permissões específicas, garantindo controle e organização em todas as etapas.'],
                        ['icon' =>'clipboard-check', 'title' => 'Criação de Avaliações', 'text' => 'Ferramentas para montar avaliações personalizadas com critérios variados
                        — como apresentação, argumentação, clareza conceitual e participação — permitindo análises mais precisas e alinhadas às necessidades do curso.'],
                        ['icon' =>'calendar', 'title' => 'Agenda de Bancas', 'text' => 'Planejamento e organização de bancas avaliadoras com definição
                        de datas, grupos e membros da comissão. Tudo centralizado para acompanhar o processo de forma prática e transparente.'],
                        ['icon' =>'file-text', 'title' => 'Trabalhos acadêmicos', 'text' => 'Organização inteligente de trabalhos acadêmicos. Os arquivos digitais dos projetos
                        semestrais são armazenados de forma prática e acessível, permitindo que alunos e professores visualizem ou baixem o material sempre que necessário.'],
                        ['icon' =>'import', 'title' => 'Importação de dados', 'text' => 'Importação de dados via planilhas Excel para acelerar cadastros em massa.
                        Em vez de registrar usuários um por um, o sistema permite um fluxo automatizado e eficiente para grandes volumes de informações.'],
                        ['icon' =>'lock', 'title' => 'Autenticação em dois fatores', 'text' => 'A autenticação em dois fatores fortalece o processo de
                        login ao exigir que o usuário confirme sua identidade por meio de um código temporário gerado em um aplicativo autenticador.'],
                    ] as $feature)

                    <!-- Feature Card {{ $loop->index + 1 }} -->
                    <div
                        x-data="{ show: false }"
                        x-intersect="show = true"
                        :class="show
                            ? 'opacity-100 translate-y-0'
                            : 'opacity-0 translate-y-40'"
                        class="bg-white border border-gray-200 hover:border-secondary-blue rounded-3xl p-8
                        shadow-[0_2px_5px_rgba(0,0,0,0.28)]
                        dark:bg-slate-800 dark:border-slate-900 dark:hover:border-secondary-blue
                        transition-all duration-700 ease-out"
                    >
                        <div class="bg-secondary-blue p-3 w-12 h-12 lg:w-16 lg:h-16 flex items-center justify-center rounded-xl mb-4">
                            <x-dynamic-component :component="'lucide-' . $feature['icon']" class="text-white w-5 h-5 lg:w-6 lg:h-6"/>
                        </div>
                        <h4 class="text-gray-900 font-semibold text-lg lg:text-xl 2xl:text-2xl mb-3 dark:text-gray-100 transition duration-300 ease-in-out">{{ $feature['title'] }}</h4>
                        <p class="text-gray-500 text-sm lg:text-base 2xl:text-xl 2xl:leading-8 dark:text-gray-300 transition duration-300 ease-in-out">
                            {{ $feature['text'] }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- Sobre o SIMBAJU --}}
    <section id="about" >
        <div class="bg-cover bg-center bg-fixed"
            style="
                background-image: url('{{ asset('/img/FATEC_Franco.jpg') }}');
                filter: url(#blur-bg);
            "
        >
            <div class="h-24 md:h-28 lg:h-32 bg-white dark:bg-gray-900 transition duration-150 ease-in-out"></div>
            <div class="relative w-full md:py-40 md:px-10">
                {{-- Overlay --}}
                <div class="absolute inset-0 bg-black/40"></div>
                {{-- Card principal --}}
                <div class="relative grid grid-cols-1 xl:grid-cols-2 bg-white max-w-[1700px] border border-gray-200 md:border-none mx-auto md:rounded-2xl shadow-[0_2px_5px_rgba(0,0,0,0.28)] overflow-hidden
                    dark:bg-slate-800 dark:border-slate-900 dark:hover:border-secondary-blue transition duration-150 ease-in-out">
                    {{-- Left side (image) --}}
                    <div class="hidden xl:block relative h-full min-h-[480px] bg-black">
                        <img
                            src="{{ asset('/img/FATEC_Franco.jpg') }}"
                            alt="FATEC Franco da Rocha"
                            class="w-full h-full object-cover"
                        >
                        <div class="absolute inset-0 bg-gradient-to-r from-black/20 to-black/10"></div>
                    </div>

                    {{-- Right side (content) --}}
                    <div class="pt-16 px-10 pb-10 lg:px-14 lg:pb-14 space-y-10">
                        <!-- O que é o SIMBAJU -->
                        <div class="space-y-4">
                            <h3 class="text-lg lg:text-xl 2xl:text-2xl font-bold text-gray-900 flex items-center gap-3
                                dark:text-gray-100 transition duration-150 ease-in-out">
                                <x-lucide-book-open class="w-8 h-8 text-primary-blue flex-shrink-0 dark:text-secondary-blue transition duration-150 ease-in-out" />
                                O que é o SIMBAJU?
                            </h3>

                            <p class="text-gray-600 leading-relaxed text-sm lg:text-base 2xl:text-lg
                                dark:text-gray-400 transition duration-150 ease-in-out">
                                O Simpósio da Bacia do Juquery (SIMBAJU) é um evento acadêmico-científico
                                realizado semestralmente na Faculdade de Tecnologia de Franco da Rocha, no
                                estado de São Paulo.
                                A instituição de ensino superior promove, com a apresentação dos trabalhos
                                dos alunos, uma troca de conhecimento entre alunos e especialistas, ajudando
                                os participantes e ouvintes a terem uma formação mais sólida na área em um
                                ambiente de inovação.
                            </p>
                        </div>

                        <!-- Por que participar -->
                        <div class="space-y-4">
                            <h3 class="text-lg lg:text-xl 2xl:text-2xl font-bold text-gray-900 flex items-center gap-1
                                dark:text-gray-100 transition duration-150 ease-in-out">
                                <x-lucide-lightbulb class="w-8 h-8 block leading-none text-primary-blue text-lg lg:text-xl 2xl:text-2xl flex-shrink-0
                                    dark:text-secondary-blue transition duration-150 ease-in-out" />
                                Por que participar?
                            </h3>

                            <div class="space-y-3">
                                @foreach ([
                                    'Apresentar e validar seus projetos',
                                    'Aprender com as soluções dos colegas',
                                    'Networking com a comunidade acadêmica',
                                    'Receber feedback de professores'
                                ] as $item)
                                    <div class="ms-[0.45rem] flex items-center gap-3">
                                        <x-lucide-check-circle-2 class="w-5 h-5 text-primary-blue flex-shrink-0
                                            dark:text-secondary-blue transition duration-150 ease-in-out" />
                                        <span class="text-gray-700 text-sm lg:text-base 2xl:text-lg
                                            dark:text-gray-400 transition duration-150 ease-in-out">{{ $item }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Comunidade -->
                        <div class="pt-4 border-t border-gray-200
                            dark:border-gray-700 transition duration-150 ease-in-out">
                            <div class="flex items-start gap-4">
                                <x-lucide-users class="w-6 h-6 text-primary-blue mt-1 flex-shrink-0
                                    dark:text-secondary-blue transition duration-150 ease-in-out" />
                                <div>
                                    <h4 class="text-lg lg:text-xl 2xl:text-2xl font-bold text-gray-900 mb-1
                                        dark:text-gray-100 transition duration-150 ease-in-out">
                                        Comunidade Acadêmica
                                    </h4>
                                    <p class="text-gray-600 text-sm lg:text-base 2xl:text-lg
                                        dark:text-gray-400 transition duration-150 ease-in-out">
                                        Todos os alunos podem participar independentemente do curso ou semestre.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-24 md:h-28 lg:h-32 bg-white dark:bg-gray-900 transition duration-150 ease-in-out"></div>
        </div>
    </section>
    {{-- Rodapé --}}
    <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 px-10 transation duration-150 ease-in-out">
        <div class="max-w-[1900px] mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-center gap-4 sm:flex-row sm:items-center sm:justify-between">

                <!-- Copyright -->
                <p class="text-sm lg:text-base text-gray-500 dark:text-gray-400 text-center sm:text-left transition">
                    &copy; 2026. Todos os direitos reservados.
                </p>

                <!-- Links + Tema -->
                <div class="flex flex-col  sm:flex-row items-center gap-3 sm:gap-4 sm:me-auto">
                    <a target="_blank"
                       href="{{ route('policy.show') }}"
                       class="underline text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300 text-sm 2xl:text-base transition duration-150 ease-in-out">
                        Política de Privacidade
                    </a>

                    <a target="_blank"
                       href="{{ route('terms.show') }}"
                       class="underline text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300 text-sm 2xl:text-base transition duration-150 ease-in-out">
                        Termos de Uso
                    </a>
                </div>
                @if(config('appearance.switch_theme'))
                    <button
                        @click="toggleTheme()"
                        class="mx-auto sm:mx-0 relative flex items-center gap-2 px-3 py-1.5 rounded-lg
                            border border-gray-300 dark:border-gray-600
                            text-gray-500 dark:text-gray-300
                            hover:bg-gray-100 dark:hover:bg-gray-800
                            transition duration-150 ease-in-out"
                            aria-label="Alternar tema"
                        >
                            <!-- Slot fixo do ícone -->
                            <span class="relative w-4 h-4">
                                <!-- Moon -->
                                <x-lucide-moon
                                    class="absolute inset-0 h-4 w-4
                                           transition-all duration-300 ease-in-out
                                           opacity-100 scale-100 rotate-0
                                           dark:opacity-0 dark:scale-75 dark:-rotate-90"
                                />
                                <!-- Sun -->
                                <x-lucide-sun
                                    class="absolute inset-0 h-4 w-4
                                           transition-all duration-300 ease-in-out
                                           opacity-0 scale-75 rotate-90
                                           dark:opacity-100 dark:scale-100 dark:rotate-0"
                                />
                            </span>
                        <span class="text-sm hidden sm:inline">Tema</span>
                    </button>
                @endif
            </div>
        </div>
    </footer>
</x-guest-layout>
