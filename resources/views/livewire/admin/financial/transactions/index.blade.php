@php use App\Models\Transaction; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="mb_ucfirst($this->type->label())">
                <x-slot name="actions">
                    @can('create' . mb_ucfirst($this->type->value), Transaction::class)
                        <livewire:admin.financial.transactions.create @created="$refresh" :type="$this->type" />
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
                    @can('update' . mb_ucfirst($this->type->value), $row)
                        <x-button.circle icon="pencil" wire:click="$dispatch('load::transaction', { 'transaction' : '{{ $row->id }}'})" />
                    @endcan
                    @can('delete' . mb_ucfirst($this->type->value), $row)
                        <livewire:admin.financial.transactions.delete :transaction="$row" :key="uniqid('', true)" @deleted="$refresh" />
                    @endcan
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:admin.financial.transactions.update @updated="$refresh" :type="$this->type" />

</div>
