<div class="space-y-4">
    <div class="border-b-1 border-b-secondary-500 space-y-4 pb-4">
        <div class="grid grid-cols-2 space-x-3">
            <div>
                <x-input label="{{ __('Name') }} *" wire:model="form.name" required />
            </div>

            <x-select.styled
                :label="__('Role')"
                wire:model="form.role_id"
                :request="[
                    'url' => route('admin.v1.api.roles.search'),
                    'params' => ['field' => 'name'],
                ]"
                unfiltered
            />
        </div>

        <div class="grid grid-cols-2 space-x-3 items-center">
            <div>
                <x-toggle wire:model="form.is_employee" :label="__('Performs service') . '?'" />
            </div>
            <div class="flex gap-x-3">
                <x-number min="0" max="100" wire:model="form.commission" step="0.01" :label="__('Commission')" />
                <x-input wire:model="form.payment_data" :label="__('PaymentMethod data')" />
            </div>
        </div>
    </div>

    <div>
        <x-input label="{{ __('Email') }}" wire:model="form.email" />
    </div>

    <div class="grid grid-cols-2 gap-x-3">
        <div>
            <x-input label="{{ __('Cellphone') }}" wire:model="form.cellphone" />
        </div>

        <div>
            <x-input label="{{ __('Address') }}" wire:model="form.address" />
        </div>
    </div>

    <div class="grid grid-cols-2 gap-x-3">
        <div>
            <x-password :label="__('Password')"
                        :hint="$this->form->model?->id ? __('The password will only be updated if you set the value of this field') : null"
                        wire:model="form.password"
                        rules
                        generator
                        x-on:generate="$wire.set('password_confirmation', $event.detail.password)"
            />
        </div>

        <div>
            <x-password :label="__('Confirm Password')" wire:model="form.password_confirmation" rules />
        </div>
    </div>
</div>
