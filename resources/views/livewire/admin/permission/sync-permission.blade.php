@php use App\Models\Enums\Permission\Can; @endphp
<div x-data="{ activeParent: null }" class="space-y-6">
    <!-- User Information Section -->
    <x-card class="bg-white dark:bg-gray-700 shadow-md">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
            <div class="mb-4 md:mb-0">
                <h2 class="text-2xl font-bold text-primary-700 dark:text-primary-300">{{ __('Manage Permissions') }}: {{ $model->name }}</h2>
                @if(property_exists('email', $model))
                    <p class="text-secondary-600 dark:text-secondary-300">{{ __('Email') }}: {{ $model->email }}</p>
                @endif
                <p class="text-sm text-secondary-500 dark:text-secondary-400 mt-1">{{ __('Last updated') }}: {{ $model->updated_at->localFormat() }}</p>
            </div>
            <div class="flex space-x-3">
                <x-button wire:click="assignAllPermissions" color="primary" class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __('Select all permissions') }}
                </x-button>
            </div>
        </div>
    </x-card>

    <!-- Help Information -->
    <div class="bg-primary-50 dark:bg-primary-900 border-l-4 border-primary-500 p-4 mb-4 rounded-md">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-primary-500 dark:text-primary-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-primary-700 dark:text-primary-300">
                    {{ __('Permissions are grouped by module and entity. Check the boxes to grant specific access rights to this') }} @lang('user')
                </p>
            </div>
        </div>
    </div>

    <!-- Summary Section -->
    <x-card class="bg-white dark:bg-gray-700 shadow-md">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-medium text-secondary-700 dark:text-secondary-300">{{ __('Permission Summary') }}</h3>
                <p class="text-sm text-secondary-600 dark:text-secondary-300">{{ __('Total permissions granted') }}: {{ $model->permissions->count() }}</p>
            </div>
        </div>
    </x-card>

    <!-- Permissions with Sidebar Layout -->
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Sidebar -->
        <div class="w-full md:w-1/4 bg-white dark:bg-gray-700 shadow-md rounded-lg overflow-hidden">
            <div class="p-4 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
                <h3 class="font-medium text-secondary-700 dark:text-secondary-300">{{ __('Permission Groups') }}</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-600">
                @foreach($permissions as $parentName => $children)
                    <div
                        @click="activeParent = activeParent === '{{ $parentName }}' ? null : '{{ $parentName }}'"
                        class="p-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex justify-between items-center"
                        :class="{'bg-primary-50 dark:bg-primary-900 text-primary-700 dark:text-primary-300': activeParent === '{{ $parentName }}'}"
                    >
                        <div class="font-medium text-secondary-700 dark:text-secondary-300">{{ mb_ucfirst($parentName) }}</div>
                        <svg
                            :class="{'transform rotate-180': activeParent === '{{ $parentName }}'}"
                            class="w-5 h-5 transition-transform duration-200"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-full md:w-3/4">
            @foreach($permissions as $parentName => $children)
                <div x-show="activeParent === '{{ $parentName }}'" x-cloak>
                    <x-card class="space-y-4 bg-white dark:bg-gray-700 shadow-md">
                        <div class="flex justify-end mb-4">
                            <x-button outline sm wire:click="assignParentPermissions('{{ $parentName }}')" color="secondary" class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ __('Select all children') }}
                            </x-button>
                        </div>
                        @foreach($children as $childName => $actions)
                            @php $isSingle = $childName === '__single__'; @endphp

                            @unless($isSingle)
                                <div class="border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">
                                    <div class="flex items-center">
                                        <div class="font-medium text-xl text-secondary-700 dark:text-secondary-300">{{ mb_ucfirst($childName) }}</div>
                                        <div class="ml-2 text-sm text-secondary-500 dark:text-secondary-400">
                                            {{ Can::operation($childName) }}
                                        </div>
                                    </div>
                                </div>
                            @endunless

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-2 pl-4">
                                @foreach($actions as $action)
                                    <div class="bg-gray-50 dark:bg-gray-600 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-500 transition-colors">
                                        <div class="flex items-center">
                                            <x-checkbox
                                                id="permission-{{ $action['value'] }}"
                                                wire:click="togglePermission('{{ $action['value'] }}')"
                                                :checked="$this->hasPermission($action['value'])"
                                                class="h-5 w-5"
                                            />
                                            <label for="permission-{{ $action['value'] }}" class="ml-2 block">
                                                <span class="font-medium text-secondary-700 dark:text-secondary-300">{{ mb_ucfirst($action['name']) }}</span>
                                                <p class="text-sm text-secondary-500 dark:text-secondary-300 mt-1">
                                                    {{ Can::action($action['name']) }}
                                                </p>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </x-card>
                </div>
            @endforeach

            <!-- Empty state when no parent is selected -->
            <div x-show="activeParent === null" class="bg-white dark:bg-gray-700 shadow-md rounded-lg p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-secondary-400 dark:text-secondary-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-secondary-900 dark:text-secondary-300">{{ __('No permission group selected') }}</h3>
                <p class="mt-1 text-sm text-secondary-500 dark:text-secondary-300">{{ __('Select a permission group from the sidebar to view and manage permissions.') }}</p>
            </div>
        </div>
    </div>
</div>
