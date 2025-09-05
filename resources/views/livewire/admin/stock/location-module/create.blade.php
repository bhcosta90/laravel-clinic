<div>
    <x-button :text="__('Create New Module')" wire:click="$toggle('slide')" outline />

    <x-ui.action size="3xl" :title="__('Create New Module')">
        <form id="module-create" wire:submit="save" class="space-y-4">
            <x-admin.stock.location-module.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="module-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
