<div>
    @can('executePayment', $appointment)
        <x-button.circle icon="credit-card" color="yellow" wire:click="$toggle('modal')" title="{{ __('Execute Payment') }}" wire:loading.attr="disabled" />
    @endcan

    <x-ui.action size="3xl" :title="__('Execute Payment')">
        <form id="appointment-create-{{ $idForm = (string) str()->uuid() }}" wire:submit="save" class="space-y-6">
            <!-- Payment Details -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-5 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9z" />
                    </svg>
                    {{ __('Payment data') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-select.styled
                        :label="__('Employee') . ' *'"
                        wire:model="user_id"
                        :request="[
                                'url' => route('admin.v1.api.user.search'),
                                'params' => ['(is_employee,=)' => true],
                            ]"
                        class="w-full"
                    />

                    <x-ui.currency
                        required
                        wire:model="value"
                        :label="__('Value') . ' *'"
                        class="w-full"
                    />
                </div>
            </div>

            <!-- Dates & Method -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-5 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Dates') }} & {{ __('Payment Method') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <x-ui.date
                        required
                        :label="__('Date of the Payment') . ' *'"
                        wire:model="date"
                        :format="__('MMMM DD, YYYY')"
                        class="w-full"
                    />

                    <x-select.styled
                        :placeholders="['default' => __('Agreement')]"
                        :label="__('Payment Method')"
                        wire:model="payment_method_id"
                        :request="[
                            'url' => route('admin.v1.api.payment-method.search'),
                        ]"
                        class="w-full"
                        required
                    />

                    <x-select.styled
                        :label="__('Agreement')"
                        wire:model="agreement_id"
                        :request="[
                                'url' => route('admin.v1.api.agreement.search'),
                            ]"
                        class="w-full"
                    />
                </div>
            </div>

            <!-- Additional Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-5 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Additional Information') }}
                </h3>
                <x-input
                    label="{{ __('Number of the Agreement') }}"
                    wire:model="description"
                    class="w-full"
                    textarea
                    rows="3"
                    hint="{{ __('Add any details such as agreement number or notes about this payment') }}"
                />
            </div>

            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ __('Required fields are marked with an asterisk (*)') }}
            </div>
        </form>

        <x-slot:footer>
            <x-button type="submit" form="appointment-create-{{ $idForm }}">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
