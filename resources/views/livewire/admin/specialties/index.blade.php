<div>
    <x-card>
        <x-slot:header>
            <x-ui.card.header title="Specialty report" subtitle="Manage and review all registered specialities">
                <x-slot name="actions">
                    <livewire:admin.specialties.form :created="true" @saved="$refresh" />
                </x-slot>
            </x-ui.card.header>
        </x-slot:header>

        <x-table :headers="$this->headers" :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[2, 5, 15, 25]" class="bg-secondary-50 border border-secondary-200">
            @interact('column_name', $row)
            {{ $row->name }}
            <div class="text-secondary-400">{{ $row->code }}</div>
            @endinteract

            @interact('column_created_at', $row)
            <span class="text-primary-700 font-medium">{{ $row->created_at->diffForHumans() }}</span>
            @endinteract

            @interact('column_action', $row)
            <div class="flex gap-2 justify-end">
                <x-ui.button.circle icon="pencil" wire:click="$dispatch('load::specialty::update', { 'specialty' : '{{ $row->id }}'})"/>
                <livewire:admin.specialties.delete :specialty="$row" :key="uniqid('', true)" @deleted="$refresh" />
            </div>
            @endinteract
        </x-table>
    </x-card>
</div>
