@props(['label' => null])
<x-select.styled
    {{ $attributes }}
    :label="($label ?: __('Module'))  . ' ' . ($attributes->get('required') ? '*' : '')"
    :request="[
        'url' => route('admin.v1.api.location-module.search'),
    ]"
    class="w-full"
/>
