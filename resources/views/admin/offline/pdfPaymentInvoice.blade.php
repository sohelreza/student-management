<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Payment Receipt</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <style>
        body {
            padding: .1in;
        }

        .company-logo {
            display: inline-block;
            width: 25%;
            padding: 5px;
            margin-top: -3px;
        }

        .company-logo h2 {
            margin-top: 0px;
        }

        .form-heading {
            display: inline-block;
            width: 72%;
            padding: 5px;
            text-align: right;
        }

        .form-heading h2 {
            margin-top: 0px;
        }

        .input-field {
            padding-bottom: 10px;
        }

        .input-field h3 {
            display: inline-block;
            margin: 0px;
        }

        .input-field h4 {
            display: inline-block;
            margin: 0px;
        }

        .input-field p {
            display: inline-block;
            margin: 0px;
        }

        .head-font {
            font-style: italic;
            padding-bottom: -15px;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border-collapse: none;
            border-spacing: 0;
            font-size: 0.9166em;
        }

        table thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }

        table thead th {
            padding: 5px 10px;
            background: #353A40;
            text-align: left;
            color: white;
            font-weight: 400;
            text-transform: uppercase;
            font-size: 18px;
        }

        table tbody td {
            padding: 5px;
            color: #777777;
            text-align: left;
            font-size: 16px;
        }

        table tbody td:last-child {
            border-right: none;
        }

        table tbody h3 {
            margin-bottom: 5px;
            color: #FEEEEF;
            font-weight: 600;
        }

        th,
        td {
            text-align: left;
            font-weight: normal;
            vertical-align: middle;
        }

        th {
            border: 0.01em solid lightgray;
        }

        #invoice td {
            border: 0.01em solid lightgray;
        }

        <blade media|%20screen%20%7B%0D>div.divFooter {
            display: none;
        }
        }

        <blade media|%20print%20%7B%0D>div.divFooter {
            position: fixed;
            bottom: 0;
        }
        }

        .table-data {
            text-align: center;
            font-size: 14px;
            color: black;
            padding: 1px 15px;
        }

        .payment-heading {
            display: inline-block;
            width: 100%;
            padding: 5px;
            text-align: center;
        }

        .signature {
            display: inline-block;
            width: 31%;
            width: 230px;
            padding-top: 50px;
            padding-bottom: 0px !important;
            text-decoration: overline;
        }

        .page_break {
            page-break-before: always;
        }

        .footer-1 {
            display: inline-block;
            width: 40%;
            padding: 0px;
            text-align: left;
        }

        .footer-2 {
            display: inline-block;
            width: 30%;
            padding: 0px;
            text-align: center;
        }

        .footer-3 {
            display: inline-block;
            width: 20%;
            padding: 0px;
            text-align: right;
        }

    </style>
</head>

