<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-danger-orange border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-200 uppercase tracking-widest hover:bg-primary-orange active:bg-secondary-orange focus:outline-none focus:ring-2 focus:ring-secondary-orange focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
