@props(['enum'])

@php
    $items = [];

    foreach($enum::cases() as $option) {
        $items[] = [
            'id' => $option->value,
            'name' => $option->label(),
        ];
    }
@endphp
<div>
    <x-select.styled
        :options="$items"
        {{ $attributes }}
        select="label:name|value:id"
    />
</div>
