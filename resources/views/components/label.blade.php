@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-gray-300 transition duration-150 ease-in-out']) }}>
    {{ $value ?? $slot }}
</label>
