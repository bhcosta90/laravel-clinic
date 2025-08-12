<x-select.styled
    :label="__('Agreements')"
    :request="[
        'url' => route('admin.v1.api.agreement.search'),
    ]"
    :placeholders="['default' => __('Particular')]"
    unfiltered
    class="w-full bg-white"
    {{ $attributes }}
/>
