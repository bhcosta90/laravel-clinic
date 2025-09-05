<div>
    @if($modal)
        <x-ui.action size="3xl" :title="__('Update Employee: #:id', ['id' => $this->form->model?->id])">
            <form id="employee-update-{{ $this->form->model?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.people.employees.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="employee-update-{{ $this->form->model?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
