<div>
    <x-button :text="__('Create New Appointment')" wire:click="$toggle('modal')" outline />

    <x-modal size="3xl" :title="__('Create New Appointment')" wire>
        <form id="appointment-create" wire:submit="save" class="space-y-4">
            <x-admin.appointments.appointments.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="appointment-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
