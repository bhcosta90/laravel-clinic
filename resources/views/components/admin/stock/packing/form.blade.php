@php use App\Enums\Models\Packing\Level; @endphp
<div class="space-y-3">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <x-ui.select.enum :enum="Level::class" label="{{ __('Level') }} *" wire:model="form.level" required />
        <x-ui.number label="{{ __('Quantity') }} *" wire:model="form.quantity" min="0" step="1" :placeholder="__('Units per package')" required />
        <x-ui.number label="{{ __('Weight') }} (kg) *" wire:model="form.weight" min="0" step="0.01" :placeholder="__('e.g., 0.50')" required />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <x-ui.number label="{{ __('Length') }} (cm) *" wire:model="form.length" min="0" step="0.01" :placeholder="__('e.g., 10.0')" required />
        <x-ui.number label="{{ __('Width') }} (cm) *" wire:model="form.width" min="0" step="0.01" :placeholder="__('e.g., 5.0')" required />
        <x-ui.number label="{{ __('Height') }} (cm) *" wire:model="form.height" min="0" step="0.01" :placeholder="__('e.g., 2.0')" required />
        <div class="sm:col-span-3 text-xs text-gray-500 dark:text-gray-400">{{ __('Use consistent units. Dimensions are in centimeters and weight in kilograms.') }}</div>
    </div>

    <x-message.required />
</div>
