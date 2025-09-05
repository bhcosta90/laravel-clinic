@php use App\Models\Transaction; @endphp
<x-ui.action :title="__('Send Receipt')">
    <form id="customer-create" wire:submit="save" class="space-y-6">
        <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-lg font-medium text-gray-800 mb-3">{{ __('Date Information') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-ui.date
                    wire:model="form.date_start"
                    :label="__('Start Date')"
                    class="bg-white"
                />
                <x-ui.date
                    wire:model="form.date_end"
                    :label="__('End Date')"
                    class="bg-white"
                />
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-lg font-medium text-gray-800 mb-3">{{ __('Payment Details') }}</h3>
            <div class="grid grid-cols-3 gap-4">
                <x-select.agreement
                    wire:model="form.agreement_id"
                    required
                />

                <x-select.styled
                    :label="__('Payment Method')"
                    wire:model="form.payment_method_id"
                    :request="[
                            'url' => route('admin.v1.api.payment-method.search'),
                        ]"
                    unfiltered
                    class="w-full bg-white"
                    required
                />

                <x-ui.currency
                    required
                    wire:model="form.value"
                    :label="__('Value')"
                    class="w-full bg-white"
                />
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200">
            <h3 class="text-lg font-medium text-gray-800 mb-3">{{ __('Additional Information') }}</h3>
            <x-input
                label="{{ __('Observation') }}"
                wire:model="form.description"
                class="w-full bg-white"
                textarea
                rows="3"
            />
        </div>
    </form>

    <x-slot:footer>
        <div class="flex justify-end">
            <x-button type="submit" form="customer-create" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md shadow-sm transition-colors">
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    @lang('Save')
                </span>
            </x-button>
        </div>
    </x-slot:footer>
</x-ui.action>
