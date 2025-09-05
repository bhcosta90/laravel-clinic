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
            </x-ui.header>
        </x-slot:header>

        <x-table :headers="$this->headers" :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[2, 5, 15, 25]">
            @interact('column_created_at', $row)
                <x-ui.created_at :date="$row->created_at" />
            @endinteract

            @interact('column_action', $row)
                <div class="flex gap-1 justify-end">
                    @can('barcode', $row)
                        <x-button.circle color="secondary" icon="bars-3" href="{{ route('admin.v1.stock.catalog.id.barcodes', $row->hash_code) }}" />
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
    </x-card>

    <livewire:admin.stock.catalog.update @updated="$refresh" />
</div>
