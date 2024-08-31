<table>
    <thead>
        <tr>
            <th>Client ID</th>
          
            @foreach($emiDetails->first() as $column => $value)
                @if($column !== 'clientid' && $column !== 'id')
                    <th>{{ $column }}</th>
                @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($emiDetails as $emi)
            <tr>
                <td>{{ $emi->clientid }}</td>
             
                @foreach($emi as $column => $value)
                    @if($column !== 'clientid' && $column !== 'id')
                        <td>{{ $value }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>