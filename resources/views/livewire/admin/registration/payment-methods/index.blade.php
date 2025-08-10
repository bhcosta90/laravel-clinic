@php use App\Models\PaymentMethod; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Payments')">
                <x-slot name="actions">
                    @can('create', PaymentMethod::class)
                        <livewire:admin.registration.payment-methods.create @created="$refresh"/>
                    @endcan
                </x-slot>
            </x-ui.header>
        </x-slot:header>

        <x-table :headers="$this->headers" :$sort :rows="$this->rows" paginate simple-pagination filter loading
                 :quantity="[2, 5, 15, 25]">
            @interact('column_created_at', $row)
            {{ $row->created_at->diffForHumans() }}
            @endinteract

            @interact('column_action', $row)
            <div class="flex gap-1 justify-end">
                @can('update', $row)
                    <x-button.circle icon="pencil"
                                     wire:click="$dispatch('load::payment', { 'payment' : '{{ $row->id }}'})"/>
                @endcan
                @can('delete', $row)
                    <livewire:admin.registration.payment-methods.delete :payment="$row" :key="uniqid('', true)"
                                                                 @deleted="$refresh"/>
                @endcan
            </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:admin.registration.payment-methods.update @updated="$refresh"/>
</div>
