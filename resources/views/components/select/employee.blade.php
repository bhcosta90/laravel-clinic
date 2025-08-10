@props(['label' => null])
<x-select.styled
    {{ $attributes }}
    :label="$label ?: __('Employee')"
    :request="[
                        'url' => route('admin.v1.api.user.search'),
                        'params' => ['(is_employee,=)' => true],
                    ]"
    class="w-full"
/>
