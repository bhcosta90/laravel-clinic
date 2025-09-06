@props(['code'])
<nav class="border-b border-gray-200 dark:border-gray-700">
    <ul class="flex -mb-px text-sm font-medium">
        <li class="me-2">
            <x-link wire:navigate href="{{ route('admin.v1.stock.catalog.update', $code) }}"
                @class([
                    'inline-block p-4 border-b-2 rounded-t focus:outline-none',
                    request()->routeIs('admin.v1.stock.catalog.update')
                        ? 'border-primary-600 text-primary-600 dark:border-primary-400 dark:text-primary-400 focus-visible:ring-2 focus-visible:ring-primary-500/60 dark:focus-visible:ring-primary-400/60'
                        : 'border-transparent text-secondary-600 hover:text-secondary-800 hover:border-secondary-300 dark:text-secondary-300 dark:hover:text-secondary-100 dark:hover:border-secondary-600 focus-visible:ring-2 focus-visible:ring-secondary-500/40 dark:focus-visible:ring-secondary-400/40'
                ])
            >
                {{ __('Catalog') }}
            </x-link>
        </li>
        <li class="me-2">
            <x-link wire:navigate href="{{ route('admin.v1.stock.catalog.packing', $code) }}"
                @class([
                    'inline-block p-4 border-b-2 rounded-t focus:outline-none',
                    request()->routeIs('admin.v1.stock.catalog.packing')
                        ? 'border-primary-600 text-primary-600 dark:border-primary-400 dark:text-primary-400 focus-visible:ring-2 focus-visible:ring-primary-500/60 dark:focus-visible:ring-primary-400/60'
                        : 'border-transparent text-secondary-600 hover:text-secondary-800 hover:border-secondary-300 dark:text-secondary-300 dark:hover:text-secondary-100 dark:hover:border-secondary-600 focus-visible:ring-2 focus-visible:ring-secondary-500/40 dark:focus-visible:ring-secondary-400/40'
                ])
            >
                {{ __('Packings') }}
            </x-link>
        </li>
    </ul>
</nav>
