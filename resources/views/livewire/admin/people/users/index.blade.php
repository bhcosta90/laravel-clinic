@php use App\Models\User; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Users')">
                <x-slot name="actions">
                    @can('create', User::class)
                        <livewire:admin.people.users.create @created="$refresh" />
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

            @interact('column_created_at', $row)
                <x-ui.created_at :date="$row->created_at" />
            @endinteract

            @interact('column_action', $row)
                <div class="flex gap-1 justify-end">
                    @can('permissions', [$row, auth()->user()])
                        <x-button.circle icon="key" color='neutral' :href="route('admin.v1.people.users.permissions', $row->hash_code)" />
                    @endcan
                    @can('impersonate', [$row, auth()->user()])
                        <livewire:admin.people.users.impersonate :user="$row" :key="uniqid('', true)" @deleted="$refresh" />
                    @endcan
                    @can('update', [$row, auth()->user()])
                        <x-button.circle icon="pencil" wire:click="$dispatch('load::user', { 'user' : '{{ $row->id }}'})" />
                    @endcan
                    @can('delete', [$row, auth()->user()])
                        <livewire:admin.people.users.delete :user="$row" :key="uniqid('', true)" @deleted="$refresh" />
                    @endcan
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:admin.people.users.update @updated="$refresh" />
</div>
