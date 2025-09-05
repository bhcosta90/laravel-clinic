<div>
    <x-button :text="__('Create New Anamnesis Group')" wire:click="$toggle('slide')" outline />

    <x-ui.action size="3xl" :title="__('Create New Anamnesis Group')">
        <form id="agreement-create" wire:submit="save" class="space-y-4">
            <x-admin.registration.anamnesis-group.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="agreement-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
