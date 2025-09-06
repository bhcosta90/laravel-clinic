<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="form.name" required />
    <x-input label="{{ __('Description') }} *" wire:model="form.description" required />
    <x-message.required />
</div>
