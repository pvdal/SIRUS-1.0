<nav x-data="{ open:false }" id="navigation" class="relative bg-white dark:bg-gray-900 border-b border-gray-100 dark:border-gray-700 lg:border-none md:shadow-sm md:dark:shadow-md lg:sticky top-0 z-40">
    @php
        $links = [
            ['label' => 'Início', 'href' => route('home'), 'route' => 'home'],
            ['label' => 'Manual', 'href' => route('manual.index','introduction'), 'route' => 'manual.index'],
            ['label' => 'Termos', 'href' => route('terms.index'), 'route' => 'terms.index'],
            ['label' => 'Privacidade', 'href' => route('policy.index'), 'route' => 'policy.index']
        ];
    @endphp
    <div class="flex items-center mx-auto max-w-[1850px] h-16 px-4 sm:px-6 lg:px-8">
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
                    class="text-white inline-flex items-center gap-3 px-4 py-2
                        bg-gradient-to-b from-secondary-blue to-blue-600
                        dark:from-primary-blue dark:to-blue-900
                        bg-secondary-blue rounded-lg font-semibold text-xs
                        uppercase tracking-widest hover:opacity-90 shadow-[0_2px_5px_rgba(0,0,0,0.28)]
                        focus:opacity-90 active:strong-blue focus:outline-none focus:ring-2 whitespace-nowrap
                        focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50
                        focus:ring-offset-white dark:focus:ring-offset-gray-900
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
                    <x-responsive-nav-link href="{{ $link['href'] }}" class="pl-5" :active="request()->routeIs($link['route'])">
                        {{ $link['label'] }}</x-responsive-nav-link>
                </li>
            @endforeach
        </ul>
        <hr class="mx-5 mb-4">
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
                    focus:ring-offset-white dark:focus:ring-offset-gray-900
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
