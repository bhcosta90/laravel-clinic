<div>
    <x-button :text="__('Create New Remedy')" wire:click="$toggle('slide')" outline />

    <x-ui.action size="3xl" :title="__('Create New Remedy')">
        <form id="remedy-create" wire:submit="save" class="space-y-4">
            <x-admin.registration.remedies.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="remedy-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
