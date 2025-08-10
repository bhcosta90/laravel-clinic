<div>
    <x-modal size="3xl" :title="__('Update User: #:id', ['id' => $this->form->model?->id])" wire>
        <form id="user-update-{{ $this->form->model?->id }}" wire:submit="save" class="space-y-4">
            <x-admin.people.users.form />
        </form>
        <x-slot:footer>
            <x-button type="submit" form="user-update-{{ $this->form->model?->id }}" loading="save">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
