<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-transparent border border-green-600 rounded-md text-xs font-semibold text-green-600 uppercase tracking-widest hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-50 transition duration-150']) }}>
    {{ $slot }}
</button>
