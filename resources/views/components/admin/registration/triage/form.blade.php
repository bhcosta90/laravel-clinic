@php
    $collection = collect(range(0, 10));
@endphp

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

    <x-select.styled :label="__('Risk classification')"
         :options="\App\Enums\Models\Triage\RiskClassification\RiskClassification::options()"
         select="label:name|value:id"
         :placeholders="[
            'empty'   => __('Select a Risk'),
         ]"
    />
    <x-input label="{{ __('Reason for search/main complaint') }} *" wire:model="form.description" required/>

    <x-input label="{{ __('PA (mmHg)') }}" wire:model="form.description" required/>

    <x-input label="{{ __('FC (bpm)') }}" wire:model="form.description" required/>

    <x-input label="{{ __('FR (irpm)') }}" wire:model="form.description" required/>

    <x-input label="{{ __('Temperature (°C)') }}" wire:model="form.description" required/>

    <x-input label="{{ __('Saturation') . '(%)' }}" wire:model="form.description" required/>

    <x-input label="{{ __('Allergies') }}" wire:model="form.description" required/>

    <x-input label="{{ __('Use of current medicines') }}" wire:model="form.description" required/>

    <x-input label="{{ __('Disease History') }}" wire:model="form.description" required/>

    <x-input label="{{ __('Starting time of symptoms') }}" wire:model="form.description" required/>

    <x-input label="{{ __('Patient\'s general condition') }}" wire:model="form.description" required/>

    <x-input label="{{ __('Scale of pain') }}" wire:model="form.description" required/>

    <x-select.styled :label="__('Scale of pain')" :options="$collection" select="label:name|value:id"
                     :placeholders="[
            'empty'   => __('Select') . '...',
         ]"
    />
</div>
