@php use App\Models\Location; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Frequencies')">
                <x-slot name="actions">
                    @can('create', Location::class)
                        <livewire:admin.stock.location.create @created="$refresh" />
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
                    @can('update', $row)
                        <x-button.circle icon="pencil" wire:click="$dispatch('load::location', { 'location' : '{{ $row->id }}'})" />
                    @endcan
                    @can('delete', $row)
                        <livewire:admin.stock.location.delete :location="$row" :key="uniqid('', true)" @deleted="$refresh" />
                    @endcan
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:admin.stock.location.update @updated="$refresh" />
</div>
