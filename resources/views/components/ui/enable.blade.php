@php
    use App\Models\Enums\Shared\Status;
@endphp

<x-ui.select.enum {{ $attributes }} :enum="Status::class" select="label:name|value:id"/>
