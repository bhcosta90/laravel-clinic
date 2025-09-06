@php use App\Enums\Models\Transaction\Type; @endphp
<div class="space-y-8">
    <!-- Transaction Details Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20"
                 fill="currentColor">
                <path fill-rule="evenodd"
                      d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                      clip-rule="evenodd"/>
            </svg>
            {{ __(mb_ucfirst($this->type->value) . ' Details') }}
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-input
                label="{{ __('Description') }} *"
                wire:model="form.name"
                required
                class="w-full"
                hint="{{ __('Enter a clear description for this transaction') }}"
            />
            <x-ui.currency
                required
                wire:model="form.value"
                :label="__('Value') . ' *'"
                class="w-full"
            />
        </div>
    </div>

    <!-- Dates Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20"
                 fill="currentColor">
                <path fill-rule="evenodd"
                      d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                      clip-rule="evenodd"/>
            </svg>
            {{ __('Dates') }}
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-ui.date
                label="{{ __('Due date') }} *"
                wire:model="form.due_date"
                required
                :format="__('MMMM DD, YYYY')"
                class="w-full"
            />
            <x-ui.date
                label="{{ __('Payment date') }}"
                wire:model="form.payment_date"
                :format="__('MMMM DD, YYYY')"
                class="w-full"
            />
        </div>
    </div>

    <!-- Related Entities Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700"
         x-data="{ type: '{{ $this->type->value }}' }">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20"
                 fill="currentColor">
                <path
                    d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
            </svg>
            {{ __('Related Information') }}
        </h3>
        <div
            class="grid grid-cols-1 gap-6"
            :class="type === 'expense' ? 'md:grid-cols-2' : 'md:grid-cols-3'"
        >
            @if($this->type === Type::Incomes)
                <x-select.styled
                    :label="__('Patient')"
                    wire:model="form.customer_id"
                    :request="[
                        'url' => route('admin.v1.api.customer.search'),
                    ]"
                    class="w-full"
                />

                <x-select.styled
                    :label="__('Agreement')"
                    wire:model="form.agreement_id"
                    :request="[
                        'url' => route('admin.v1.api.agreement.search'),
                    ]"
                    class="w-full"
                />
            @endif

            @if($this->type === Type::Expenses)
                <x-select.employee
                    wire:model="form.user_id"
                />
            @endif
            <x-select.styled
                :label="__('Payment Method') . ' *'"
                wire:model="form.payment_method_id"
                :request="[
                    'url' => route('admin.v1.api.payment-method.search'),
                ]"
                class="w-full"
                required
            />
        </div>
    </div>

    <!-- Additional Information Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 border border-gray-200 dark:border-gray-700">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" viewBox="0 0 20 20"
                 fill="currentColor">
                <path fill-rule="evenodd"
                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9a1 1 0 00-1-1z"
                      clip-rule="evenodd"/>
            </svg>
            {{ __('Additional Information') }}
        </h3>
        <x-input
            label="{{ __('Observation') }}"
            wire:model="form.description"
            class="w-full"
            textarea
            rows="3"
        />
    </div>
    <x-message.required />
</div>
