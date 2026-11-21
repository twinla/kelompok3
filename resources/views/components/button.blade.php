@props([
    'href' => null,
    'variant' => 'primary',
    'type' => 'button',
    'size' => 'md',
])
@php
    $classes = 'tp-button tp-button-' . $variant . ' tp-button-' . $size;
@endphp
@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
