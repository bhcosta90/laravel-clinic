<div>
    @if($modal)
        <x-modal size="3xl" :title="__('Update Anamnesis Group: #:id', ['id' => $form->model?->id])" wire>
            <form id="agreement-update-{{ $form->model?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.registration.anamnesis-group.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="agreement-update-{{ $form->model?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-modal>
    @endif
</div>
