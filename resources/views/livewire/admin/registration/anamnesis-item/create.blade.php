<div>
    <x-button :text="__('Create New Anamnesis Item')" wire:click="$toggle('modal')" outline />

    <x-ui.action size="3xl" :title="__('Create New Anamnesis Item')">
        <form id="anamnesisItem-create" wire:submit="save" class="space-y-4">
            <x-admin.registration.anamnesis-item.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="anamnesisItem-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
