@php use App\Models\Customer; @endphp
<div>
    <x-card>
        <x-slot:header>
            <div class="flex justify-between items-center mb-4 px-4 pt-4">
                <div>
                    <h2 class="text-xl font-bold">{{ __('Patient Birthdays') }}</h2>
                    <div class="mb-2 text-sm text-gray-600">
                        @if($filter_type === 'daily')
                            {{ __('Showing patients with birthdays today') }} ({{ now()->format('d/m') }})
                        @else
                            {{ __('Showing patients with birthdays this month') }} ({{ now()->format('m/Y') }})
                        @endif
                    </div>
                </div>
                <div class="flex space-x-2">
                    <x-button
                        :variant="$filter_type === 'monthly' ? 'primary' : 'secondary'"
                        wire:click="setFilterType('monthly')"
                    >
                        {{ __('Monthly') }}
                    </x-button>
                    <x-button
                        :variant="$filter_type === 'daily' ? 'primary' : 'secondary'"
                        wire:click="setFilterType('daily')"
                    >
                        {{ __('Today') }}
                    </x-button>
                </div>
            </div>
        </x-slot:header>

        <x-table :headers="$this->headers" :$sort :rows="$this->rows" paginate simple-pagination filter loading :quantity="[2, 5, 15, 25]">
            @interact('column_name', $row)
            <div class="font-bold">{{ $row->name }}</div>
            <div class="text-secondary-400 text-sm">
                {{ $row->hash_code }}
            </div>
            @endinteract

            @interact('column_birthday', $row)
            {{ $row->birthday->locale(config('app.locale'))->isoFormat('LL') }}
            @endinteract

            @interact('column_created_at', $row)
            {{ $row->created_at->diffForHumans() }}
            @endinteract
        </x-table>
    </x-card>
</div>
