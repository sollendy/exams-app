@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'fw-medium text-sm text-success']) }}>
        {{ $status }}
    </div>
@endif
