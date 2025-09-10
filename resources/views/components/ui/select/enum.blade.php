@props(['enum'])

@php
    $items = [];

    foreach($enum::cases() as $option) {
        $items[] = [
            'id' => $option->value,
            'name' => $option->label(),
        ];
    }

    $label = when($t = $attributes->get('label'), fn() => __($t));
    $placeholder = when($t = $attributes->get('placeholder'), fn() => __(trim($t)));
@endphp
<div>
    <x-select.styled
        :$label
        :$placeholder
        :options="$items"
        {{ $attributes->except(['label', 'placeholder']) }}
        select="label:name|value:id"
    />
</div>
