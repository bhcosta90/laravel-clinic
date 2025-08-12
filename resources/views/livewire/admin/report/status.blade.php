@php use App\Enums\Models\Report\Status; @endphp

<div aria-live="polite">
    @if($report)
        @switch($report->status)
            @case(Status::Error)
                @if($min)
                    <span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800" title="@lang('Error')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-red-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8 4a1 1 0 100-2 1 1 0 000 2zm1-8a1 1 0 10-2 0v5a1 1 0 102 0V6z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-1">@lang('Error')</span>
                    </span>
                @else
                    <div role="alert" class="flex items-center gap-3 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-red-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8 4a1 1 0 100-2 1 1 0 000 2zm1-8a1 1 0 10-2 0v5a1 1 0 102 0V6z" clip-rule="evenodd" />
                        </svg>
                        <div class="text-sm">
                            <p class="font-medium">@lang('ReportSchedule resulted in a processing error')</p>
                            <p class="mt-1 text-red-600/80">@lang('Please try again or contact support if the problem persists.')</p>
                        </div>
                    </div>
                @endif
                @break

            @case(Status::Processing)
                @if($min)
                    <span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-800" title="@lang('Processing')" aria-busy="true">
                        <svg class="h-3.5 w-3.5 animate-spin text-amber-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <span class="ml-1">@lang('Processing')</span>
                    </span>
                @else
                    <div role="status" aria-busy="true" class="flex items-center gap-3 rounded-lg border border-amber-200 bg-amber-50 p-4 text-amber-800 shadow-sm">
                        <svg class="h-5 w-5 animate-spin text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        <div class="text-sm">
                            <p class="font-medium">@lang('Processing')</p>
                            <p class="mt-1 text-amber-700/80">@lang('Please wait while we generate your report.')</p>
                        </div>
                    </div>
                @endif
                @break

            @case(Status::Completed)
                @if($min)
                    <a href="{{ $report->file_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-800 hover:bg-emerald-200" title="@lang('Open report')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.172 7.707 8.879a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-1">@lang('Completed')</span>
                    </a>
                @else
                    <div role="status" class="flex items-center gap-3 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-emerald-800 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-emerald-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.707a1 1 0 00-1.414-1.414L9 10.172 7.707 8.879a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <div class="text-sm">
                            <p class="font-medium">@lang('Successful report')</p>
                            <p class="mt-1 text-emerald-700/80">
                                {!! __('Click :link to view the report.', [
                                    'link' => '<a href="'.e($report->file_url).'" target="_blank" rel="noopener noreferrer" class="font-semibold text-emerald-700 underline hover:text-emerald-900">'.__('here').'</a>'
                                ]) !!}
                            </p>
                        </div>
                    </div>
                @endif
                @break

            @default
                @if($min)
                    <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700" title="@lang('Pending')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM9 7a1 1 0 012 0v3a1 1 0 11-2 0V7zm1 6a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-1">@lang('Pending')</span>
                    </span>
                @else
                    <div role="status" class="flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4 text-slate-700 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-slate-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM9 7a1 1 0 012 0v3a1 1 0 11-2 0V7zm1 6a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                        </svg>
                        <div class="text-sm">
                            <p class="font-medium">@lang('Wait, we are processing the report')</p>
                            <p class="mt-1 text-slate-600/80">@lang('This may take a few moments.')</p>
                        </div>
                    </div>
                @endif
        @endswitch
    @endif
</div>