<body>

    <div class="company-logo">
        <img height="80px" width="160px" src="{{ public_path('company/shadowaide.jpg') }}">
    </div>

    <div class="form-heading" style="vertical-align: top; padding-top: -40px !important;">
        @php
            $company_details = App\CompanyDetail::first();
        @endphp
        <h3 style=" padding-bottom:-10px !important;">SHADOW AIDE <span style="color: #fd7635;">&</span>
            <span style="color: green">LIFE LINE</span></h3>
        <h5 style="padding-bottom:-10px !important;"><span style="color: rgb(124, 0, 41)">(Ensure Optimal
                Education)</span><span style="color:#2c75e4;"> (Turning Student Into Assets)</span>
        </h5>
    </div>

    <div style="text-align: center; padding-top: -40px !important;">
        <h2 class="head-font">Payment Receipt</h2>
        <p style="padding-top: -20px !important;">Office Copy</p>
        <h3>Personal Information</h3>
    </div>

    <div class="input-field" style="padding-top: -15px !important;">
        <h3>Student Name : </h3>
        <p>{{ $student->first_name }} {{ $student->last_name }}</p>
    </div>

    <div class="input-field">
        <h3>Moblie Number : </h3>
        <p>{{ $student->phone }}</p>
    </div>

    <div class="input-field">
        <h3>Student Type : </h3>
        <p>
            @if($student->student_type == 0)
                Offline
            @elseif($student->student_type == 1)
                Online
            @endif
        </p>
    </div>

    <div class="input-field">
        <h3>Branch : </h3>
        <p>{{ $student->branch->name }}</p>
        <h3 style="margin-left: 80px;">Class : </h3>
        <p>{{ $student->classname->name }}</p>
        <h3 style="margin-left: 80px;">Batch : </h3>
        <p>{{ $student->batch->name }}</p>
    </div>

    <div class="input-field">
        <h3>Registration ID : </h3>
        <p>{{ $student->registration_id }}</p>
    </div>

    <div class="payment-heading">
        <h3>Payment Information</h3>
    </div>

    <div class="input-field" style="padding-top: -15px !important;">
        <h3>Total Amout : </h3>
        <p>{{ $student_payment->total_amount }} TK</p>
    </div>

    <div class="input-field">
        <h3>Paid Amount : </h3>
        <p>{{ $student_payment->paid_amount }} TK</p>
    </div>

    <div class="input-field">
        <h3>Due Amount : </h3>
        <p>{{ $student_payment->due_amount }} TK</p>
    </div>

    <div class="input-field">
        <h3>Next Payment Date : </h3>
        <p>
            @if($student->next_payment_date == null)
                Payment Not Varified
            @else
                {{ date('d-m-Y', strtotime($student->next_payment_date)) }}
            @endif
        </p>
    </div>

    <div style="text-align: center;">
        <h2 class="head-font">Payment History</h2>
    </div>

    <table id="invoice" border="2" cellspacing="0" cellpadding="0"
        style="padding-top: -15px !important; margin-bottom: 20px !important;">

        <thead>
            <tr>

                <th style="text-align: center;width:14%;"
                    style="background-color:white; color:black;font-size:8px;background-color:lightgrey;padding:10px 10px;">
                    Date
                </th>

                <th style="text-align: center;width:14%;"
                    style="background-color:white;color:black; font-size:8px;background-color:lightgrey;padding:10px 10px;">
                    Amount
                </th>

            </tr>
        </thead>

        <tbody>
            @foreach($student_payment_installments as $installment)
                <tr>

                    <td class="table-data">
                        {{ $installment->payment_date }}
                    </td>

                    <td class="table-data">
                        {{ $installment->amount }}
                    </td>

                </tr>
            @endforeach

        </tbody>
    </table>

    <div class="signature">
        <h3>Student's Signature</h3>
    </div>

    <div class="signature">
        <h3>Guardian's Signature</h3>
    </div>

    <div class="signature">
        <h3>Authorized Signature</h3>
    </div>

    <footer>

        <div class="footer-1">
            <h5>{{ $company_details->facebook }}</h5>
        </div>

        <div class="footer-2">
            <h5>www.shadowaidelifeline.com</h5>
        </div>

        <div class="footer-3">
            <h5>Mob : {{ $company_details->phone }}</h5>
        </div>

    </footer>

    <div class="divFooter" style="position: absolute; bottom: 5px; font-size:11px">
        <p style=""> Print Date: {{ Carbon\Carbon::now()->format('d-m-Y') }} & Print Time:
            {{ Carbon\Carbon::now('Asia/dhaka')->format('h:i:s a') }}
        </p>
    </div>











    <div class="page_break"></div>















    <div class="company-logo">
        <img height="80px" width="160px" src="{{ public_path('company/shadowaide.jpg') }}">
    </div>

    <div class="form-heading" style="vertical-align: top; padding-top: -40px !important;">
        @php
            $company_details = App\CompanyDetail::first();
        @endphp
        <h3 style=" padding-bottom:-10px !important;">SHADOW AIDE <span style="color: #fd7635;">&</span>
            <span style="color: green">LIFE LINE</span></h3>
        <h5 style="padding-bottom:-10px !important;"><span style="color: rgb(124, 0, 41)">(Ensure Optimal
                Education)</span><span style="color:#2c75e4;"> (Turning Student Into Assets)</span>
        </h5>
    </div>

    <div style="text-align: center; padding-top: -40px !important;">
        <h2 class="head-font">Payment Receipt</h2>
        <p style="padding-top: -20px !important;">Student/Guardian Copy</p>
        <h3>Personal Information</h3>
    </div>

    <div class="input-field" style="padding-top: -15px !important;">
        <h3>Student Name : </h3>
        <p>{{ $student->first_name }} {{ $student->last_name }}</p>
    </div>

    <div class="input-field">
        <h3>Moblie Number : </h3>
        <p>{{ $student->phone }}</p>
    </div>

    <div class="input-field">
        <h3>Student Type : </h3>
        <p>
            @if($student->student_type == 0)
                Offline
            @elseif($student->student_type == 1)
                Online
            @endif
        </p>
    </div>

    <div class="input-field">
        <h3>Branch : </h3>
        <p>{{ $student->branch->name }}</p>
        <h3 style="margin-left: 80px;">Class : </h3>
        <p>{{ $student->classname->name }}</p>
        <h3 style="margin-left: 80px;">Batch : </h3>
        <p>{{ $student->batch->name }}</p>
    </div>

    <div class="input-field">
        <h3>Registration ID : </h3>
        <p>{{ $student->registration_id }}</p>
    </div>

    <div class="payment-heading">
        <h3>Payment Information</h3>
    </div>

    <div class="input-field" style="padding-top: -15px !important;">
        <h3>Total Amout : </h3>
        <p>{{ $student_payment->total_amount }} TK</p>
    </div>

    <div class="input-field">
        <h3>Paid Amount : </h3>
        <p>{{ $student_payment->paid_amount }} TK</p>
    </div>

    <div class="input-field">
        <h3>Due Amount : </h3>
        <p>{{ $student_payment->due_amount }} TK</p>
    </div>

    <div class="input-field">
        <h3>Next Payment Date : </h3>
        <p>
            @if($student->next_payment_date == null)
                Payment Not Varified
            @else
                {{ date('d-m-Y', strtotime($student->next_payment_date)) }}
            @endif
        </p>
    </div>

    <div style="text-align: center;">
        <h2 class="head-font">Payment History</h2>
    </div>

    <table id="invoice" border="2" cellspacing="0" cellpadding="0"
        style="padding-top: -15px !important; margin-bottom: 20px !important;">

        <thead>
            <tr>

                <th style="text-align: center;width:14%;"
                    style="background-color:white; color:black;font-size:8px;background-color:lightgrey;padding:10px 10px;">
                    Date
                </th>

                <th style="text-align: center;width:14%;"
                    style="background-color:white;color:black; font-size:8px;background-color:lightgrey;padding:10px 10px;">
                    Amount
                </th>

            </tr>
        </thead>

        <tbody>
            @foreach($student_payment_installments as $installment)
                <tr>

                    <td class="table-data">
                        {{ $installment->payment_date }}
                    </td>

                    <td class="table-data">
                        {{ $installment->amount }}
                    </td>

                </tr>
            @endforeach

        </tbody>
    </table>

    <div class="signature">
        <h3>Student's Signature</h3>
    </div>

    <div class="signature">
        <h3>Guardian's Signature</h3>
    </div>

    <div class="signature">
        <h3>Authorized Signature</h3>
    </div>

    <footer>

        <div class="footer-1">
            <h5>{{ $company_details->facebook }}</h5>
        </div>

        <div class="footer-2">
            <h5>www.shadowaidelifeline.com</h5>
        </div>

        <div class="footer-3">
            <h5>Mob : {{ $company_details->phone }}</h5>
        </div>

    </footer>

    <div class="divFooter" style="position: absolute; bottom: 5px;font-size:11px">
        <p style=""> Print Date: {{ Carbon\Carbon::now()->format('d-m-Y') }} & Print Time:
            {{ Carbon\Carbon::now('Asia/dhaka')->format('h:i:s a') }}
        </p>
    </div>


</body>

</html>
