@php use App\Models\AnamnesisItem; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Anamnesis Item')">
                <x-slot name="actions">
                    @can('create', AnamnesisItem::class)
                        <livewire:admin.registration.anamnesis-item.create @created="$refresh" />
                    @endcan
                </x-slot>
            </x-ui.header>
        </x-slot:header>

        <x-table :headers="$this->headers" :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[2, 5, 15, 25]">
            @interact('column_created_at', $row)
                <span class="text-gray-500 dark:text-dark-300 text-sm">{{ $row->created_at->diffForHumans() }}</span>
            @endinteract

            @interact('column_action', $row)
                <div class="flex gap-1 justify-end">
                    @can('update', $row)
                        <x-button.circle icon="pencil" wire:click="$dispatch('load::anamnesisItem', { 'anamnesisItem' : '{{ $row->id }}'})" />
                    @endcan
                    @can('delete', $row)
                        <livewire:admin.registration.anamnesis-item.delete :anamnesisItem="$row" :key="uniqid('', true)" @deleted="$refresh" />
                    @endcan
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:admin.registration.anamnesis-item.update @updated="$refresh" />
</div>
