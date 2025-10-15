@props(['menuComponent','menuClass'])

<div class="{{ $menuClass }}">
    <x-dynamic-component :component="$menuComponent" href="{{ route('calendar') }}" :active="request()->routeIs('calendar')">
        {{ __('Agenda') }}
    </x-dynamic-component>
</div>

@can('is-admin')
    <div class="{{ $menuClass }}">
        <x-dynamic-component :component="$menuComponent" href="{{ route('users.students-table') }}" :active="request()->routeIs('users.students-table', 'users.professors-table', 'users.coordinators-table')">
            {{ __('Usuários') }}
        </x-dynamic-component>
    </div>

    <div class="{{ $menuClass }}">
        <x-dynamic-component :component="$menuComponent" href="{{ route('courses-table') }}" :active="request()->routeIs('courses-table')">
            {{ __('Cursos') }}
        </x-dynamic-component>
    </div>

    <div class="{{ $menuClass }}">
        <x-dynamic-component :component="$menuComponent" href="{{ route('groups-table') }}" :active="request()->routeIS('groups-table')">
            {{ __('Grupos') }}
        </x-dynamic-component>
    </div>
@endcan

<div class="{{ $menuClass }}">
    <x-dynamic-component :component="$menuComponent" href="{{ route('committees-table') }}" :active="request()->routeIS('committees-table')">
        {{ __('Bancas') }}
    </x-dynamic-component>
</div>

@can('is-admin')
    <div class="{{ $menuClass }}">
        <x-dynamic-component :component="$menuComponent" href="{{ route('evaluation.criteria-table') }}" :active="request()->routeIS('evaluations-table')">
            {{ __('Avaliações') }}
        </x-dynamic-component>
    </div>
@endcan
