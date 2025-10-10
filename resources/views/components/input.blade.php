@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-secondary-blue focus:ring-secondary-blue rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200 dark:placeholder-gray-300 transition duration-150 ease-in-out']) !!}>
