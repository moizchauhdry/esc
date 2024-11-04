<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Export</title>
</head>

<body>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="width:50px;border: 1px solid black;"><strong>Sr #</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Invoice ID</strong></th>
                <th style="width:200px;border: 1px solid black;"><strong>Company</strong></th>
                <th style="width:130px;border: 1px solid black;"><strong>Carrier</strong></th>
                <th style="width:120px;border: 1px solid black;"><strong>AWB NO</strong></th>
                <th style="width:50px;border: 1px solid black;"><strong>Pieces</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Weight</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Sender</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Destination</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Invoice Total</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Due Carrier</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Net Rate</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Net Payable</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Net Total</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Invoice at</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
            <tr>
                <td style="border: 1px solid black; padding: 8px;">{{$loop->iteration}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->id}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->company->name}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->carrier}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->mawb_no}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->quantity}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->weight}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->sender}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->destination}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->total}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->due_carrier}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->net_rate}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->net_payable}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->net_total}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{dateFormat($invoice->invoice_at)}}</td>
            </tr>
            @endforeach

            <tr>
                <td colspan="9" style="text-align:right"><strong>GRAND TOTAL</strong></td>
                <td style="text-align:right"><strong>{{format_number($grand_total['invoice_amount_sum'])}}</strong></td>
                <td style="text-align:right"><strong>{{format_number($grand_total['due_carrier_sum'])}}</strong></td>
                <td style="text-align:right"><strong>{{format_number($grand_total['net_rate_sum'])}}</strong></td>
                <td style="text-align:right"><strong>{{format_number($grand_total['net_payable_sum'])}}</strong></td>
                <td style="text-align:right"><strong>{{format_number($grand_total['gross_profit_sum'])}}</strong></td>
            </tr>
        </tbody>
    </table>

</body>

</html>