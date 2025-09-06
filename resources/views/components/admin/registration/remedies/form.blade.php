<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="form.name" required />
    <x-input wire:model="form.quantity" :label="__('Quantity') . ''" :placeholder="__('1 bottle, 10 tablets, etc.')" />
    <x-input wire:model="form.description" :label="__('Form of use') . ''" />
    <x-message.required />
</div>
