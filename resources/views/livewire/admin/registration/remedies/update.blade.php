<div>
    <x-modal size="3xl" :title="__('Update Remedy: #:id', ['id' => $remedy?->id])" wire>
        <form id="remedy-update-{{ $remedy?->id }}" wire:submit="save" class="space-y-4">
            <x-admin.registration.remedies.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="remedy-update-{{ $remedy?->id }}" loading="save">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
