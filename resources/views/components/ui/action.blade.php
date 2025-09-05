<x-slide {{$attributes}} wire="slide">
    {{ $slot }}

    <x-slot:footer>
        {{ $footer ?? null }}
    </x-slot:footer>
</x-slide>
