@php use App\Models\Catalog; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Catalogs')">
                <x-slot name="subtitle">
                    <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" viewBox="0 0 20 20" fill="currentColor"><path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm4 2a1 1 0 000 2h8a1 1 0 100-2H6z"/></svg>
                        {{ __('Manage your stock items. Use filters to find products by name or SKU.') }}
                    </div>
                </x-slot>
                <x-slot name="actions">
                    @can('create', Catalog::class)
                        <livewire:admin.stock.catalog.create @created="$refresh" />
                    @endcan
                </x-slot>
            </x-ui.header>
        </x-slot:header>

        <div class="mb-3 flex items-center justify-between gap-2">
            <div class="text-xs text-gray-500 dark:text-gray-400">
                {{ __('Showing') }} {{ $this->rows->count() }} {{ __('of') }} {{ method_exists($this->rows, 'total') ? $this->rows->total() : $this->rows->count() }}
            </div>
        </div>

        <x-table :headers="$this->headers" :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[5, 15, 25, 50]">
            @interact('column_name', $row)
                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $row->name }}</div>
                <div class="text-xs text-gray-500">SKU: {{ $row->sku_code }}</div>
            @endinteract

            @interact('column_created_at', $row)
                <x-ui.created_at :date="$row->created_at" />
            @endinteract

            @interact('column_action', $row)
                <div class="flex gap-1 justify-end">
                    @can('update', $row)
                        <x-button.circle icon="pencil" title="{{ __('Edit') }}" wire:click="$dispatch('load::catalog', { 'catalog' : '{{ $row->id }}'})" />
                    @endcan
                    @can('delete', $row)
                        <livewire:admin.stock.catalog.delete :catalog="$row" :key="uniqid('', true)" @deleted="$refresh" />
                    @endcan
                </div>
            @endinteract

            @slot('empty')
                <div class="text-center py-8 text-sm text-gray-500">
                    <div class="flex flex-col items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path d="M2 4a2 2 0 012-2h9l5 5v9a2 2 0 01-2 2H4a2 2 0 01-2-2V4z"/></svg>
                        <div>{{ __('No items found for the applied filters.') }}</div>
                        @can('create', Catalog::class)
                            <div>
                                <livewire:admin.stock.catalog.create @created="$refresh" />
                            </div>
                        @endcan
                    </div>
                </div>
            @endslot
        </x-table>

        <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
            {{ __('Tip: Click the pencil icon to edit a product or use the filters above to refine your search.') }}
        </div>
    </x-card>

    <livewire:admin.stock.catalog.update @updated="$refresh" />
</div>
