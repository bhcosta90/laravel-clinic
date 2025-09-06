@php use App\Models\Catalog; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Catalogs')">
                <x-slot name="actions">
                    @can('create', Catalog::class)
                        <livewire:admin.stock.catalog.create @created="$refresh" />
                    @endcan
                </x-slot>
                <x-slot name="subtitle">
                    <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-500" viewBox="0 0 20 20" fill="currentColor"><path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm4 2a1 1 0 000 2h8a1 1 0 100-2H6z"/></svg>
                        {{ __('Manage your stock items. Use filters to find products by name or SKU.') }}
                    </div>
                </x-slot>
            </x-ui.header>
        </x-slot:header>

        <x-table :headers="$this->headers" :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[2, 5, 15, 25]">
            @interact('column_created_at', $row)
            <x-ui.created_at :date="$row->created_at" />
            @endinteract

            @interact('column_name', $row)
            <div class="font-medium text-gray-900 dark:text-gray-100">{{ $row->name }}</div>
            <div class="text-xs text-gray-500">SKU: {{ $row->sku_code }}</div>
            @endinteract

            @interact('column_action', $row)
            <div class="flex gap-1 justify-end">
                @can('update', $row)
                    <x-button.circle wire:navigate icon="pencil" href="{{ route('admin.v1.stock.catalog.update', $row->hash_code) }}" />
                @endcan
                @can('delete', $row)
                    <livewire:admin.stock.catalog.delete :catalog="$row" :key="uniqid('', true)" @deleted="$refresh" />
                @endcan
            </div>
            @endinteract
        </x-table>
    </x-card>
</div>
