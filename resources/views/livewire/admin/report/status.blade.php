@php use App\Enums\Models\Report\Status; @endphp
<div class="mt-4" aria-live="polite">
    @if($report)
        @switch($report->status)
            @case(Status::Error)
                <div role="alert" class="flex items-center gap-3 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-red-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8 4a1 1 0 100-2 1 1 0 000 2zm1-8a1 1 0 10-2 0v5a1 1 0 102 0V6z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-sm">
                        <p class="font-medium">@lang('ReportSchedule resulted in a processing error')</p>
                        <p class="mt-1 text-red-600/80">@lang('Please try again or contact support if the problem persists.')</p>
                    </div>
                </div>
                @break

            @case(Status::Processing)
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
                @break

            @case(Status::Completed)
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
                @break

            @default
                <div role="status" class="flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 p-4 text-slate-700 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0 text-slate-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM9 7a1 1 0 012 0v3a1 1 0 11-2 0V7zm1 6a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                    </svg>
                    <div class="text-sm">
                        <p class="font-medium">@lang('Wait, we are processing the report')</p>
                        <p class="mt-1 text-slate-600/80">@lang('This may take a few moments.')</p>
                    </div>
                </div>
        @endswitch
    @endif
</div>
