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
            background-color: #f2f2f2;
        }

        .particulars-table td:first-child {
            width: 50%;
        }

        .particulars-table td,
        .particulars-table th {
            border: none;
        }

        .particulars-table td,
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
                <img src="https://esavercargo.com/wp-content/uploads/2022/11/png-01-3.png" alt="Logo">
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
                <td>
                    <h1>Invoice #000001256</h1>
                </td>
                <td>
                    Invoice To: Company Name<br>
                    Invoice Date: 25-05-2024 02:45 AM
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td>
                    <b>Shipper</b> <br>
                    Moiz Chauhdry <br>
                    Arfa Tower, Model Town <br>
                    Lahore, Punjab, Pakistan
                </td>
                <td>
                    <b>Consignee</b> <br>
                    Moiz Chauhdry <br>
                    Arfa Tower, Model Town <br>
                    Lahore, Punjab, Pakistan
                </td>
            </tr>
        </table>

        <table class="particulars-table">
            <tr>
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