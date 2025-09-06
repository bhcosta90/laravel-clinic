<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Catalog')">
                <x-slot name="actions">
                    <x-button type="submit" form="catalog-update-{{ $this->form->model->hash_code }}">
                        @lang('Save')
                    </x-button>
                </x-slot>
            </x-ui.header>
        </x-slot:header>

        <form id="catalog-update-{{ $this->form->model->hash_code }}" wire:submit="save" class="space-y-4">
            <x-admin.stock.catalog.form :updated="true" />
        </form>
    </x-card>
</div>
