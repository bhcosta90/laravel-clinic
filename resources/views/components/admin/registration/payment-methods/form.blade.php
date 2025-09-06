<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="form.name" required />
    <x-number min="0" max="100" wire:model="form.tax" step="0.01" :label="__('Tax') . ' *'" />
    <x-message.required />
</div>
