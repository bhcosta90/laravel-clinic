<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="payment.name" required />
    <x-number min="0" max="100" wire:model="payment.tax" step="0.01" :label="__('Tax') . ' *'" />
</div>
