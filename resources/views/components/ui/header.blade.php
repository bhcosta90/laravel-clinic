@props(['title'])
<div class="border-b-4 border-primary-500">
    <div class="flex justify-between py-6 px-4 items-center bg-gradient-to-r from-primary-50 to-white dark:from-gray-700 dark:to-gray-800">
        <div class="flex items-center justify-between">
            <div class="text-2xl flex-1 font-bold text-primary-700 dark:text-primary-300">
                @lang($title)
            </div>
        </div>
        @if(isset($actions))
            {{ $actions }}
        @endif
    </div>
</div>
