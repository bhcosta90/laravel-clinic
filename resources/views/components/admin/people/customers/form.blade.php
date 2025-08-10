<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="form.name" required />

    <div class="grid grid-cols-2 gap-x-3">
        <x-ui.date label="{{ __('Birthday') }} *" wire:model="form.birthday" required :format="__('MMMM DD, YYYY')" />
        <x-input label="{{ __('Document') }} *" wire:model="form.document" required />
    </div>

</div>
