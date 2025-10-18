<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-light border border-secondary text-secondary rounded-3 py-2 px-4 fw-semibold text-uppercase shadow-sm hover:bg-light focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 disabled:opacity-50 transition duration-150']) }}>
    {{ $slot }}
</button>