@props(['menuComponent','menuClass'])

<div class="{{ $menuClass }}">
    <x-dynamic-component :component="$menuComponent" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-dynamic-component>
</div>

<div class="{{ $menuClass }}">
    <x-dynamic-component :component="$menuComponent" href="{{ route('calendar') }}" :active="request()->routeIs('calendar')">
        {{ __('Agenda') }}
    </x-dynamic-component>
</div>

<div class="{{ $menuClass }}">
    <x-dynamic-component :component="$menuComponent" href="{{ route('users.students-table') }}" :active="request()->routeIs('users.students-table', 'users.professors-table', 'users.coordinators-table')">
        {{ __('Usuários') }}
    </x-dynamic-component>
</div>



