<div>
    @if($modal)
        <x-modal size="3xl" :title="__('Update Anamnesis Item: #:id', ['id' => $anamnesisItem?->id])" wire>
            <form id="anamnesisItem-update-{{ $anamnesisItem?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.registration.anamnesis-item.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="anamnesisItem-update-{{ $anamnesisItem?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-modal>
    @endif
</div>
