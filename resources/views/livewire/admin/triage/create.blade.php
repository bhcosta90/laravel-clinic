<div>
    <x-button :text="__('Create New Triage')" wire:click="$toggle('modal')" outline />

    <x-modal size="3xl" :title="__('Create New Triage')" wire>
        <form id="triage-create" wire:submit="save" class="space-y-4">
            <x-admin.triage.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="triage-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
