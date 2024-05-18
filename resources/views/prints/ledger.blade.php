<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ledger</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size: 12px
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>
    <div>
        <table>
            <tr>
                <th colspan="12" style="text-align: center">EXPRESS SAVER CARGO</th>
            </tr>
            <tr>
                <th colspan="12" style="text-align: center">{{$filters['company_name'] ?? ''}} CURR: PKR/RS</th>
            </tr>
            <tr>
                <th colspan="12" style="text-align: center">General Ledger From {{$filters['from']}} to
                    {{$filters['to']}}</th>
            </tr>
            <tr>
                <th>Date</th>
                <th>Airline</th>
                <th>Particulars</th>
                <th>Orig</th>
                <th>Dest</th>
                <th>Pieces</th>
                <th>Weight</th>
                <th>Invoice ID</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
                <th>D/C</th>
            </tr>

            @foreach ($invoices as $invoice)
            <tr>
                <td>{{ $invoice->created_at }}</td>
                <td>{{ $invoice->carrier }}</td>
                <td>{{ $invoice->mawb_no }}</td>
                <td>{{ $invoice->sender }}</td>
                <td>{{ $invoice->destination }}</td>
                <td>{{ $invoice->quantity }}</td>
                <td>{{ $invoice->weight }}</td>
                <td>{{ $invoice->id }}</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>DR</td>
            </tr>
            @endforeach


        </table>
    </div>
</body>

</html>