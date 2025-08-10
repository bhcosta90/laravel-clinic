<div>
    <x-button :text="__('Create New Employee')" wire:click="$toggle('modal')" outline />

    <x-modal size="3xl" :title="__('Create New Employee')" wire>
        <form id="employee-create" wire:submit="save" class="space-y-4">
            <x-admin.people.employees.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="employee-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
