<x-guest-layout>
    <nav x-data="{ open:false }" id="navigation" class="bg-white border-b border-gray-100">
        @php
            $links = [
                ['label' => 'Início', 'href' => route('home'), 'route' => 'home'],
                ['label' => 'Manual', 'href' => route('manual.show','introduction'), 'route' => 'manual.show'],
                ['label' => 'Termos', 'href' => route('terms.show'), 'route' => 'terms.show'],
                ['label' => 'Privacidade', 'href' => route('policy.show'), 'route' => 'policy.show']
            ];
        @endphp
        <div class="flex items-center mx-auto max-w-[2100px] h-16 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}">
                <x-application-logo
                    size="40"
                    class="flex-shrink-0 transform transition-all"
                />
            </a>

            <div class="hidden md:flex items-center w-full min-h-full max-w-[2100px]">
                <ul class="mx-4 lg:ms-10 inline-flex items-center overflow-x-auto no-scrollbar gap-5 lg:gap-7 h-16">
                    @foreach($links as $link)
                        <li class="h-full flex items-center">
                            <a href="{{ $link['href'] }}"
                                class="h-full pt-1 px-1 inline-flex items-center border-b
                                {{ request()->routeIs($link['route'])
                                ? 'border-secondary-blue text-gray-900'
                                : 'text-gray-500 hover:text-gray-900 border-transparent hover:border-gray-300' }}
                                text-sm lg:text-base whitespace-nowrap">
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="hidden ms-auto md:flex">
                    <a class="text-white inline-flex items-center gap-3 px-4 py-2
                        bg-secondary-blue border border-transparent rounded-lg font-semibold text-xs
                        uppercase tracking-widest hover:opacity-90 shadow-[0_2px_5px_rgba(0,0,0,0.28)]
                        focus:opacity-90 active:strong-blue focus:outline-none focus:ring-2 whitespace-nowrap
                        focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50
                        transition ease-in-out duration-150"
                        href="@auth /calendar @else /login @endauth">

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
        <div class="hidden md:hidden flex-col w-full py-5 pt-2" :class="{'block': open, 'hidden': ! open}">
            <ul class="flex flex-col items-start justify-start gap-2 pb-5 no-scrollbar">
                @foreach($links as $link)
                    <li class="w-full">
                        <a href="{{ $link['href'] }}"
                            class="block w-full text-sm lg:text-base font-medium text-gray-700 hover:text-secondary-blue whitespace-nowrap
                            hover:bg-soft-blue px-5 py-2 border-l-4 border-transparent hover:border-secondary-blue text-start"
                        >{{ $link['label'] }}</a>
                    </li>
                @endforeach
            </ul>
            <hr class="mx-5 mb-4">
            <div class="flex w-full px-5">
                <a class="text-white inline-flex items-center gap-3 px-4 py-2 justify-center w-full
                bg-secondary-blue border border-transparent rounded-lg font-semibold text-xs lg:text-sm
                 uppercase tracking-widest hover:opacity-90 shadow-[0_2px_5px_rgba(0,0,0,0.28)]
                focus:opacity-90 active:strong-blue focus:outline-none focus:ring-2 whitespace-nowrap
                focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50
                transition ease-in-out duration-150"
                href="@auth /calendar @else /login @endauth">

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
    <section id="hero" class="flex justify-center items-center py-6 lg:py-10 xl:py-16 bg-white">
        <div class="grid items-center justify-center lg:grid-cols-10 xl:min-h-[800px] max-w-[2200px] px-5 sm:px-10 py-16 mb-2 2xl:px-16 2xl:pt-20 lg:pb-20 xl:pb-28">
            <div class="flex flex-col gap-5 h-full lg:col-span-6 lg:pe-20 pb-10 lg:pb-0">
                <div class="mb-4 md:text-left">
                    <span class="rounded-full px-5 py-1 text-blue-500 bg-blue-100 font-medium text-sm xs:text-base lg:text-lg xl:text-xl whitespace-nowrap">Sistema de gestão do SIMBAJU</span>
                </div>
                <div class="md:text-left">
                    <h2 class="text-[2.5rem] xs:text-5xl sm:text-6xl md:text-[4rem] lg:text-[5rem] xl:text-[5.5rem] 3xl:text-[6.5rem] leading-[1.2] font-extrabold mb-8 text-gray-900">
                        Simplificando a gestão avaliativa
                    </h2>
                    <p class="text-lg sm:text-xl lg:text-2xl 3xl:text-3xl leading-[1.5] opacity-80 mb-4">
                        Uma plataforma intuitiva para gerenciar, aplicar e analisar avaliações acadêmicas com eficiência e padronização.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 w-full mt-auto mb-8">
                    <a
                        class="text-white inline-flex items-center px-4 lg:px-5 py-3
                        bg-gradient-to-b from-secondary-blue to-blue-600 border border-transparent rounded-lg
                        font-semibold text-xs sm:text-sm lg:text-base xl:text-lg 2xl:text-2xl uppercase tracking-widest
                        hover:opacity-90 shadow-[0_2px_5px_rgba(0,0,0,0.28)] overflow-hidden
                        focus:opacity-90 active:strong-blue focus:outline-none focus:ring-2 max-w-[240px] sm:max-w-fit
                        focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50 w-full
                        self-start transition ease-in-out duration-150"
                        href="@auth /calendar @else /login @endauth"
                    >

                        <span class="inline-flex items-center gap-2 text-left">
                            @auth
                                <x-lucide-calendar-days class="flex-shrink-0 h-4 w-4 sm:h-5 sm:w-5 lg:h-6 lg:w-6 transition-all"/>
                                Agenda SIMBAJU
                            @else
                                <x-lucide-log-in class="flex-shrink-0 h-4 w-4 sm:h-5 sm:w-5 lg:h-6 lg:w-6 transition-all"/>
                                Fazer Login
                            @endauth
                        </span>
                    </a>

                    <a
                        class="text-gray-900 hover:text-white inline-flex items-center gap-2 px-4 lg:px-5 py-3
                        bg-transparent-blue border border-gray-900 hover:bg-gradient-to-b w-full
                        hover:from-secondary-blue hover:to-blue-600 rounded-lg font-semibold text-xs sm:text-sm lg:text-base xl:text-lg 2xl:text-2xl
                        uppercase tracking-widest hover:opacity-90 hover:border-transparent
                        focus:opacity-90 active:strong-blue focus:outline-none focus:ring-2
                        focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50
                        self-start hover:shadow-[0_2px_5px_rgba(0,0,0,0.28)] overflow-hidden max-w-[240px] sm:max-w-fit
                        transition-colors duration-150"
                        href="{{ route('manual.show','introduction') }}"
                    >
                        <x-lucide-book-text class="flex-shrink-0 h-4 w-4 sm:h-5 sm:w-5 lg:h-6 lg:w-6 transition-all"/>
                        <span class="block text-left">
                            Manual do usuário
                        </span>
                    </a>
                </div>

                <div class="grid grid-cols-2 xs:grid-cols-3 md:grid-cols-4 gap-8 w-full">
                    <div class="flex flex-col">
                        <span class="text-gray-900 font-bold text-base lg:text-lg xl:text-xl">Rápido</span>
                        <span class="text-gray-500 font-medium text-sm lg:text-base xl:text-lg">Interface interativa</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-900 font-bold text-base lg:text-lg xl:text-xl">Eficiente</span>
                        <span class="text-gray-500 font-medium text-sm lg:text-base xl:text-lg">Tudo automatizado</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-900 font-bold text-base lg:text-lg xl:text-xl">Centralizado</span>
                        <span class="text-gray-500 font-medium text-sm lg:text-base xl:text-lg">Informações consolidadas</span>
                    </div>
                </div>
            </div>
            <div class="hidden lg:flex flex-col items-center justify-center lg:col-span-4 w-full lg:max-h-[70%] max-h-full xl:max-h-[80%] 2xl:max-h-[90%] 3xl:max-h-full mx-auto shadow-[2px_2px_5px_rgba(0,0,0,0.40)]
                rounded-xl py-20 px-10 h-full bg-gradient-to-b from-secondary-blue to-blue-700 border border-gray-500">
                <x-authentication-card-logo class="w-[190px] h-[100px] xl:w-[228px] lg:h-[120px] 2xl:w-[266px] xl:h-[140px]"/>
                <h1 class="text-white mt-3 mb-0 text-[3.5rem] xlg::text-[4.5rem] font-bold leading-tight">
                    SIRUS
                </h1>
                <p class="text-white text-xl font-medium opacity-80 mb-0 text-center">
                    Sistema de Rubricas para Gestão Avaliativa do SIMBAJU
                </p>
            </div>
        </div>
    </section>
    {{-- Funcionalidades --}}
    <section id="features" class="bg-gray-50 py-16">
        <div class="p-5 xs:p-16 sm:p-10 xl:p-10 2xl:p-16 max-w-[2200px] mx-auto">
            {{-- Cabeçalho --}}
            <div class="flex w-full flex-col gap-5 justify-center items-center mb-16">
                <span class="bg-blue-100 rounded-full px-5 py-1 text-blue-500 font-medium text-base lg:text-xl 2xl:text-2xl whitespace-nowrap">
                    O que oferecemos
                </span>
                <h2 class="text-gray-900 leading-[1.2] font-extrabold text-3xl sm:text-4xl md:text-5xl xl:text-7xl ">
                    Funcionalidades principais
                </h2>
                <p class="text-gray-500 text-lg sm:text-xl xl:text-2xl font-normal">
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
                        ['icon' =>'lock', 'title' => 'Autenticação de dois fatores', 'text' => 'A autenticação de dois fatores fortalece o processo de
                        login ao exigir que o usuário confirme sua identidade por meio de um código temporário gerado em um aplicativo autenticador.'],
                    ] as $feature)

                    <!-- Feature Card {{ $loop->index + 1 }} -->
                    <div class="bg-white border border-gray-200 hover:border-secondary-blue rounded-3xl p-8 shadow-[0_2px_5px_rgba(0,0,0,0.28)] transition duration-300 ease-in-out">
                        <div class="bg-secondary-blue p-3 w-12 h-12 lg:w-16 lg:h-16 flex items-center justify-center rounded-xl mb-4">
                            <x-dynamic-component :component="'lucide-' . $feature['icon']" class="text-white w-5 h-5 lg:w-6 lg:h-6"/>
                        </div>
                        <h4 class="text-gray-900 font-semibold text-lg lg:text-xl 2xl:text-2xl mb-3">{{ $feature['title'] }}</h4>
                        <p class="text-gray-500 text-sm lg:text-base 2xl:text-xl 2xl:leading-8">
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
            <div class="h-24 md:h-28 lg:h-32 bg-white"></div>
            <div class="relative w-full md:py-40 md:px-10">
                {{-- Overlay --}}
                <div class="absolute inset-0 bg-black/40"></div>
                {{-- Card principal --}}
                <div class="relative grid grid-cols-1 xl:grid-cols-2 bg-white max-w-[1700px] border border-gray-200 md:border-none mx-auto md:rounded-2xl shadow-[0_2px_5px_rgba(0,0,0,0.28)] overflow-hidden">
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
                            <h3 class="text-lg lg:text-xl 2xl:text-2xl font-bold text-gray-900 flex items-center gap-3">
                                <x-lucide-book-open class="w-8 h-8 text-primary-blue flex-shrink-0" />
                                O que é o SIMBAJU?
                            </h3>

                            <p class="text-gray-600 leading-relaxed text-sm lg:text-base 2xl:text-lg">
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
                            <h3 class="text-lg lg:text-xl 2xl:text-2xl font-bold text-gray-900 flex items-center gap-1">
                                <x-lucide-lightbulb class="w-8 h-8 block leading-none text-primary-blue text-lg lg:text-xl 2xl:text-2xl flex-shrink-0" />
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
                                        <x-lucide-check-circle-2 class="w-5 h-5 text-primary-blue flex-shrink-0" />
                                        <span class="text-gray-700 text-sm lg:text-base 2xl:text-lg">{{ $item }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Comunidade -->
                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex items-start gap-4">
                                <x-lucide-users class="w-6 h-6 text-primary-blue mt-1 flex-shrink-0" />
                                <div>
                                    <h4 class="text-lg lg:text-xl 2xl:text-2xl font-bold text-gray-900 mb-1">
                                        Comunidade Acadêmica
                                    </h4>
                                    <p class="text-gray-600 text-sm lg:text-base 2xl:text-lg">
                                        Todos os alunos podem participar independentemente do curso ou semestre.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h-24 md:h-28 lg:h-32 bg-white"></div>
        </div>
    </section>
    {{-- Rodapé --}}
    <footer class="bg-white text-white border-t border-gray-200 mx-10">
        <div class="max-w-[2200px] mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
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
</x-guest-layout>
