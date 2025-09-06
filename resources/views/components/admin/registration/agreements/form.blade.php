<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="form.name" required />
    <x-number min="0" max="100" wire:model="form.commission" step="0.01" :label="__('Commission') . ' *'" />
    <x-input wire:model="form.cellphone" :label="__('Phone') . ' *'" />
    <x-message.required />
</div>
