@php
    $text = when($t = $attributes->get('text'), fn() => __($t));
    $color = match(true){
        $attributes->has('secondary') => "secondary",
        default => "primary",
    };
@endphp

<x-button
    :$color
    :$text {{ $attributes }}
/>
