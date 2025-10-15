<nav class="bg-white rounded-lg border-b border-gray-100 dark:bg-gray-900 dark:border-gray-700 transition duration-150 ease-in-out">
    <!-- Menu padrão (desktop e acima de 300px) -->
    <div class="max-w-[2100px] mx-auto hidden xxs:block border-b border-gray-100 dark:border-gray-700 transition duration-150 ease-in-out">
        <div class="flex justify-between h-16 w-full">
            <div class="flex">
                <div class="hidden space-x-8 sm:-my-px xxs:ms-5 xs:ms-10 xxs:flex">
                    <x-nav-link href="/evaluation/criteria" :active="request()->routeIs('evaluation.criteria-table')">
                        {{ __('Critérios') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px xxs:ms-5 xs:ms-10 xxs:flex">
                    <x-nav-link href="/evaluation/axis" :active="request()->routeIs('evaluation.axis-table')">
                        {{ __('Eixos') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px xxs:ms-5 xs:ms-10 xxs:flex">
                    <x-nav-link href="/evaluation/rubric" :active="request()->routeIs('evaluation.rubric-table')">
                        {{ __('Rubricas') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
    <!-- Menu responsivo (somente abaixo de 300px) -->
    <div class="block xxs:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="/evaluation/criteria" :active="request()->routeIs('evaluation.criteria.table')">
                {{ __('Critérios') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="/evaluation/axis" :active="request()->routeIs('evaluation.axis.table')">
                {{ __('Eixos') }}
            </x-responsive-nav-link>
        </div>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="/evaluation/rubric" :active="request()->routeIs('evaluation.rubric.table')">
                {{ __('Rubricas') }}
            </x-responsive-nav-link>
        </div>
    </div>

    {{ $slot  }}
</nav>
