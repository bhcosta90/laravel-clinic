<div class="space-y-3">
    <x-admin.stock.catalog.nav-bar :code="$this->form->model->hash_code" />

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
            <x-admin.stock.catalog.form />
        </form>
    </x-card>

    <div class="block-2" x-show="tab === 'block-2'" x-cloak>
        <livewire:admin.stock.packing.index :model="$this->form->model" />
    </div>
</div>
