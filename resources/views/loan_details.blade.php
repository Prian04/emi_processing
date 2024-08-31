<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EMI Processing</title>
</head>
<body>
<table>
    <thead>
        <tr>
            <th>Client ID</th>
            <th>Number of Payments</th>
            <th>First Payment Date</th>
            <th>Last Payment Date</th>
            <th>Loan Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($loanDetails as $detail)
            <tr>
                <td>{{ $detail->clientid }}</td>
                <td>{{ $detail->num_of_payment }}</td>
                <td>{{ $detail->first_payment_date }}</td>
                <td>{{ $detail->last_payment_date }}</td>
                <td>{{ $detail->loan_amount }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<button id="process-data">Process Data</button>
<script>
    document.getElementById('process-data').addEventListener('click', function() {
        fetch("{{ route('process_emi_data') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            }
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  // Redirect to the provided URL
                  window.location.href = data.redirect_url;
              }
          });
    });
</script>
</body>
</html>