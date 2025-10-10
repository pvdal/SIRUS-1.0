<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-transparent border border-green-600 dark:border-green-400 rounded-md text-xs font-semibold text-green-600 dark:text-green-400 uppercase tracking-widest hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 disabled:opacity-50 transition duration-150']) }}>
    {{ $slot }}
</button>
