@php use App\Enums\Models\Ean\UnitOfMeasure; @endphp
<div>
    <x-input label="{{ __('EAN') }} *" wire:model="form.ean" required  />
    <x-ui.select.enum :label="__('Unit of measure') . ' *'" wire:model="form.unit_of_measure" required :enum="UnitOfMeasure::class" />
    <x-input type="number" label="{{ __('Gross weight') }} *" wire:model="form.gross_weight"  />
    <x-input type="number" label="{{ __('Net weight') }} *" wire:model="form.net_weight"  />
    <x-input type="number" label="{{ __('Volume') }} *" wire:model="form.net_weight"  />
</div>
