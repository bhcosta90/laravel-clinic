@props([
    'title',
    'view',
    'report'
])
<x-modal size="4xl" :title="__($title)" wire>
    @if($this->slide)
        <div class="space-y-4">
            <form id="report-{{ $id = str()->uuid() }}" wire:submit="save" class="space-y-6">
                <div class="space-y-3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                        <x-ui.date wire:model="date_start" required :label="__('Start Date')" />
                        <x-ui.date wire:model="date_end" required :label="__('End Date')" />
                    </div>
                </div>

                {{ $slot }}
            </form>

            <livewire:admin.report.status :report="$this->report" wire:key="report-{{ $this->report?->id }}" />

            <livewire:admin.report.report :$view />
        </div>

        <x-slot:footer>
            <x-button type="submit" form="report-{{ $id }}">
                @lang('Generate PDF Report')
            </x-button>
        </x-slot:footer>
    @endif
</x-modal>
