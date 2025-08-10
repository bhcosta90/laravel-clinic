<x-select.styled
    :label="__('Agreements')"
    :request="[
        'url' => route('admin.v1.api.agreement.search'),
    ]"
    unfiltered
    class="w-full bg-white"
    {{ $attributes }}
/>
