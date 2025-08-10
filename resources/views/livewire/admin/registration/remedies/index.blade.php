@php use App\Models\Remedy; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Remedies')">
                <x-slot name="actions">
                    @can('create', Remedy::class)
                        <livewire:admin.registration.remedies.create @created="$refresh" />
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
                        <x-button.circle icon="pencil" wire:click="$dispatch('load::remedy', { 'remedy' : '{{ $row->id }}'})" />
                    @endcan
                    @can('delete', $row)
                        <livewire:admin.registration.remedies.delete :remedy="$row" :key="uniqid('', true)" @deleted="$refresh" />
                    @endcan
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:admin.registration.remedies.update @updated="$refresh" />
</div>
