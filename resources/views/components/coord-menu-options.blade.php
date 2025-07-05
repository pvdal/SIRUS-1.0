<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>
</div>

<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link href="{{ route('calendar') }}" :active="request()->routeIs('calendar')">
        {{ __('Calendar') }}
    </x-nav-link>
</div>
