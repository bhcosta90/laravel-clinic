<div>
    <x-button :text="__('Create New Agreement')" wire:click="$toggle('modal')" outline />

    <x-ui.action size="3xl" :title="__('Create New Agreement')">
        <form id="agreement-create" wire:submit="save" class="space-y-4">
            <x-admin.registration.agreements.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="agreement-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
