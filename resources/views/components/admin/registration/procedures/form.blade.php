<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="form.name" required />
    <div class="grid grid-cols-2 gap-x-3">
        <x-ui.currency label="{{ __('Price') }} *" wire:model="form.price" required />
        <x-input label="{{ __('Time') }} *" wire:model="form.time" required />
    </div>
    <x-input label="{{ __('Preparation') }}" wire:model="form.description" required />
    <div class="flex gap-x-4">
        <x-toggle wire:model="form.is_agreement" :label="__('Accepts health insurance') . '?'" />
        <x-toggle wire:model="form.is_exam" :label="__('Accepts exam') . '?'" />
    </div>
    <x-message.required />
</div>
