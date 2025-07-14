<nav x-data="{ open: false }" class="bg-white border-b border-gray-300">
        <!-- Menu padrão (desktop e acima de 300px) -->
    <div class="max-w-[1900px] mx-auto hidden xxs:block">
        <div class="flex justify-between h-16 w-full">
            <div class="flex">
                <div class="hidden space-x-8 sm:-my-px xxs:ms-5 xs:ms-10 xxs:flex">
                    <x-nav-link href="/users/students" :active="request()->routeIs('users.students-table','users')">
                        {{ __('Alunos') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px xxs:ms-5 xs:ms-10 xxs:flex">
                    <x-nav-link href="/users/professors" :active="request()->routeIs('users.professors-table')">
                        {{ __('Professores') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px xxs:ms-5 xs:ms-10 xxs:flex">
                    <x-nav-link href="/users/coordinators" :active="request()->routeIs('users.coordinators-table')">
                        {{ __('Coordenadores') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu responsivo (somente abaixo de 300px) -->
    <div class="block xxs:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="/users/students" :active="request()->routeIs('users.students-table','users')">
                {{ __('Alunos') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="/users/professors" :active="request()->routeIs('users.professors-table')">
                {{ __('Professores') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="/users/coordinators" :active="request()->routeIs('users.coordinators-table')">
                {{ __('Coordenadores') }}
            </x-responsive-nav-link>
        </div>
    </div>

    {{ $slot  }}
</nav>
