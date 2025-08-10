<div>
    <x-button :text="__('Create New Frequency')" wire:click="$toggle('modal')" outline />

    <x-modal size="3xl" :title="__('Create New Frequency')" wire>
        <form id="frequency-create" wire:submit="save" class="space-y-4">
            <x-admin.registration.frequencies.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="frequency-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
