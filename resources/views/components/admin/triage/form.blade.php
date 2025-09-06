@php
    $evaOptions = collect(range(0, 10))->map(fn ($i) => ['id' => $i, 'name' => (string) $i]);
@endphp

<div class="space-y-6">
    <!-- Patient and Risk -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-select.styled
            :label="__('Patient')"
            wire:model="form.customer_id"
            :request="[
                'url' => route('admin.v1.api.customer.search'),
            ]"
            class="w-full"
            required
        />

        <x-select.styled
            label="{{ __('Risk classification') }} *"
            wire:model="form.risk_classification"
            required
            :options="\App\Enums\Models\Triage\RiskClassification::options()"
            select="label:name|value:id"
            :placeholders="[
                'empty' => __('Select a Risk'),
            ]"
        />
    </div>

    <!-- Main complaint / description -->
    <x-input label="{{ __('Reason for search/main complaint') }} *" wire:model="form.description" required :placeholder="__('Describe the patient\'s complaint')" />

    <!-- Vitals -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        <x-input label="{{ __('PA (mmHg)') }}" wire:model="form.mmhg" />
        <x-input label="{{ __('FC (bpm)') }}" wire:model="form.bpm" />
        <x-input label="{{ __('FR (irpm)') }}" wire:model="form.irpm" />
        <x-input label="{{ __('Temperature (°C)') }}" wire:model="form.temperature" />
        <x-input label="{{ __('Saturation') . ' (%)' }}" wire:model="form.saturation" />
    </div>

    <!-- Medical history -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-input label="{{ __('Allergies') }}" wire:model="form.allergy" :placeholder="__('If you have any allergy')" />
        <x-input label="{{ __('Use of current medicines') }}" wire:model="form.current_medication" :placeholder="__('If you are using any medicines')" />
        <x-input label="{{ __('Disease History') }}" wire:model="form.history_diseases" />
        <x-input label="{{ __('Starting time of symptoms') }}" wire:model="form.time_symptom_onset" :placeholder="__('Ex: 3 days ago, there is a month, etc')" />
    </div>

    <x-input label="{{ __('Patient\'s general condition') }}" :placeholder="__('Ex: Alert, sleepy, unconscious')" wire:model="form.general_condition" />

    <!-- Pain scale (EVA) -->
    <x-select.styled
        :label="__('Scale of pain (EVA)')"
        wire:model="form.eva"
        :options="$evaOptions"
        select="label:name|value:id"
        :placeholders="[
                'empty' => __('Select') . '...',
            ]"
    />
    <x-message.required />
</div>
