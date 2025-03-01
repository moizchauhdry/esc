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
            padding: 3px;
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
                <th colspan="13" style="text-align: center; text-transform:uppercase">General Ledger | CURRENCY: PKR/RS</th>
            </tr>
            <tr>
                <th colspan="13" style="text-align: center; text-transform:uppercase; font-size:16px">
                    {{ $filters['company_name'] ?? 'EXPRESS SAVER CARGO' }} |
                    {{ $filters['month_name'] }} {{ $filters['year'] }}
                </th>
            </tr>

            <tr>
                <th>Date</th>
                <th>Airline</th>
                <th>Particulars</th>
                <th>Orig</th>
                <th>Dest</th>
                <th>AFC Rate</th>
                <th>Pieces</th>
                <th>Weight</th>
                <th>Invoice ID</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
                <th>D/C</th>
            </tr>

            @foreach ($ledgers as $ledger)
            <tr>
                <td style="width:70px">{{ dateFormat($ledger->ledger_at) }}</td>
                @if ($ledger->amount_type == 1)
                <td>{{ $ledger->invoice->carrier }}</td>
                <td style="width:90px">{{ $ledger->invoice->mawb_no }}</td>
                <td>{{ $ledger->invoice->sender }}</td>
                <td>{{ $ledger->invoice->destination }}</td>
                <td>{{ format_number($ledger->invoice->afc_rate) }}</td>
                <td>{{ $ledger->invoice->quantity }}</td>
                <td>{{ $ledger->invoice->weight }}</td>
                <td>{{ $ledger->invoice->id }}</td>
                @endif

                @if ($ledger->amount_type == 2 || $ledger->amount_type == 3)
                <td colspan="8">{{ $ledger->comments }}</td>
                @endif

                <td>{{ format_number($ledger->debit_amount) }}</td>
                <td>{{ format_number($ledger->credit_amount) }}</td>
                <td>{{ format_number($ledger->balance_amount) }}</td>
                <td>{{ $ledger->credit > 0 ? 'CR': 'DR' }}</td>
            </tr>
            @endforeach
            <tr>
                <th colspan="9" style="text-align: right">Total</th>
                <th>{{ format_number($balance['debit_total']) }}</th>
                <th>{{ format_number($balance['credit_total']) }}</th>
                <th colspan="2">{{ format_number($balance['balance_total']) }}</th>
            </tr>

        </table>
    </div>
</body>

</html>