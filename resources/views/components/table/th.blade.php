@props([
    'colspan' => null,
    'rowspan' => null,
])

<th {{ $attributes->merge([
        'class' => 'px-4 py-2 text-center text-gray-700 dark:text-gray-300 transition',
        'colspan' => $colspan,
        'rowspan' => $rowspan,
    ]) }}>
    {{ $slot }}
</th>
