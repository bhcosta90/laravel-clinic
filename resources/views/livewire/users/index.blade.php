<div>
    <x-card>
        <x-slot:header>
            <x-ui.card.header title="User report" subtitle="Manage and review all registered users">
                <x-slot name="actions">
                    <livewire:users.create @created="$refresh" />
                </x-slot>
            </x-ui.card.header>
        </x-slot:header>


        <x-table :$headers :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[2, 5, 15, 25]">
            @interact('column_created_at', $row)
            {{ $row->created_at->diffForHumans() }}
            @endinteract

            @interact('column_action', $row)
            <div class="flex gap-2 justify-end">
                <x-button.circle icon="key" color='neutral' :href="route('admin.permissions.sync-permission.index', ['type' => 'user', 'hash' => $row->hash_code])" />
                <x-button.circle icon="pencil" wire:click="$dispatch('load::user', { 'user' : '{{ $row->id }}'})" />
                <livewire:users.delete :user="$row" :key="uniqid('', true)" @deleted="$refresh" />
            </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:users.update @updated="$refresh" />
</div>
