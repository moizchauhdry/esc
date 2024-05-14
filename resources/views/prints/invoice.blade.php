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

        .invoice-header img {
            max-width: 150px;
            height: auto;
        }

        .invoice-info p {
            margin: 5px 0;
        }

        .invoice-info b {
            font-weight: bold;
        }

        .particulars-table th {
            /* background-color: #f2f2f2; */
        }

        .particulars-table td:first-child {
            width: 50%;
        }

        .particulars-table td,
        .particulars-table th {
            border: none;
        }

        .particulars-table td,
        {
        padding: 12px;
        text-align: left;
        }

        .particulars-table th {
            padding: 8px;
            text-align: left;
        }

        .particulars-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .particulars-table tr:last-child {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="invoice-header">
            <div style="float: left;">
                <img src="https://esavercargo.com/wp-content/uploads/2022/11/png-01-3.png" alt="Logo"> <br>
                <span>Express Saver Cargo</span>
            </div>
            <div class="invoice-info" style="float: right;">
                <p><b>Express Saver Cargo</b></p>
                <div style="font-size: 12px;">
                    <p>Hammad Ali<br>+92 321 4208852<br>hammad.ali@esavercargo.com</p>
                    <p>Habibur Haseeb<br>+92 321 4487971<br>habibur.haseeb@esavercargo.com</p>
                </div>
            </div>
        </div>
        <table style="padding-top:120px">
            <tr>
                <td style="background-color: #0662ae; color:white; width:60%">
                    <h2>Invoice #202412</h2>
                </td>
                <td style="font-size:14px;font-weight:400">
                    Invoice To: Octalsol<br>
                    Invoice Date: 25-05-2024
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td style="font-size:14px; width:60%">
                    <b>Shipper</b> <br> <br>
                    Moiz Chauhdry <br>
                    Arfa Tower, Model Town <br>
                    Lahore, Punjab, Pakistan
                </td>
                <td rowspan="2">
                    <b>Carrier:</b> alpha <br>
                    <b>MAWB No:</b> alpha <br>
                    <b>Sender:</b> alpha <br>
                    <b>Destination:</b> alpha <br>

                    <b>Commodity:</b> alpha <br>
                    <b>Quantity:</b> alpha <br>
                    <b>Weight (KGS):</b> alpha <br>
                    <b>AFC Rate/KG:</b> alpha <br>
                </td>
            </tr>
            <tr>
                <td style="font-size:14px; width:60%">
                    <b>Consignee</b> <br> <br>
                    Moiz Chauhdry <br>
                    Arfa Tower, Model Town <br>
                    Lahore, Punjab, Pakistan
                </td>
            </tr>
        </table>

        <table class="particulars-table">
            <tr style="background-color: #0662ae; color:white; font-size:12px">
                <th>Particulars</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
            <tr>
                <td>Lorem, ipsum dolor.</td>
                <td>2</td>
                <td>100</td>
                <td>200</td>
            </tr>
            <tr>
                <td>Lorem, ipsum dolor.</td>
                <td>2</td>
                <td>100</td>
                <td>200</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: right">Grand Total</td>
                <td>400</td>
            </tr>
        </table>
    </div>
</body>

</html>