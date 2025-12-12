@props(['menuComponent','menuClass'])

<div class="{{ $menuClass }}">
    <x-dynamic-component :component="$menuComponent" href="{{ route('calendar') }}" :active="request()->routeIs('calendar')">
        <div class="flex flex-wrap justify-start lg:justify-center items-center gap-2 min-w-0">
            <x-lucide-calendar class="h-4 w-4 shrink-0"/>
            <span class="truncate">
                {{ __('Agenda') }}
            </span>
        </div>
    </x-dynamic-component>
</div>

@can('is-admin')
    <div class="{{ $menuClass }}">
        <x-dynamic-component :component="$menuComponent" href="{{ route('users.students-table') }}" :active="request()->routeIs('users.students-table', 'users.professors-table', 'users.coordinators-table')">
            <div class="flex flex-wrap justify-start lg:justify-center items-center gap-2 min-w-0">
                <x-lucide-user-round class="h-4 w-4 shrink-0"/>
                <span class="truncate">
                    {{ __('Usuários') }}
                </span>
            </div>
        </x-dynamic-component>
    </div>

    <div class="{{ $menuClass }}">
        <x-dynamic-component :component="$menuComponent" href="{{ route('courses-table') }}" :active="request()->routeIs('courses-table')">
            <div class="flex flex-wrap justify-start lg:justify-center items-center gap-2 min-w-0">
                <x-lucide-graduation-cap class="h-5 w-5 shrink-0"/>
                <span class="p-[2px] truncate">
                    {{ __('Cursos') }}
                </span>
            </div>
        </x-dynamic-component>
    </div>

    <div class="{{ $menuClass }}">
        <x-dynamic-component :component="$menuComponent" href="{{ route('groups-table') }}" :active="request()->routeIS('groups-table')">
            <div class="flex flex-wrap justify-start lg:justify-center items-center gap-2 min-w-0">
                <x-lucide-users class="h-4 w-4 shrink-0"/>
                <span class="truncate">
                    {{ __('Grupos') }}
                </span>
            </div>
        </x-dynamic-component>
    </div>
@endcan

<div class="{{ $menuClass }}">
    <x-dynamic-component :component="$menuComponent" href="{{ route('committees-table') }}" :active="request()->routeIS('committees-table')">
        <div class="flex flex-wrap justify-start lg:justify-center items-center gap-2 min-w-0">
            <x-lucide-file-badge class="h-4 w-4 shrink-0"/>
            <span class="truncate">
                {{ __('Bancas') }}
            </span>
        </div>
    </x-dynamic-component>
</div>

@can('is-admin')
    <div class="{{ $menuClass }}">
        <x-dynamic-component :component="$menuComponent" href="{{ route('evaluation.criteria-table') }}" :active="request()->routeIS('evaluation.criteria-table', 'evaluation.axis-table', 'evaluation.rubric-table')">
            <div class="flex flex-wrap justify-start lg:justify-center items-center gap-2 min-w-0">
                <x-lucide-clipboard-list class="h-4 w-4 shrink-0"/>
                <span class="truncate">
                    {{ __('Rubricas') }}
                </span>
            </div>
        </x-dynamic-component>
    </div>
    <div class="{{ $menuClass }}">
        <x-dynamic-component :component="$menuComponent" href="{{ route('papers-content') }}" :active="request()->routeIs('papers-content')">
            <div class="flex flex-wrap justify-start lg:justify-center items-center gap-2 min-w-0">
                <x-lucide-file-text class="h-4 w-4 shrink-0"/>
                <span class="truncate">
                    {{ __('Trabalhos') }}
                </span>
            </div>
        </x-dynamic-component>
    </div>
    <div class="hidden">
        <x-dynamic-component :component="$menuComponent" href="{{ route('papers-content') }}" :active="request()->routeIs('home')">
            <div class="flex flex-wrap justify-start lg:justify-center items-center gap-2 min-w-0">
                <x-lucide-import class="h-[1.15rem] w-[1.15rem] shrink-0"/>
                <span class="truncate">
                    {{ __('Importação') }}
                </span>
            </div>
        </x-dynamic-component>
    </div>
@endcan
