@php
    $collection = collect(range(0, 10));
@endphp

<div>
    <x-select.styled
        :label="__('Patient')"
        wire:model="form.customer_id"
        :request="[
            'url' => route('admin.v1.api.customer.search'),
        ]"
        class="w-full"
        required
    />

    <x-select.styled :label="__('Risk classification').  ' *'"
         wire:model="form.risk_classification"
         required
         :options="\App\Enums\Models\Triage\RiskClassification::options()"
         select="label:name|value:id"
         :placeholders="[
            'empty'   => __('Select a Risk'),
         ]"
    />
    <x-input label="{{ __('Reason for search/main complaint') }} *" wire:model="form.description" required/>

    <x-input label="{{ __('PA (mmHg)') }}" wire:model="form.mmhg" />

    <x-input label="{{ __('FC (bpm)') }}" wire:model="form.bpm" />

    <x-input label="{{ __('FR (irpm)') }}" wire:model="form.irpm" />

    <x-input label="{{ __('Temperature (°C)') }}" wire:model="form.temperature" />

    <x-input label="{{ __('Saturation') . '(%)' }}" wire:model="form.saturation" />

    <x-input label="{{ __('Allergies') }}" wire:model="form.allergy" />

    <x-input label="{{ __('Use of current medicines') }}" wire:model="form.current_medication" />

    <x-input label="{{ __('Disease History') }}" wire:model="form.history_diseases" />

    <x-input label="{{ __('Starting time of symptoms') }}" wire:model="form.time_symptom_onset" :placeholder="__('Ex: 3 days ago, there is a month, etc')" />

    <x-input label="{{ __('Patient\'s general condition') }}" wire:model="form.general_condition" />

    <x-input label="{{ __('Scale of pain') }}" wire:model="form.eva" />

    <x-select.styled :label="__('Scale of pain')" :options="$collection" select="label:name|value:id"
         :placeholders="[
            'empty'   => __('Select') . '...',
         ]"
    />
</div>
