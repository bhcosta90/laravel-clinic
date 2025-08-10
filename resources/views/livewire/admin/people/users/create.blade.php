<div>
    <x-button :text="__('Create New User')" wire:click="$toggle('modal')" outline />

    <x-modal size="3xl" :title="__('Create New User')" wire>
        <form id="user-create" wire:submit="save" class="space-y-4">
            <x-admin.people.users.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="user-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
