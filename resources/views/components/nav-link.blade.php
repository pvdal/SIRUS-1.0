@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-secondary-blue text-sm font-medium leading-5
            text-gray-900 dark:text-gray-200 focus:outline-none focus:border-secondary-blue
            transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5
            text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300
            dark:text-gray-400 dark:hover:text-gray-200 dark:hover:border-gray-600
            dark:focus:text-gray-100 dark:focus:border-gray-500
            transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
