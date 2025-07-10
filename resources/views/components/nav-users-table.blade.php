<nav x-data="{ open: false }" class="bg-white border-b border-gray-300">
    <div class="max-w-[1900px] mx-auto hidden sm:block">
        <div class="flex justify-between h-16 w-full">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="/users/students" :active="request()->routeIs('users.students-table','users')">
                        {{ __('Alunos') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="/users/professors" :active="request()->routeIs('users.professors-table')">
                        {{ __('Professores') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="/users/coordinators" :active="request()->routeIs('users.coordinators-table')">
                        {{ __('Coordenadores') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div class="block sm:hidden">
        <!-- Navigation Links -->
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
