<div>
    <x-button :text="__('Create New Role')" wire:click="$toggle('slide')" outline />

    <x-ui.action :title="__('Create New Role')">
        <form id="role-create" wire:submit="save" class="space-y-4">
            <x-select.styled :label="__('Role')" wire:model="role.nested_parent" :request="route('admin.v1.api.roles.search')" unfiltered />

            <div>
                <x-input label="{{ __('Name') }} *" x-ref="name" wire:model="role.name" required />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="role-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-ui.action>
</div>
