<div>
    <x-button :text="__('Create New Frequency')" wire:click="$toggle('slide')" outline />

    <x-ui.action size="3xl" :title="__('Create New Frequency')">
        <form id="frequency-create" wire:submit="save" class="space-y-4">
            <x-admin.registration.frequencies.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="frequency-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
