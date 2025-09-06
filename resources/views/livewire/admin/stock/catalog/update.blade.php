<div class="space-y-3" x-data="{ tab: 'block-1' }">
    <!-- Navbar Tabs -->
    <nav class="border-b border-gray-200 dark:border-gray-700">
        <ul class="flex -mb-px text-sm font-medium">
            <li class="me-2">
                <button type="button"
                        @click="tab = 'block-1'"
                        :class="tab === 'block-1' ? 'inline-block p-4 border-b-2 border-blue-600 text-blue-600' : 'inline-block p-4 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300'">
                    {{ __('Catalog') }}
                </button>
            </li>
            <li class="me-2">
                <button type="button"
                        @click="tab = 'block-2'"
                        :class="tab === 'block-2' ? 'inline-block p-4 border-b-2 border-blue-600 text-blue-600' : 'inline-block p-4 border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300'">
                    {{ __('Packings') }}
                </button>
            </li>
        </ul>
    </nav>

    <!-- Block 1 -->
    <div class="block-1" x-show="tab === 'block-1'" x-cloak>
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

    <!-- Block 2 -->
    <div class="block-2" x-show="tab === 'block-2'" x-cloak>
        <livewire:admin.stock.packing.index :model="$this->form->model" />
    </div>
</div>
