<x-guest-layout>
    <nav x-data="{ open:false }" id="navigation" class="bg-white dark:bg-red-600 border-b border-gray-100 md:border-none md:shadow md:sticky top-0 z-40">
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
                            <a href="{{ $link['href'] }}" class="h-full pt-1 px-1 inline-flex items-center border-b
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
    {{-- Sessão principal --}}
    <div class="flex flex-col min-h-screen">
        <div class="flex flex-1 flex-col w-full bg-gradient-to-br from-gray-50 to-gray-100 text-gray-900">
            {{-- Container principal --}}
            @if(isset($options))
                <div class="flex flex-1 flex-col w-full max-w-[2100px] min-h-full  mx-auto px-6 m-2 gap-8 lg:flex-row">
                    {{-- Menu lateral --}}
                    <aside class="w-full lg:w-1/4">
                        <div class="flex flex-col bg-white shadow rounded-xl
                            lg:h-[calc(100vh-80px)]
                            sticky top-[72px] py-6
                            overflow-hidden
                            border border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-700 mb-4 px-4">Manual de Usuário</h2>
                            <hr class="border-gray-100 mx-2">
                            <nav class="flex-1 space-y-1 overflow-y-auto scrollbar-custom
                                px-4 py-2 lg:h-[calc('100vh-80px-48px-34px)]">
                                {{ $options }}
                            </nav>
                        </div>
                    </aside>


                    <div class="w-full lg:w-3/4 space-y-8">
                        {{-- Conteúdo principal --}}
                        <main class="space-y-8">
                            {{ $slot }}
                        </main>
                        {{-- Rodapé --}}
                        <footer class="bg-transparent text-white border-t border-gray-200">
                            <div class="max-w-[2100px] mx-auto px-4 py-6 sm:px-6 lg:px-8">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-center">
                                    <div class="flex flex-col items-center">
                                        <div class="space-y-1 text-gray-800">
                                            <p class="text-base text-center">
                                                Manual do Usuário
                                            </p>
                                            <!-- Copyright -->
                                            <p class="text-sm text-center">
                                                &copy; <strong>SIRUS –</strong> Sistema de Rubricas para Gestão avaliativa do SIMBAJU
                                            </p>
                                            <p class="text-xs text-center">
                                                Versão 1.0 | 2025
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </footer>
                    </div>
                </div>
            @endif

            @if(!isset($options))
                {{-- Conteúdo principal --}}
                <main>
                    {{ $slot }}
                </main>
                {{-- Rodapé --}}
                <footer class="bg-white text-white border-t border-gray-200">
                    <div class="max-w-[2100px] mx-auto px-4 py-6 sm:px-6 lg:px-8">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-center">
                            <div class="flex flex-col items-center">
                                <!-- Copyright -->
                                <p class="text-sm lg:text-base text-gray-500 text-center">
                                    &copy; SIRUS 2025. Todos os direitos reservados.
                                </p>
                            </div>
                        </div>
                    </div>
                </footer>
            @endif
        </div>
    </div>
</x-guest-layout>
