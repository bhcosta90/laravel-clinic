@props(['report' => null])

@if($report && $report->status === null)
    <div class="bg-green-400 border-green-600 rounded p-3 text-center text-white-50 border-1 ">@lang('Wait, we are processing the report')</div>
@endif
