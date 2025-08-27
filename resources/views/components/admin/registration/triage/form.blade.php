<div>
    <x-select.styled
        :label="__('Patient')"
        wire:model="appointment.customer_id"
        :request="[
                        'url' => route('admin.v1.api.customer.search'),
                    ]"
        class="w-full"
        required
    />
</div>
