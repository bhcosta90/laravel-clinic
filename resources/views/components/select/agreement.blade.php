@props(['isParticular' => false])

@php

$placeholders = [];

if(blank($isParticular)) {
    $placeholders['default'] = __('Particular');
}

@endphp

<x-select.styled
    :label="__('Agreements')"
    :request="[
        'url' => route('admin.v1.api.agreement.search'),
        'params' => [
            'is_particular' => $isParticular,
        ],
    ]"
    :$placeholders
    unfiltered
    class="w-full bg-white"
    {{ $attributes }}
/>
