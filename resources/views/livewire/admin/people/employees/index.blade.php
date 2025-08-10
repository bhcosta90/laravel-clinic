@php use App\Models\User; @endphp
<div>
    <x-card>
        <x-slot:header>
            <x-ui.header :title="__('Employees')">
                <x-slot name="actions">
                    @can('createEmployee', User::class)
                        <livewire:admin.people.employees.create @created="$refresh" />
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
                <span class="text-gray-500 dark:text-dark-300 text-sm">{{ $row->created_at->diffForHumans() }}</span>
            @endinteract

            @interact('column_action', $row)
                <div class="flex gap-1 justify-end">
                    @can('updateEmployee', [$row, auth()->user()])
                        <x-button.circle icon="pencil" wire:click="$dispatch('load::employee', { 'employee' : '{{ $row->id }}'})" />
                    @endcan
                    @can('deleteEmployee', [$row, auth()->user()])
                        <livewire:admin.people.employees.delete :employee="$row" :key="uniqid('', true)" @deleted="$refresh" />
                    @endcan
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:admin.people.employees.update @updated="$refresh" />
</div>
