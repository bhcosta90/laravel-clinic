<x-select.styled
    :label="__('Procedure')"
    :request="[
                'url' => route('admin.v1.api.procedure.search'),
            ]"
    unfiltered
    class="w-full"
    {{ $attributes }}
/>
