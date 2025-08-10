@php use App\Models\Room; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Rooms')">
                <x-slot name="actions">
                    @can('create', Room::class)
                        <livewire:admin.registration.rooms.create @created="$refresh" />
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
                        <x-button.circle icon="pencil" wire:click="$dispatch('load::room', { 'room' : '{{ $row->id }}'})" />
                    @endcan
                    @can('delete', $row)
                        <livewire:admin.registration.rooms.delete :room="$row" :key="uniqid('', true)" @deleted="$refresh" />
                    @endcan
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:admin.registration.rooms.update @updated="$refresh" />
</div>
