<button
    type="button"
    {{ $attributes->merge([
        'type' => 'button',
        'class' => 'flex items-center justify-center
                   text-red-500 dark:text-gray-200 hover:text-red-700
                   h-5 w-5 rounded-sm
                   bg-red-200 dark:bg-red-500 dark:hover:bg-red-600
                   transition-colors duration-150'
    ]) }}
    x-on:click="{!! $action !!}({!! $key !!})"
    title="Remover"
>
    <x-lucide-x class="h-4 w-4"/>
</button>
