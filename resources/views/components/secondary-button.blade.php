<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-secondary-blue border border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-secondary-blue focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
