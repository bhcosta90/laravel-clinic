<x-slide {{ $attributes }} wire>
    <div class="space-y-4">
        {{ $slot }}
    </div>

    <x-slot:footer>
        {{ $footer ?? null }}
    </x-slot:footer>
</x-slide>
