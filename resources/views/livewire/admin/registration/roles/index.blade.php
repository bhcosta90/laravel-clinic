@php use App\Models\Role; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Roles')">
                <x-slot name="actions">
                    @can('create', Role::class)
                        <livewire:admin.registration.roles.create @created="$refresh" />
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
                    @can('permissions', $row)
                        <x-button.circle icon="key" color='yellow' :href="route('admin.v1.registration.roles.permissions', $row)" />
                    @endcan
                    @can('update', $row)
                        <x-button.circle icon="pencil" wire:click="$dispatch('load::role', { 'role' : '{{ $row->id }}'})" />
                    @endcan
                    @can('delete', $row)
                        <livewire:admin.registration.roles.delete :role="$row" :key="uniqid('', true)" @deleted="$refresh" />
                    @endcan
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:admin.registration.roles.update @updated="$refresh" />
</div>
