<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-danger-orange border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-orange active:bg-secondary-orange focus:outline-none focus:ring-2 focus:ring-secondary-orange focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
