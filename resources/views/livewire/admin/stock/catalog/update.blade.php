<div class="space-y-3" x-data="{ tab: 'block-1' }">
    <!-- Navbar Tabs -->
    <nav class="border-b border-gray-200 dark:border-gray-700">
        <ul class="flex -mb-px text-sm font-medium">
            <li class="me-2">
                <button type="button"
                        @click="tab = 'block-1'"
                        :class="tab === 'block-1'
                            ? 'inline-block p-4 border-b-2 border-primary-600 text-primary-600 dark:border-primary-400 dark:text-primary-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500/60 dark:focus-visible:ring-primary-400/60 rounded-t'
                            : 'cursor-pointer inline-block p-4 border-b-2 border-transparent text-secondary-600 hover:text-secondary-800 hover:border-secondary-300 dark:text-secondary-300 dark:hover:text-secondary-100 dark:hover:border-secondary-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-secondary-500/40 dark:focus-visible:ring-secondary-400/40 rounded-t'">
                    {{ __('Catalog') }}
                </button>
            </li>
            <li class="me-2">
                <button type="button"
                        @click="tab = 'block-2'"
                        :class="tab === 'block-2'
                            ? 'inline-block p-4 border-b-2 border-primary-600 text-primary-600 dark:border-primary-400 dark:text-primary-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary-500/60 dark:focus-visible:ring-primary-400/60 rounded-t'
                            : 'cursor-pointer inline-block p-4 border-b-2 border-transparent text-secondary-600 hover:text-secondary-800 hover:border-secondary-300 dark:text-secondary-300 dark:hover:text-secondary-100 dark:hover:border-secondary-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-secondary-500/40 dark:focus-visible:ring-secondary-400/40 rounded-t'">
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
                <x-admin.stock.catalog.form />
            </form>
        </x-card>
    </div>

    <!-- Block 2 -->
    <div class="block-2" x-show="tab === 'block-2'" x-cloak>
        <livewire:admin.stock.packing.index :model="$this->form->model" />
    </div>
</div>
