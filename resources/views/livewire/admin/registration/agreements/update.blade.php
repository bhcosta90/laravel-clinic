<div>
    @if($modal)
        <x-modal size="3xl" :title="__('Update Agreement: #:id', ['id' => $form->model])" wire>
            <form id="agreement-update" wire:submit="save" class="space-y-4">
                <x-admin.registration.agreements.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="agreement-update" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-modal>
    @endif
</div>
