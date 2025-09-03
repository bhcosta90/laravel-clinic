<div>
    @if($modal)
        <x-modal size="3xl" :title="__('Update Module: #:id', ['id' => $form->model?->id])" wire>
            <form id="module-update-{{ $form->model?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.registration.frequencies.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="module-update-{{ $form->model?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-modal>
    @endif
</div>
