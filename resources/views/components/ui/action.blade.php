<x-slide {{$attributes}} wire="slide">
    {{ $slot }}

    <x-slot:footer>
        {{ $footer }}
    </x-slot:footer>
</x-slide>
