<div>
    <x-button :text="__('Create New Location')" wire:click="$toggle('modal')" outline />

    <x-modal size="3xl" :title="__('Create New Location')" wire>
        <form id="location-create" wire:submit="save" class="space-y-4">
            <x-admin.stock.location.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="location-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
