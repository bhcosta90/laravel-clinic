@props([
    'date'
])
<span class="text-gray-500 dark:text-dark-300 text-sm">{{ $date->diffForHumans() }}</span>
