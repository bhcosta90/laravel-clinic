<div>
    <x-button :text="__('Create New Triage')" wire:click="$toggle('modal')" outline />

    <x-ui.action size="3xl" :title="__('Create New Triage')">
        <form id="triage-create" wire:submit="save" class="space-y-4">
            <x-admin.triage.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="triage-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
