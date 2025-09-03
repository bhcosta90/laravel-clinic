@props(['title', 'subtitle' => null])
<div class="border-b-4 border-primary-500">
    <div class="flex justify-between py-6 px-4 items-center bg-gradient-to-r from-primary-50 to-white dark:from-gray-700 dark:to-gray-800">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <div class="text-2xl font-bold text-primary-700 dark:text-primary-300" id="page-title">
                    @lang($title)
                </div>
                @if($subtitle)
                    <div class="mt-1 text-sm text-secondary-600 dark:text-secondary-300" id="page-subtitle" aria-live="polite">
                        @lang($subtitle)
                    </div>
                @endif
            </div>
        </div>
        @if(isset($actions))
            {{ $actions }}
        @endif
    </div>
</div>
