@props(['active'])

@php
$classes = ($active ?? false)
            ? 'd-inline-flex align-items-center px-2 border-bottom-2 border-primary text-sm fw-medium text-dark focus:outline-none focus:border-primary transition-all'
            : 'd-inline-flex align-items-center px-2 border-bottom-2 border-transparent text-sm fw-medium text-muted hover:text-body hover:border-light focus:outline-none focus:text-body focus:border-light transition-all';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
