<div>
    @if($slide)
        <x-ui.action size="3xl" :title="__('Update Module: #:id', ['id' => $form->model?->hash_code])">
            <form id="module-update-{{ $form->model?->hash_code }}" wire:submit="save" class="space-y-4">
                <x-admin.stock.location-module.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="module-update-{{ $form->model?->hash_code }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
