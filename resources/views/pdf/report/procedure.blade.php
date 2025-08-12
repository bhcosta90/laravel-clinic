<x-report-layout>
    <table class="table table-striped table-sm">
        <thead class="thead-dark">
        <tr>
            <th>@lang('Procedure')</th>
            <th>@lang('Value')</th>
            <th>@lang('Doctor')</th>
            <th>@lang('Patient')</th>
            <th>@lang('Date')</th>
            <th>@lang('Hour')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($result as $rs)
            <tr>
                <td>{{ $rs->procedure->name }}</td>
                <td>{{ numberFormat($rs->procedure->price) }}</td>
                <td>{{ $rs->user->name }}</td>
                <td>{{ $rs->customer->name }}</td>
                <td>{{ $rs->date->format('d/m/Y') }}</td>
                <td>{{ $rs->date->format('H:i') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-report-layout>
