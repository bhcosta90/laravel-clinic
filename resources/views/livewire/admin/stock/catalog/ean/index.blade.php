@php use App\Models\Catalog; @endphp
<x-modal size="3xl"  wire>
    @can('create', Catalog::class)
        <livewire:admin.stock.catalog.ean.create @created="$refresh" />
    @endcan

    <x-table :headers="$this->headers" :$sort :rows="$this->rows" loading :quantity="[2, 5, 15, 25]">
        @interact('column_created_at', $row)
            <x-ui.created_at :date="$row->created_at" />
        @endinteract

        @interact('column_action', $row)
            <div class="flex gap-1 justify-end">
                @can('barcode', $row)
                    <x-button.circle color="secondary" icon="bars-3" wire:click="$dispatch('load::catalog::ean', { 'catalog' : '{{ $row->id }}'})" />
                @endcan
                @can('update', $row)
                    <x-button.circle icon="pencil" wire:click="$dispatch('load::catalog', { 'catalog' : '{{ $row->id }}'})" />
                @endcan
                @can('delete', $row)
                    <livewire:admin.stock.catalog.delete :catalog="$row" :key="uniqid('', true)" @deleted="$refresh" />
                @endcan
            </div>
        @endinteract
    </x-table>
    <livewire:admin.stock.catalog.update @updated="$refresh" />
</x-modal>
