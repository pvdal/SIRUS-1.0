<div class="max-w-[2100px] mx-auto p-1 py-2 lg:px-2">
    <div {{ $attributes->merge([
        'class' => 'bg-white overflow-visible border-b border-gray-100 dark:border-gray-700 shadow-md rounded-lg dark:bg-gray-900 transition duration-150 ease-in-out'
    ]) }}>
        {{ $slot }}
    </div>
</div>
