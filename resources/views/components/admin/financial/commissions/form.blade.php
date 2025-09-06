<div class="space-y-3">
    <x-select.employee
        wire:model="form.user_id"
        required
    />

    <x-ui.currency label="{{ __('Value') }} *" wire:model="form.value" required />

    <!-- Dates Section -->
    <div class="mb-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">{{ __('Dates') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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

    <x-message.required />
</div>
