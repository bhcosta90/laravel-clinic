@php use App\Enums\Models\Packing\Level; @endphp
<div class="space-y-4">
    <x-ui.select.enum :enum="Level::class" label="{{ __('Level') }} *" wire:model="form.level" required />
    <x-ui.number label="{{ __('Quantity') }} *" wire:model="form.quantity" required />
    <x-ui.number label="{{ __('Weight') }} *" wire:model="form.weight" required />
    <x-ui.number label="{{ __('Length') }} *" wire:model="form.length" required />
    <x-ui.number label="{{ __('Width') }} *" wire:model="form.width" required />
    <x-ui.number label="{{ __('Height') }} *" wire:model="form.height" required />

    <x-message.required />
</div>
