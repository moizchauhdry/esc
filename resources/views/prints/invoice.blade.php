<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 14px
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .invoice-header span {
            font-size: 18px;
        }


        .invoice-header img {
            max-width: 200px;
            height: auto;
        }

        .invoice-info {
            width: 33.33%;
        }

        .invoice-info p {
            margin: 5px 0;
        }

        .invoice-info b {
            font-weight: bold;
        }

        .particulars-table {
            padding-top: 150px;
            border: none;
        }

        .particulars-table tr {
            border-bottom: 1px solid #f4f4f4;
        }

        .particulars-table td,
        .particulars-table th {
            border: none;
        }

        .particulars-table td,
        {
        padding: 4px;
        text-align: left;
        }

        .particulars-table th {
            padding: 8px;
            text-align: left;
        }


        .invoice_heading {
            font-size: 25px;
            color: #0D8FCC;
            margin: 0;
            margin-top: -15px;
        }

        .invoice-ref {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            margin-top: 140px;
        }

        .invoice-ref>div {
            width: 32%;
            margin: 0;
            padding: 0;
        }


        .invoice-pay {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            margin-top: 30px;
        }

        .invoice-pay>div {
            width: 33.33%;
        }

        .invoice-pay>div:first-child {
            width: 40%;
        }

        .invoice-last {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 160px;
        }

        .invoice-last>div:first-child {
            width: 40%;
        }

        .invoice-last>div:last-child {
            width: 60%;
        }

        .first-table-row {
            background: #0D8FCC;
            height: 35px;
        }

        .before-span {
            background: #000;
            height: 34px;
            width: 50px;
            transform: skew(20deg);
            position: absolute;
            left: -10px;
            top: 0;
            z-index: -1;
        }

        .footer {
            background: #000;
            height: 30px;
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            width: 100%;
        }

        .footer-first {
            background: #0D8FCC;
            height: 40px;
            width: 35%;
            z-index: 1;
            margin-top: -10px;
            position: relative;
        }

        .before-footer {
            background: #0D8FCC;
            height: 40px;
            width: 50px;
            transform: skew(20deg);
            position: absolute;
            right: -10px;
            top: 0;
            z-index: -1;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="invoice-header">
            <div style="float: left;">
                <img src="{{asset('images/invoice-logo.png')}}" alt="Logo"> <br>
                <div style="padding-left: 14px;"><span>Express Saver Cargo</span></div>
            </div>
            <div class="invoice-info" style="float: right;">
                <h2 class="invoice_heading">INVOICE</h2>
                <div style="font-size: 12px;margin-top:0px;">
                    <div>
                        <p style="float: left;"><b>INVOICE NO:</b></p>
                        <p style="float: right;"> 000{{$invoice->id}}</p>
                    </div>
                    <div style="margin-top: 20px;">
                        <p style="float: left;"><b>MAWB NO:</b></p>
                        <p style="float: right;">{{$invoice->mawb_no}}</p>
                    </div>
                    <div style="margin-top: 20px;">
                        <p style="float: left;"><b>CARRIER:</b></p>
                        <p style="float: right;">{{$invoice->getCarrier->carrier_name ?? ""}} - {{$invoice->getCarrier->carrier_code ?? ""}}</p>
                    </div>
                    <div style="margin-top: 20px;">
                        <p style="float: left;"><b>INVOICE TO:</b></p>
                        <p style="float: right;">{{$invoice->company->name ?? 'N/A'}}</p>
                    </div>
                    <div style="margin-top: 20px;">
                        <p style="float: left;"><b>DATE:</b></p>
                        <p style="float: right;">{{Carbon\Carbon::parse($invoice->created_at)->format('F d, Y')}}</p>
                    </div>
                    <hr style="background: #0795CD;border-color: #0795CD;margin-top: 30px;">
                </div>

            </div>
        </div>

        <div class="invoice-ref">
            <div style="float: left;">
                <p style="margin: 0;color: #0D8FCC;"><b>SHIPPER:</b></p>
                <h4 style="margin-top: 4px;font-size: 12px;">{{$shipper->name}}</h4>
                <div style="font-size: 12px;">
                    <p style="margin: 5px 0;">
                        {{$shipper->address_1}} <br>
                        {{$shipper->address_2}}
                    </p>
                    <p style="margin: 5px 0;">Phone: {{$shipper->phone}}</p>
                    {{-- <p style="margin: 5px 0;">Email: {{$shipper->email}}</p> --}}
                </div>

            </div>
            <div style="float: left;padding-left:15px;">
                <p style="margin: 0;color: #0D8FCC;"><b>CONSIGNEE:</b></p>
                <h4 style="margin-top: 4px;font-size: 12px;">{{$consignee->name}}</h4>
                <div style="font-size: 12px;">
                    <p style="margin: 5px 0;">
                        {{$consignee->address_1}} <br>
                        {{$consignee->address_2}}
                    </p>
                    <p style="margin: 5px 0;">Phone: {{$consignee->phone}}</p>
                    {{-- <p style="margin: 5px 0;">Email: {{$consignee->email}}</p> --}}
                </div>
            </div>
            <div style="float: left;padding-left:15px;">
                <p style="margin: 0;color: #0D8FCC;"><b>SHIPMENT:</b></p>
                {{-- <h4 style="margin: 0;font-size: 15px;">Moiz Chauhdry</h4> --}}
                <div style="font-size: 12px;">
                    <p style="margin: 5px 0;"><b>Commodity</b>: {{$invoice->commodity}}</p>
                    <p style="margin: 5px 0;"><b>Departure</b>: {{$invoice->sender}} | <b>Landing</b>:
                        {{$invoice->destination}}</p>
                    <p style="margin: 5px 0;"><b>Quantity</b>: {{$invoice->quantity}}</p>
                    <p style="margin: 5px 0;"><b>Weight (KGS)</b>: {{$invoice->weight}}</p>
                    <p style="margin: 5px 0;"><b>AFC Rate/KG</b>: {{$invoice->afc_rate}}</p>
                </div>
            </div>
        </div>

        <table class="particulars-table">
            <tr class="first-table-row" style="color:white; font-size:14px;">
                <th>NO.</th>
                <th>PARTICULARS</th>
                <th style="background:#000;position:relative;"><span class="before-span"></span>PRICE</th>
                <th style="background:#000;">QUANTITY</th>
                <th style="background:#000;">TOTAL</th>
            </tr>
            @foreach ($items as $item)
            <tr style="font-size:12px">
                <td>{{$loop->iteration}}.</td>
                <td>{{$item->particular}}</td>
                <td>PKR {{format_number($item->amount)}}</td>
                <td>{{$item->qty}}</td>
                <td>PKR {{format_number($item->total)}}</td>
            </tr>
            @endforeach
        </table>

        <div class="invoice-pay">
            {{-- <div style="float: left;margin: 0;">
                <h4 style="margin: 0;font-size: 16px;">Package Detail</h4>
                <div style="font-size: 12px;margin: 0;">
                    <div style="margin-top: 0px;">
                        <p style="float: left;"><b>Commodity:</b></p>
                        <p style="float: left;padding-left:120px;">{{$invoice->commodity}}</p>
                    </div>
                    <div style="margin-top: 20px;">
                        <p style="float: left;"><b>Quantity:</b></p>
                        <p style="float: left;padding-left:120px;">{{$invoice->quantity}}</p>
                    </div>
                    <div style="margin-top: 20px;">
                        <p style="float: left;"><b>Weight (KGS):</b></p>
                        <p style="float: left;padding-left:120px;">{{$invoice->weight}}</p>
                    </div>
                    <div style="margin-top: 20px;">
                        <p style="float: left;"><b>AFC Rate/KG:</b></p>
                        <p style="float: left;padding-left:120px;">{{$invoice->total}}</p>
                    </div>
                </div>
            </div> --}}

            <div style="font-size: 12px;float: right;">
                <div style="margin-top: 10px;padding:0 10px;">
                    <p style="float: left;">Subtotal:</p>
                    <p style="float: right;"><b>PKR {{format_number($invoice->subtotal)}}</b></p>
                </div>
                {{-- <div style="margin-top: 20px;padding:0 10px;">
                    <p style="float: left;">Discount:</p>
                    <p style="float: right;"><b>00.00</b></p>
                </div> --}}
                {{-- <div style="margin-top: 20px;padding:0 10px;">
                    <p style="float: left;">Tax (10%):</p>
                    <p style="float: right;"><b>$100.00</b></p>
                </div> --}}
                <div
                    style="margin-top: 35px;background: #0D8FCC;color:#fff;height:40px;padding:0 10px;padding-bottom:5px;height:30px;">
                    <p style="float: left;"><b>Total:</b></p>
                    <p style="float: right;"><b>PKR {{format_number($invoice->total)}}</b></p>
                </div>
            </div>

            <div style="float: left;font-size: 12px;margin: 0;text-align:center;">
                <div>
                    <h4 style="margin-top:20px;margin-bottom:5px;"><b></b> </h4>
                    <img style="max-width:140px" src="" alt="signature">
                    <hr style="max-width:140px;border-color: gray;background:gray;">
                </div>
                <p style="font-size: 12px;margin-bottom: 5px"><b>Name & Signature</b></p>
                <p style="margin: 0">Account Manager</p>
            </div>

        </div>

        <div class="invoice-last">
            <div style="float: left;margin: 0;">
                <h4 style="margin: 0;font-size: 15px;color: #0D8FCC;">Express Saver Cargo</h4>
                <div style="font-size: 12px;margin: 0;padding-right:50px;">
                    <div style="margin-top: 0px;">
                        <p style="float: left;background:#0D8FCC;border-radius:5px;height:25px;width:25px;"><img
                                style="height:25px;width:25px;"
                                src="{{asset('images/phone-icon.png')}}"
                                alt=""></p>
                        <p style="float: left;padding-left:40px;">+923214208852 <br> +923214487971</p>
                    </div>
                    <div style="margin-top: 40px;">
                        <p style="float: left;background:#0D8FCC;border-radius:5px;height:25px;width:25px;"><img
                                style="height:25px;width:25px;transform:scale(.6);"
                                src="{{asset('images/email-icon.png')}}" alt="">
                        </p>
                        <p style="float: left;padding-left:40px;">
                            hammad.ali@esavercargo.com <br>
                            habibur.haseeb@esavercargo.com
                        </p>
                    </div>
                    <div style="margin-top: 40px;">
                        <p style="float: left;background:#0D8FCC;border-radius:5px;height:25px;width:25px;"><img
                                style="height:25px;width:25px;transform:scale(.5);"
                                src="{{asset('images/location-icon.png')}}"
                                alt=""></p>
                        <p style="float: left;padding-left:40px;">
                            House #23 Basti Chiragh Shah Airport Road Lahore, Pakistan
                        </p>
                    </div>
                </div>
            </div>

            <div style="float: right;font-size: 12px;margin: 0;padding-left:50px;">
                <p style="font-size: 14px;"><b>Terms & Consitions:</b></p>
                Please Make Check Payable to <b>EXPRESS SAVER CARGO.</b> <br>
                <b>ONLINE TRANSFER :: EXPRESS SAVER CARGO</b> <br> <br>
                <b>A/C: 3397301000001395 :: FAYSAL BANK</b> <br>
                <b>A/C: PK08 SONE 0014 4200 1292 6128 :: SONARI BANK</b> <br>
                <b>A/C: PK06 MPBL 0431 0271 4012 6060 :: HABIB METRO</b> <br>
            </div>

        </div>

        <div class="footer">
            <div class="footer-first">
                <span class="before-footer"></span>
            </div>
        </div>
    </div>
</body>

</html>