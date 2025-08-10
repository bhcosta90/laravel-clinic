@php use App\Enums\Models\Report\Status; @endphp
<div>
    @if($report)
        @switch($report->status)
            @case(Status::Error)
                <div
                    class="bg-green-400 border-green-600 rounded p-3 text-center text-white-50 border-1 ">@lang('Report resulted in a processing error')</div>
                @break
            @case(Status::Processing)
                <div
                    class="bg-green-400 border-green-600 rounded p-3 text-center text-white-50 border-1 ">@lang('Processing')</div>
                @break
            @case(Status::Completed)
                <div
                    class="bg-green-400 border-green-600 rounded p-3 text-center text-white-50 border-1 ">@lang('Successful report. <a href=":link">Click here to see the report</a>', [
                        'link' => $report->file_url,
                    ])</div>
                @break
            @default
                <div
                    class="bg-green-400 border-green-600 rounded p-3 text-center text-white-50 border-1 ">@lang('Wait, we are processing the report')</div>
        @endswitch
    @endif
</div>
