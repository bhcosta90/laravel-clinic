<div class="space-y-4">
    <x-input label="{{ __('Acronym') }} *" wire:model="form.acronym" required />
    <x-input type="number" min="0" max="4000000000" label="{{ __('Sequence') }} *" wire:model="form.sequence" required />
</div>
