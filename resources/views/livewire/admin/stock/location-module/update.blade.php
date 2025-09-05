<div>
    @if($modal)
        <x-ui.action size="3xl" :title="__('Update Module: #:id', ['id' => $form->model?->id])">
            <form id="module-update-{{ $form->model?->id }}" wire:submit="save" class="space-y-4">
                <x-admin.stock.location-module.form />
            </form>
            <x-slot:footer>
                <x-button type="submit" form="module-update-{{ $form->model?->id }}" loading="save">
                    @lang('Save')
                </x-button>
            </x-slot:footer>
        </x-ui.action>
    @endif
</div>
