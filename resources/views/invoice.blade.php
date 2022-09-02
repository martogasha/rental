<title>{{$customer->lease->customer->name}} - Invoice</title>
<div class="card-body">
    <div id="invoiceholder">
        <div id="invoice" class="effect2">

            <div id="invoice-top">
                <div class="title">
                    <h1>Invoice #<span class="invoiceVal invoice_num">023</span></h1>
                </div><!--End Title-->
            </div><!--End InvoiceTop-->



            <div id="invoice-mid">
                <div id="message">
                    <h2>Hello {{$customer->lease->customer->name}},</h2>
                </div>
                <div class="clearfix">
                    @if($pay)
                        <div class="container" style="text-align: center;background-color:green">
                            <h4 style="color: white">PAID</h4>
                        </div>
                    @else
                        <div class="container" style="text-align: center;background-color:red">
                            <h4 style="color: white">UNPAID</h4>
                        </div>
                    @endif
                    <div class="col-left">
                        <div class="clientlogo"><img src="https://cdn3.iconfinder.com/data/icons/daily-sales/512/Sale-card-address-512.png" alt="Sup" /></div>
                        <div class="clientinfo">
                            <h2 id="supplier">Rental Company</h2>
                            <p><span id="address">P.O BOX 3380-0100</span><br><span id="city">Kikuyu</span><br><span id="country">IT</span> - <span id="zip">12062</span><br><span id="tax_num">555-555-5555</span><br></p>
                        </div>
                    </div>
                    <div class="col-right">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td><span>Invoice Total</span><label id="invoice_total">Ksh {{$total}}</label></td>
                            </tr>
                            <tr>
                                <td><span>Payment Method</span><label id="payment_term">Mpesa</label></td>
                            </tr>
                            <tr><td colspan="2"><span>Date</span>:<label id="note">{{$customer->date}}</label></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!--End Invoice Mid-->

            <div id="invoice-bot">

                <div id="table">
                    <table class="table-main">
                        <thead>
                        <tr class="tabletitle">
                            <th>Description</th>
                            <th style="text-align: right">Invoice Category</th>
                            <th style="text-align: right">Tenant Name</th>
                            <th style="text-align: right">Unit Price</th>
                            <th>Amount</th>
                            <th></th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        @foreach($invoices as $invoice)
                        <tr class="list-item">
                            <td data-label="Description" class="tableitem">{{$invoice->invoice->lease->house->number}}, {{$invoice->invoice->lease->house->name}}, {{$invoice->invoice->lease->house->property->name}}</td>
                            <td data-label="Description" class="tableitem">{{$invoice->type}}</td>
                            <td data-label="Description" class="tableitem">{{$invoice->invoice->lease->customer->name}}</td>
                            <td data-label="Unit Price" class="tableitem">{{$invoice->unit_price}}</td>
                            <td data-label="Tax Amount" class="tableitem">Ksh {{$invoice->amount}}</td>
                            <td></td>
                            <td data-label="AWT" class="tableitem">Ksh {{$invoice->amount}}</td>
                        </tr>
                        @endforeach
                        <tr class="list-item total-row" style="font-size: 20px">
                            <th colspan="4" class="tableitem">Grand Total</th>
                            <td data-label="Grand Total" class="tableitem">Ksh {{$total}}</td>
                        </tr>
                    </table>
                    <br>
                    <table class="table-main">
                        <thead>
                        <tr class="tabletitle">
                            <th>Transaction Date</th>
                            <th style="text-align: right">Ref No</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Bank Details</th>
                        </tr>
                        </thead>
                        @foreach($payments as $payment)
                                <tr class="list-item">
                                    <td data-label="Description" class="tableitem">{{$payment->transaction->date}}</td>
                                    <td data-label="Unit Price" class="tableitem">{{$payment->transaction->ref}}</td>
                                    <td data-label="Taxable Amount" class="tableitem">{{$payment->transaction->name}}</td>
                                    <td data-label="Tax Code" class="tableitem">{{$payment->transaction->amount}}</td>
                                    <td data-label="Tax Amount" class="tableitem">{{$payment->transaction->payment_method}}</td>
                                    <td data-label="Tax Amount" class="tableitem">{{$payment->transaction->bank_type}}</td>
                                </tr>
                        @endforeach
                    </table>
                </div><!--End Table-->

            </div><!--End InvoiceBot-->
            <footer>
                <div id="legalcopy" class="clearfix">
                    <p class="col-right">Reach Us
                        <span class="email"><a href="mailto:supplier.portal@almonature.com">rental.iconztech.com</a></span>
                    </p>
                </div>
            </footer>
        </div><!--End Invoice-->

    </div><!-- End Invoice Holder-->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@600&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Padauk&display=swap');
        [data-theme="dark"] {
            --primary-color: #121212;
            --secondary-color: #2B2B2B;
            --main-font: 'Montserrat', sans-serif;
            --text-color: white;
        }

        body{
            background-color: var(--secondary-color);
        }

        .container{
            display: flex;
            flex-direction: column;
            width: 200px;
            margin: 0 auto;
            background-color: var(--primary-color);
            padding: 10px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.4);
            border-radius: 5px;
        }

        h4{
            font-family: var(--main-font);
            text-align: center;
            padding: 10px;
            color: var(--text-color);

        }

        h5{
            font-family: 'Padauk', sans-serif;
            text-align: center;
            font-size: 17px;
            opacity: 0.5;
            color: var(--text-color);

        }

        input{
            width: 300px;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border-style: none;
            background-color: var(--secondary-color);
            font-size: 10px;
            font-weight: 600;
            color: var(--text-color);
        }

        .messages{
            font-family: var(--main-font);
            color: var(--text-color);
        }

        /* display: inline-block will help us to avoid the text from  */
        .message-item span{
            display: inline-block;
            padding:10px;
            background-color: var(--secondary-color);
            border-radius: 10px;
        }

        .submit{
            padding: 8px;
            border-radius: 5px;
            font-family: var(--main-font);
            font-size: 15px;
            color: white;
            background-color: #3636C9;
            border-style: none;
        }

        .theme-switch-wrapper {
            display: flex;
            align-items: center;

        }

        .theme-switch {
            display: inline-block;
            height: 34px;
            position: relative;
            width: 60px;
        }

        .theme-switch input {
            display:none;
        }

        .slider {
            background-color: #c7c786;
            bottom: 0;
            cursor: pointer;
            left: 0;
            position: absolute;
            right: 0;
            top: 0;
            transition: .4s;
        }

        .slider:before {
            background-color: #fff;
            bottom: 4px;
            content: "";
            height: 26px;
            left: 4px;
            position: absolute;
            transition: .4s;
            width: 26px;
        }

        input:checked + .slider {
            background-color: #3636C9;
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        @import url(https://fonts.googleapis.com/css?family=Roboto:100,300,400,900,700,500,300,100);
        *{
            margin: 0;
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
        }
        ::selection {background: #f31544; color: #FFF;}
        ::moz-selection {background: #f31544; color: #FFF;}
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        .col-left {
            float: left;
        }
        .col-right {
            float: right;
        }
        h1{
            font-size: 1.5em;
            color: #444;
        }
        h2{font-size: .9em;}
        h3{
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }
        p{
            font-size: .9em;
            color: #666;
            line-height: 1.2em;
        }
        a {
            text-decoration: none;
            color: #00a63f;
        }

        #invoiceholder{
            width:100%;
            height: 100%;
            padding: 50px 0;
        }
        #invoice{
            position: relative;
            margin: 0 auto;
            width: 900px;
            background: #FFF;
        }

        [id*='invoice-']{ /* Targets all id with 'col-' */
            /*  border-bottom: 1px solid #EEE;*/
            padding: 20px;
        }

        #invoice-top{border-bottom: 2px solid #00a63f;}
        #invoice-mid{min-height: 110px;}
        #invoice-bot{ min-height: 240px;}

        .logo{
            display: inline-block;
            vertical-align: middle;
            width: 110px;
            overflow: hidden;
        }
        .info{
            display: inline-block;
            vertical-align: middle;
            margin-left: 20px;
        }
        .logo img,
        .clientlogo img {
            width: 100%;
        }
        .clientlogo{
            display: inline-block;
            vertical-align: middle;
            width: 50px;
        }
        .clientinfo {
            display: inline-block;
            vertical-align: middle;
            margin-left: 20px
        }
        .title{
            float: right;
        }
        .title p{text-align: right;}
        #message{margin-bottom: 30px; display: block;}
        h2 {
            margin-bottom: 5px;
            color: #444;
        }
        .col-right td {
            color: #666;
            padding: 5px 8px;
            border: 0;
            font-size: 0.9em;
            border-bottom: 1px solid #eeeeee;
        }
        .col-right td label {
            margin-left: 5px;
            font-weight: 600;
            color: #444;
        }
        .cta-group a {
            display: inline-block;
            padding: 7px;
            border-radius: 4px;
            background: rgb(196, 57, 10);
            margin-right: 10px;
            min-width: 100px;
            text-align: center;
            color: #fff;
            font-size: 0.9em;
        }
        .cta-group .btn-primary {
            background: #00a63f;
        }
        .cta-group.mobile-btn-group {
            display: none;
        }
        table{
            width: 100%;
            border-collapse: collapse;
        }
        td{
            padding: 10px;
            border-bottom: 1px solid #cccaca;
            font-size: 0.90em;
            text-align: right;
        }

        .tabletitle th {
            border-bottom: 2px solid #ddd;
            text-align: right;
        }
        .tabletitle th:nth-child(2) {
            text-align: left;
        }
        th {
            font-size: 0.9em;
            text-align: right;
            padding: 5px 10px;
        }
        .item{width: 50%;}
        .list-item td {
            text-align: right;
        }
        .list-item td:nth-child(2) {
            text-align: right;
        }
        .total-row th,
        .total-row td {
            text-align: right;
            font-weight: 700;
            font-size: .9em;
            border: 0 none;
        }
        .table-main {

        }
        footer {
            border-top: 1px solid #eeeeee;;
            padding: 15px 20px;
        }
        .effect2
        {
            position: relative;
        }
        .effect2:before, .effect2:after
        {
            z-index: -1;
            position: absolute;
            content: "";
            bottom: 15px;
            left: 10px;
            width: 50%;
            top: 80%;
            max-width:300px;
            background: #777;
            -webkit-box-shadow: 0 15px 10px #777;
            -moz-box-shadow: 0 15px 10px #777;
            box-shadow: 0 15px 10px #777;
            -webkit-transform: rotate(-3deg);
            -moz-transform: rotate(-3deg);
            -o-transform: rotate(-3deg);
            -ms-transform: rotate(-3deg);
            transform: rotate(-3deg);
        }
        .effect2:after
        {
            -webkit-transform: rotate(3deg);
            -moz-transform: rotate(3deg);
            -o-transform: rotate(3deg);
            -ms-transform: rotate(3deg);
            transform: rotate(3deg);
            right: 10px;
            left: auto;
        }
        @media screen and (max-width: 767px) {
            h1 {
                font-size: .9em;
            }
            #invoice {
                width: 100%;
            }
            #message {
                margin-bottom: 20px;
            }
            [id*='invoice-'] {
                padding: 20px 10px;
            }
            .logo {
                width: 140px;
            }
            .title {
                float: none;
                display: inline-block;
                vertical-align: middle;
                margin-left: 40px;
            }
            .title p {
                text-align: left;
            }
            .col-left,
            .col-right {
                width: 100%;
            }
            .table {
                margin-top: 20px;
            }
            #table {
                white-space: nowrap;
                overflow: auto;
            }
            td {
                white-space: normal;
            }
            .cta-group {
                text-align: center;
            }
            .cta-group.mobile-btn-group {
                display: block;
                margin-bottom: 20px;
            }
            /*==================== Table ====================*/
            .table-main {
                border: 0 none;
            }
            .table-main thead {
                border: none;
                clip: rect(0 0 0 0);
                height: 1px;
                margin: -1px;
                overflow: hidden;
                padding: 0;
                position: absolute;
                width: 1px;
            }
            .table-main tr {
                border-bottom: 2px solid #eee;
                display: block;
                margin-bottom: 20px;
            }
            .table-main td {
                font-weight: 700;
                display: block;
                padding-left: 40%;
                max-width: none;
                position: relative;
                border: 1px solid #cccaca;
                text-align: left;
            }
            .table-main td:before {
                /*
                * aria-label has no advantage, it won't be read inside a table
                content: attr(aria-label);
                */
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: normal;
                text-transform: uppercase;
            }
            .total-row th {
                display: none;
            }
            .total-row td {
                text-align: left;
            }
            footer {text-align: center;}
        }

    </style>

