@php use App\Models\Customer; @endphp
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="flex justify-between gap-4 items-end">
            <div class="flex-1">
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
            <div>
                @can('create', Customer::class)
                    <x-button icon="plus" x-on:click="$dispatch('customer::open')" outline />
                @endcan
            </div>
        </div>

        <x-select.styled
            :label="__('Professional')"
            wire:model.live="dataAppointment.user_id"
            :request="[
                'url' => route('admin.v1.api.user.search'),
                'params' => [
                    '(is_employee,=)' => true
                ],
            ]"
            unfiltered
            class="w-full"
            required
        />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-ui.date
            wire:model="dataAppointment.date"
            :label="__('Date')"
            required
        />

        <x-select.procedure
            wire:model.live="appointment.procedure_id"
            required
        />

        <x-select.agreement
            wire:model.live="appointment.agreement_id"
        />
    </div>

    <x-toggle wire:model="appointment.is_return" :label="__('There return'). '?'" />

    <div class="grid grid-cols-2 gap-4">
        <x-input
            label="{{ __('Observation') }}"
            wire:model="appointment.description"
            class="w-full"
            textarea
            rows="3"
        />

        <x-input
            label="{{ __('Date withdrawal (if it is exam)') }}"
            wire:model="appointment.exam_withdrawal_date"
            class="w-full"
            textarea
            rows="2"
        />
    </div>

    <div class="border p-4 rounded-lg bg-gray-50">
        <h3 class="font-medium text-gray-700 mb-3">{{ __('Available Times') }}</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
            @foreach($this->times as $time)
            <label for="time-{{ $time }}" class="cursor-pointer">
                <div class="bg-white rounded border hover:border-primary-500 transition-colors px-6 py-3">
                    <x-radio
                        id="time-{{ $time }}"
                        wire:model="dataAppointment.time"
                        :label="$time"
                        :value="$time"
                        required
                        class="p-2 flex items-center justify-center"
                    />
                </div>
            </label>
            @endforeach
        </div>
    </div>
</div>
