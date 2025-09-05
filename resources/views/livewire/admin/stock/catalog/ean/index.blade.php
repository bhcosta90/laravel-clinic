@php use App\Models\Ean; @endphp
<x-ui.action size="3xl">
    @if($catalog)
        <div class="space-y-3">
            @can('create', Ean::class)
                <div class="text-right">
                    <livewire:admin.stock.catalog.ean.create :$catalog @created="$refresh" />
                </div>
            @endcan

            <x-table :headers="$this->headers" :$sort :rows="$this->rows" loading :quantity="[2, 5, 15, 25]">
                @interact('column_created_at', $row)
                <x-ui.created_at :date="$row->created_at" />
                @endinteract

                @interact('column_unit_of_measure', $row)
                {{ $row->unit_of_measure->label() }}
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
                        <livewire:admin.stock.catalog.ean.delete :catalog="$row" :key="uniqid('', true)" @deleted="$refresh" />
                    @endcan
                </div>
                @endinteract
            </x-table>
        </div>
        <livewire:admin.stock.catalog.ean.update @updated="$refresh" />
    @endif
</x-ui.action>
