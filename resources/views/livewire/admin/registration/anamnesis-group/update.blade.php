<div>
    @if($modal)
        <x-modal size="3xl" :title="__('Update Anamnesis Group: #:id', ['id' => $anamnesisGroup?->id])" wire>
            <form id="agreement-update-{{ $anamnesisGroup?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.registration.anamnesis-group.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="agreement-update-{{ $anamnesisGroup?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-modal>
    @endif
</div>
