@php
    $label = when($t = $attributes->get('label'), fn() => __($t));
    $placeholder = when($t = $attributes->get('placeholder'), fn() => __(trim($t)));
@endphp

<x-input :$label :$placeholder {{ $attributes->except(['placeholder', 'label']) }} />
