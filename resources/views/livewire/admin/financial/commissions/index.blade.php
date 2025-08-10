@php use App\Models\Commission; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Commissions')">
                <x-slot name="actions">
                    @can('create', Commission::class)
                        <livewire:admin.financial.commissions.create @created="$refresh" />
                    @endcan
                </x-slot>
            </x-ui.header>
        </x-slot:header>

        <x-table :headers="$this->headers" :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[2, 5, 15, 25]">
            @interact('column_name', $row)
            <div class="font-bold">{{ $row->name }}</div>
            <div class="text-secondary-400 text-sm">
                {{ $row->hash_code }}
            </div>
            @endinteract

            @interact('column_value', $row)
            {{ numberFormat($row->value) }}
            @endinteract

            @interact('column_birthday', $row)
            {{ $row->birthday->locale(config('app.locale'))->isoFormat('LL') }}
            @endinteract

            @interact('column_created_at', $row)
                <span class="text-gray-500 dark:text-dark-300 text-sm">{{ $row->created_at->diffForHumans() }}</span>
            @endinteract

            @interact('column_action', $row)
                <div class="flex gap-1 justify-end">
                    @can('update', $row)
                        <x-button.circle icon="pencil" wire:click="$dispatch('load::commission', { 'commission' : '{{ $row->id }}'})" />
                    @endcan
                    @can('delete', $row)
                        <livewire:admin.financial.commissions.delete :commission="$row" :key="uniqid('', true)" @deleted="$refresh" />
                    @endcan
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:admin.financial.commissions.update @updated="$refresh" />
</div>
