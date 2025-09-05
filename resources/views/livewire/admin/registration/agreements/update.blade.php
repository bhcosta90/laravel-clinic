<div>
    @if($modal)
        <x-ui.action size="3xl" :title="__('Update Agreement: #:id', ['id' => $form->model->id])">
            <form id="agreement-update" wire:submit="save" class="space-y-4">
                <x-admin.registration.agreements.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="agreement-update" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
