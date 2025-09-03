<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="form.name" required />
    <x-number min="1" wire:model="form.days" :label="__('Days') . ' *'" />
</div>
