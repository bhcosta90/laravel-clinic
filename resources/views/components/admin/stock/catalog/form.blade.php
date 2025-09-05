@php use App\Enums\Models\Catalog; @endphp
<div class="space-y-4">
    <x-input label="{{ __('Name') }} *" wire:model="form.name" required />
    <x-ui.select.enum :label="__('Hazardous') . ' *'" wire:model="form.hazardous" required :enum="Catalog\Hazardous::class" />
    <x-ui.select.enum :label="__('Status') . ' *'" wire:model="form.status" required :enum="Catalog\Status::class" />
    <x-ui.select.enum :label="__('Tracking mode') . ' *'" wire:model="form.tracking_mode" required :enum="Catalog\TrackingMode::class" />
</div>
