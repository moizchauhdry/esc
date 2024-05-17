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
        

        .invoice-header img {
            max-width: 200px;
            height: auto;
        }

        .invoice-info p {
            margin: 5px 0;
        }

        .invoice-info b {
            font-weight: bold;
        }

        .particulars-table {
            padding-top: 130px;
            border: none;
        }
        .particulars-table tr{
            border-bottom: 1px solid #f4f4f4;
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

     
        .invoice_heading{
            font-size: 85px;
            color: #0D8FCC;
            margin: 0;
            margin-top: -15px;
        }
        .invoice-ref {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            margin-top: 180px;
        }
        
        
        .invoice-ref > div:last-child{
            width: 33.33%;
            margin: 0;
        }
        .invoice-pay {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            margin-top: 30px;
        }
        .invoice-pay > div{
            width: 33.33%;
        }
        .invoice-pay > div:first-child{
            width: 40%;
        }
        .invoice-last {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 160px;
        }
        .invoice-last > div:first-child {
            width: 40%;
        }
        .invoice-last > div:last-child {
            width: 60%;
        }
        .first-table-row{
            background: #0D8FCC;
            height: 35px;
        }
        .before-span{
            background: #000;
            height: 34px;
            width: 50px;
            transform: skew(20deg);
            position: absolute;
            left: -10px;
            top: 0;
            z-index: -1;
        }
        .footer{
            background: #000;
            height: 30px;
            position: absolute;
            bottom: -20px;
            left: 0;
            right: 0;
            width: 100%;
        }
        .footer-first{
            background: #0D8FCC;
            height: 40px;
            width: 35%;
            z-index: 1;
            margin-top: -10px;
            position: relative;
        }
        .before-footer{
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
                <img src="https://esavercargo.com/wp-content/uploads/2022/11/png-01-3.png" alt="Logo"> <br>
                <span>Express Saver Cargo</span>
            </div>
            <div class="invoice-info" style="float: right;">
                <h2 class="invoice_heading">INVOICE</h2>
                <div style="font-size: 12px;padding-left:70px;margin-top:-10px;">
                    <div><p style="float: left;"><b>Invoice Number:</b></p><p style="float: right;">#8627512</p></div>
                    <div style="margin-top: 20px;"><p style="float: left;"><b>Account No:</b></p><p style="float: right;">8627512 77567 8686</p></div>
                    <div style="margin-top: 20px;"><p style="float: left;"><b>Invoice Date:</b></p><p style="float: right;">April 05, 2024</p></div>
                    <hr style="background: #0795CD;border-color: #0795CD;margin-top: 30px;">
                </div>
                
            </div>
        </div>
        <div class="invoice-ref">
            <div style="float: left;">
                <p style="margin: 0;color: #0D8FCC;"><b>INVOICE TO:</b></p>
                <h4 style="margin: 0;font-size: 30px;">John Doe.</h4>
                <div style="font-size: 12px;">
                    <p style="margin: 5px 0;">Managing Director, Company ltd.</p>
                    <p style="margin: 5px 0;">Phone: +123 464 2863</p>
                    <p style="margin: 5px 0;">Email: example@gmail.com</p>
                </div>
            </div>
            <div style="float: left;padding-left:50px;">
                <p style="margin: 0;color: #0D8FCC;"><b>INVOICE TO:</b></p>
                <h4 style="margin: 0;font-size: 30px;">John Doe.</h4>
                <div style="font-size: 12px;">
                    <p style="margin: 5px 0;">Managing Director, Company ltd.</p>
                    <p style="margin: 5px 0;">Phone: +123 464 2863</p>
                    <p style="margin: 5px 0;">Email: example@gmail.com</p>
                </div>
            </div>
            <div style="float: left;padding-left:50px;">
                <p style="margin: 0;color: #0D8FCC;"><b>INVOICE TO:</b></p>
                <h4 style="margin: 0;font-size: 30px;">John Doe.</h4>
                <div style="font-size: 12px;">
                    <p style="margin: 5px 0;">Managing Director, Company ltd.</p>
                    <p style="margin: 5px 0;">Phone: +123 464 2863</p>
                    <p style="margin: 5px 0;">Email: example@gmail.com</p>
                </div>
            </div>
        </div>

        <table class="particulars-table">
            <tr class="first-table-row" style="color:white; font-size:14px;">
                <th>NO.</th>
                <th>PRODUCT DESCRIPTION</th>
                <th style="background:#000;position:relative;"><span class="before-span"></span>PRICE</th>
                <th style="background:#000;">QUANTITY</th>
                <th style="background:#000;">TOTAL</th>
            </tr>
            <tr style="font-size:12px">
                <td>01.</td>
                <td>Website Template Design</td>
                <td>$50</td>
                <td>2</td>
                <td>$100.00</td>
            </tr>
            <tr style="font-size:12px">
                <td>02.</td>
                <td>Website Template Design</td>
                <td>$50</td>
                <td>2</td>
                <td>$100.00</td>
            </tr>
            <tr style="font-size:12px">
                <td>03.</td>
                <td>Website Template Design</td>
                <td>$50</td>
                <td>2</td>
                <td>$100.00</td>
            </tr>
            <tr style="font-size:12px">
                <td>04.</td>
                <td>Website Template Design</td>
                <td>$50</td>
                <td>2</td>
                <td>$100.00</td>
            </tr>
            <tr style="font-size:12px">
                <td>05.</td>
                <td>Website Template Design</td>
                <td>$50</td>
                <td>2</td>
                <td>$100.00</td>
            </tr>
            <tr style="font-size:12px">
                <td>06.</td>
                <td>Website Template Design</td>
                <td>$50</td>
                <td>2</td>
                <td>$100.00</td>
            </tr>
            <tr style="font-size:12px">
                <td>07.</td>
                <td>Website Template Design</td>
                <td>$50</td>
                <td>2</td>
                <td>$100.00</td>
            </tr>
            
        </table>

        <div class="invoice-pay">
            <div style="float: left;margin: 0;">
                <h4 style="margin: 0;font-size: 16px;">Payment Method</h4>
                <div style="font-size: 12px;margin: 0;">
                    <div style="margin-top: 0px;"><p style="float: left;"><b>Account No:</b></p><p style="float: left;padding-left:120px;">8627512 77567 8686</p></div>
                    <div style="margin-top: 20px;"><p style="float: left;"><b>Account Name:</b></p><p style="float: left;padding-left:120px;">John Doe.</p></div>
                    <div style="margin-top: 20px;"><p style="float: left;"><b>Branch Name:</b></p><p style="float: left;padding-left:120px;">XYZ</p></div>
                </div>
            </div>
           
            <div style="font-size: 12px;float: right;">
                    <div style="margin-top: 10px;padding:0 10px;"><p style="float: left;">Subtotal:</p><p style="float: right;"><b>$1000.00</b></p></div>
                    <div style="margin-top: 20px;padding:0 10px;"><p style="float: left;">Discount:</p><p style="float: right;"><b>00.00</b></p></div>
                    <div style="margin-top: 20px;padding:0 10px;"><p style="float: left;">Tax (10%):</p><p style="float: right;"><b>$100.00</b></p></div>
                    <div style="margin-top: 35px;background: #0D8FCC;color:#fff;height:40px;padding:0 10px;padding-bottom:5px;height:30px;"><p style="float: left;"><b>Total:</b></p><p style="float: right;"><b>$1100.00</b></p></div>
                </div>

            <div style="float: right;font-size: 12px;margin: 0;text-align:center;">
                <div>
                        <!-- <h4 style="margin-top:50px;margin-bottom:5px;"><b>Waqas ali</b> </h4> -->
                        <img style="max-width:140px" src="https://flypakistan.s3.us-west-2.amazonaws.com/signature.jpg" alt="signature">
                    <hr style="max-width:140px;border-color: gray;background:gray;">
                </div>
                <p style="font-size: 12px;margin-bottom: 5px"><b>Your Name & Signature</b></p>
                <p style="margin: 0">Account Manager</p>
            </div>
            
        </div>

        <div class="invoice-last">
            <div style="float: left;margin: 0;">
                <h4 style="margin: 0;font-size: 15px;color: #0D8FCC;">Thanks You For Your Business</h4>
                <div style="font-size: 12px;margin: 0;padding-right:50px;">
                    <div style="margin-top: 0px;"><p style="float: left;background:#0D8FCC;border-radius:5px;height:25px;width:25px;"><img style="height:25px;width:25px;" src="https://flypakistan.s3.us-west-2.amazonaws.com/call-icon-removebg-preview.png" alt=""></p><p style="float: left;padding-left:40px;">+123 7567 8686</p></div>
                    <div style="margin-top: 30px;"><p style="float: left;background:#0D8FCC;border-radius:5px;height:25px;width:25px;"><img style="height:25px;width:25px;transform:scale(.6);" src="https://flypakistan.s3.us-west-2.amazonaws.com/email-removebg-preview.png" alt=""></p><p style="float: left;padding-left:40px;">example@gmail.com</p></div>
                    <div style="margin-top: 30px;"><p style="float: left;background:#0D8FCC;border-radius:5px;height:25px;width:25px;"><img style="height:25px;width:25px;transform:scale(.5);" src="https://flypakistan.s3.us-west-2.amazonaws.com/location-removebg-preview.png" alt=""></p><p style="float: left;padding-left:40px;">Your location here</p></div>
                </div>
            </div>
           
            <div style="float: right;font-size: 12px;margin: 0;padding-left:50px;">
                <p style="font-size: 14px;"><b>Terms & Consitions:</b></p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum eum perspiciatis quam soluta hic, veniam cumque minima eligendi quod nam possimus, odit aut dolores vel asperiores voluptates fugiat expedita sapiente.</p>
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