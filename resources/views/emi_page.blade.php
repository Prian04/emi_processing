<table>
    <thead>
        <tr>
            <th>Client ID</th>
            <!-- Dynamically add month columns here -->
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
                <!-- Dynamically add month values here -->
                @foreach($emi as $column => $value)
                    @if($column !== 'clientid' && $column !== 'id')
                        <td>{{ $value }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>