<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="procedure.name" required />
    <div class="grid grid-cols-2 gap-x-3">
        <x-ui.currency label="{{ __('Price') }} *" wire:model="procedure.price" required />
        <x-input label="{{ __('Time') }} *" wire:model="procedure.time" required />
    </div>
    <x-input label="{{ __('Preparation') }}" wire:model="procedure.description" required />
    <div class="flex gap-x-4">
        <x-toggle wire:model="procedure.is_agreement" :label="__('Accepts health insurance') . '?'" />
        <x-toggle wire:model="procedure.is_exam" :label="__('Accepts exam') . '?'" />
    </div>
</div>
