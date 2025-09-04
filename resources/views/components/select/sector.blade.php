<x-select.styled
    :label="__('Sector') . ' ' . ($attributes->get('required') ? '*' : '')"
    :request="[
        'url' => route('admin.v1.api.sector.search'),
    ]"
    unfiltered
    class="w-full"
    {{ $attributes }}
/>
