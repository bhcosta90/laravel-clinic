@php use Illuminate\Validation\ValidationException; @endphp
<div>
    @if($messageErrors && $messageErrors->count())
        <div class="mb-3">
            @foreach($messageErrors as $messageError)
                @php
                    $isValidation = $messageError->exception === ValidationException::class;
                    $createdAt = method_exists($messageError, 'getAttribute') ? ($messageError->getAttribute('created_at') ?? null) : ($messageError->created_at ?? null);
                @endphp

                <div class="rounded-lg border border-gray-200 bg-white/70 dark:bg-gray-900/40 shadow-sm">
                    <div class="flex items-start justify-between px-4 py-3">
                        <div class="flex items-start gap-3">
                            <div class="shrink-0">
                                @if($isValidation)
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-yellow-100 text-yellow-700 ring-1 ring-yellow-200">!</span>
                                @else
                                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-red-100 text-red-700 ring-1 ring-red-200">!</span>
                                @endif
                            </div>
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">
                                        @if($isValidation)
                                            {{ __('There were some problems with your input with code :code.', ['code' => $messageError->code]) }}
                                        @else
                                            {{ __('An unexpected error occurred with code :code.', ['code' => $messageError->code]) }}
                                        @endif
                                    </h3>
                                    @if(!empty($messageError->code))
                                        <span class="inline-flex items-center rounded-md bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-200">#{{ $messageError->code }}</span>
                                    @endif
                                </div>
                                @if(!empty($messageError->message))
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ $messageError->message }}</p>
                                @endif
                                @if($createdAt)
                                    <p class="mt-1 text-xs text-gray-400">{{ __('At') }}: {{ now()->localFormat() }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-gray-800"></div>

                    <div class="px-4 py-3">
                        @if($isValidation)
                            <details class="group">
                                <summary class="cursor-pointer select-none text-sm font-medium text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                    <span class="group-open:rotate-90 transition">›</span>
                                    {{ __('Details') }}
                                </summary>
                                <ul class="mt-3 list-disc list-inside text-sm text-gray-700 dark:text-gray-300">
                                    @foreach(($messageError->data ?? []) as $field => $fieldErrors)
                                        @foreach($fieldErrors as $error)
                                            <li>
                                                @if(!is_numeric($field))<span class="font-medium">{{ $field }}:</span>@endif
                                                {{ $error }}
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </details>
                        @else
                            <details class="group">
                                <summary class="cursor-pointer select-none text-sm font-medium text-gray-800 dark:text-gray-200 flex items-center gap-2">
                                    <span class="group-open:rotate-90 transition">›</span>
                                    {{ __('Technical details') }}
                                </summary>
                                <div class="mt-3 text-sm text-gray-700 dark:text-gray-300">
                                    @php $data = (array) ($messageError->data ?? []); @endphp
                                    @if(isset($data['file']) || isset($data['line']))
                                        <p class="mb-2"><span class="font-semibold">{{ __('Location') }}:</span> {{ $data['file'] ?? '—' }}@if(isset($data['line'])):{{ $data['line'] }}@endif</p>
                                    @endif
                                    @if(isset($data['previous']) && $data['previous'])
                                        <p class="mb-2"><span class="font-semibold">{{ __('Previous') }}:</span> {{ $data['previous'] }}</p>
                                    @endif
                                    @if(!empty($data))
                                        <pre class="mt-2 max-h-64 overflow-auto rounded bg-gray-50 p-3 text-xs text-gray-800 dark:bg-gray-800 dark:text-gray-100">{{ json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    @endif
                                </div>
                            </details>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
