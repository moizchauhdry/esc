<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saudia Cargo Invoice</title>
</head>

<body>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <td colspan="5" style="border: 1px solid black; padding: 2px; font-size:20px">
                <strong>{{isset($invoices[0]->getCarrier->carrier_name) ? $invoices[0]->getCarrier->carrier_name : ""}}</strong>
            </td>
            <td colspan="2" style="text-align: center; border: 1px solid black;">
                {{-- @if (isset($invoices[0]->carrier_id))
                <img src="{{ asset('images/saudi.jpg') }}" alt="Saudia Logo" style="height: 20px; float: right;">
                @endif --}}
            </td>
            <td colspan="1" style="text-align: center; border: 1px solid black;"></td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th colspan="2" style="border: 1px solid black; padding: 8px;"><strong>Name of Agent:</strong></th>
            <td colspan="6" style="border: 1px solid black; padding: 8px;">Express saver Cargo</td>
        </tr>
        <tr>
            <th colspan="2" style="border: 1px solid black; padding: 8px;"><strong>Period:</strong></th>
            <td colspan="6" style="border: 1px solid black; padding: 8px;">{{$filter['from']}} to {{$filter['to']}}</td>
        </tr>
    </table>

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="width:50px;border: 1px solid black;"><strong>Sr #</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Airway Bill No.</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Pieces</strong></th>
                <th style="width:130px;border: 1px solid black;"><strong>Chargeable <br> Weight</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Destination</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Due Carrier</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Net Rate</strong></th>
                <th style="width:100px;border: 1px solid black;"><strong>Net Payable</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
            <tr>
                <td style="border: 1px solid black; padding: 8px;">{{$loop->iteration}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->mawb_no}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->quantity}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{format_number($invoice->weight)}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{$invoice->destination}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{format_number($invoice->due_carrier)}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{format_number($invoice->net_rate)}}</td>
                <td style="border: 1px solid black; padding: 8px;">{{format_number($invoice->net_payable)}}</td>
            </tr>
            @endforeach

            @for ($i = $invoices->count()+1; $i <= 10; $i++) <tr>
                <td style="border: 1px solid black; padding: 8px;">{{ $i }}</td>
                <td style="border: 1px solid black; padding: 8px;"></td>
                <td style="border: 1px solid black; padding: 8px;"></td>
                <td style="border: 1px solid black; padding: 8px;"></td>
                <td style="border: 1px solid black; padding: 8px;"></td>
                <td style="border: 1px solid black; padding: 8px;"></td>
                <td style="border: 1px solid black; padding: 8px;"></td>
                <td style="border: 1px solid black; padding: 8px;"></td>
                </tr>
                @endfor
                <tr>
                    <td colspan="3" style="border: 1px solid black; padding: 8px;"><strong>TOTAL</strong></td>
                    <td style="border: 1px solid black; padding: 8px;"><strong>{{format_number($invoices->sum('weight'))}}</strong></td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black; padding: 8px;"><strong>{{format_number($invoices->sum('due_carrier'))}}</strong></td>
                    <td style="border: 1px solid black;"></td>
                    <td style="border: 1px solid black; padding: 8px;"><strong>{{format_number($invoices->sum('net_payable'))}}</strong></td>
                </tr>
        </tbody>
    </table>

    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <tr>
            <td colspan="8" style="border: none; text-align: right; padding-top: 20px;">

            </td>
        </tr>
        <tr>
            <td colspan="8" style="border: none; text-align: right; padding-top: 20px;">
                <strong>Agent Authorized Stamp and Signature</strong>
            </td>
        </tr>
    </table>


</body>

</html>