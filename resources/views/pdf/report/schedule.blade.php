<table>
    <tbody>
    @foreach($result as $rs)
        <tr>
            <td>{{ $rs->id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
