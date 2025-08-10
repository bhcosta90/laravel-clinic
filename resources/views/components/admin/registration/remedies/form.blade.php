<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="remedy.name" required />
    <x-input wire:model="remedy.quantity" :label="__('Quantity') . ''" :placeholder="__('1 bottle, 10 tablets, etc.')" />
    <x-input wire:model="remedy.description" :label="__('Form of use') . ''" />
</div>
