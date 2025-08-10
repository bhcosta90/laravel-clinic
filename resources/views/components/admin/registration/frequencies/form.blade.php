<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="frequency.name" required />
    <x-number min="1" wire:model="frequency.days" :label="__('Days') . ' *'" />
</div>
