<div class="space-y-4">
    <x-input label="{{ __('Acronym') }} *" wire:model="form.acro" required />
    <x-number min="1" wire:model="form.days" :label="__('Days') . ' *'" />
</div>
