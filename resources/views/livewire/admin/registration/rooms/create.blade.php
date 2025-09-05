<div>
    <x-button :text="__('Create New Room')" wire:click="$toggle('slide')" outline />

    <x-ui.action size="3xl" :title="__('Create New Room')">
        <form id="room-create" wire:submit="save" class="space-y-4">
            <x-admin.registration.rooms.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="room-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
