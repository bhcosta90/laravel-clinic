<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="agreement.name" required />
    <x-number min="0" max="100" wire:model="agreement.commission" step="0.01" :label="__('Commission') . ' *'" />
    <x-input wire:model="agreement.cellphone" :label="__('Phone') . ' *'" />
</div>
