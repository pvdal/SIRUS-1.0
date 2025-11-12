<td {{ $attributes->merge([
        'class' => 'px-4 py-2 zz font-light text-center text-gray-700 dark:text-gray-300 border-gray-300 transition duration-150 ease-in-out'
    ]) }}>
    {{ $slot }}
</td>
