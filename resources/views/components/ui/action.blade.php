<x-slide {{$attributes}} wire="slide">
    <div class="text-left">
        {{ $slot }}
    </div>

    <x-slot:footer>
        {{ $footer ?? null }}
    </x-slot:footer>
</x-slide>
