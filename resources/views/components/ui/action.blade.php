<x-slide {{$attributes}} wire="modal">
    {{ $slot }}

    <x-slot:footer>
        {{ $footer }}
    </x-slot:footer>
</x-slide>
