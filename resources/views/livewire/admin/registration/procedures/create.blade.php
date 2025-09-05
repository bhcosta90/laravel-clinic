<div>
    <x-button :text="__('Create New Procedure')" wire:click="$toggle('modal')" outline />

    <x-ui.action size="3xl" :title="__('Create New Procedure')">
        <form id="procedure-create" wire:submit="save" class="space-y-4">
            <x-admin.registration.procedures.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="procedure-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
