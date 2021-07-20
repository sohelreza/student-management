<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration Form</title>
    <style>
        body {
            padding: .1in;
        }

        .company-logo {
            display: inline-block;
            width: 25%;
            padding: 5px;
            margin-top: -60px;
        }

        .company-logo h2 {
            margin-top: 0px;
        }

        .form-heading {
            display: inline-block;
            width: 44%;
            padding: 5px;
            text-align: center;
        }

        .form-heading h2 {
            margin-top: 0px;
        }

        .student-photo {
            display: inline-block;
            height: 150px;
            width: 25%;
            padding: 5px;
            text-align: center;
        }

        .student-photo h2 {
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

        .head-font {
            font-style: italic;
            padding-bottom: -15px;
        }

        .page_break {
            page-break-before: always;
        }

        .empty-image {
            height: 150px;
            width: 150px;
            padding: 10px;
            border: 1px dashed black !important;
            margin: 0;
            text-align: center;
            vertical-align: middle;
            line-height: 170px;
            font-size: 20px;
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

    <div class="form-heading" style="vertical-align: top; padding-top: -40px !important;"">
@php
            $company_details = App\CompanyDetail::first();
@endphp
        <h3 style=" padding-bottom:-10px !important;">SHADOW AIDE <span style="color: #fd7635;">&</span>
        <span style="color: green">LIFE LINE</span></h3>
        <h5 style="padding-bottom:-10px !important;"><span style="color: rgb(124, 0, 41)">(Ensure Optimal
                Education)</span></h5>
        <h5 style="padding-bottom:-10px !important;"><span style="color:#2c75e4;"> (Turning Student Into Assets)</span>
        </h5>
    </div>

    <div class="student-photo">
        <div class="empty-image">Student's Photo</div>
    </div>

    <div class="input-field" style="padding-top: -30px !important;">
        <h4>Form No : </h4>
        <p>{{ $student->form_number }}</p>
    </div>

    <div style="text-align: center;">
        <h2 class="head-font">Payment Statement</h2>
        <p>Office Copy</p>
        <h3>Personal Information</h3>
    </div>

    <div class="input-field" style="padding-top: 10px;">
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

    <div class="input-field">
        <h3>Date of Admission : </h3>
        <p>{{ date('d-m-Y', strtotime($student->date_of_addmission)) }}</p>
    </div>

    <div class="input-field" style="padding-top: 20px; width: 90%;">
        <h3>Subjects/Courses : </h3>
        <br>
        <span>
            @foreach($student_subjects as $subject)
                <p style="margin-right: 20px;">{{ $loop->index+1 }}. {{ $subject->subject->name }}</p>
            @endforeach
        </span>
    </div>

    <div class="payment-heading">
        <h3>Payment Information</h3>
    </div>

    <div class="input-field">
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




    <div class="page_break"></div>




    <div class="company-logo" style="vertical-align: top;">
        <img height="80px" width="160px" src="{{ public_path('company/shadowaide.jpg') }}">
    </div>

    <div class="form-heading" style="vertical-align: top; padding-top: -20px !important;">
        @php
            $company_details = App\CompanyDetail::first();
        @endphp
        <h3 style="padding-bottom:-10px !important;">SHADOW AIDE <span style="color: #fd7635;">&</span>
            <span style="color: green">LIFE LINE</span></h3>
        <h5 style="padding-bottom:-10px !important;"><span style="color: rgb(124, 0, 41)">(Ensure Optimal
                Education)</span></h5>
        <h5 style="padding-bottom:-10px !important;"><span style="color:#2c75e4;"> (Turning Student Into Assets)</span>
        </h5>

    </div>

    <div class="student-photo" style="vertical-align: top;">
        <div class="empty-image">Student's Photo</div>
    </div>

    <div class="input-field" style="padding-top: 10px;">
        <h4>Form No : </h4>
        <p>{{ $student->form_number }}</p>
    </div>

    <div style="text-align: center;">
        <h2 class="head-font">Payment Statemen</h2>
        <p>Student's Copy</p>
        <h3>Personal Information</h3>
    </div>

    <div class="input-field" style="padding-top: 10px;">
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

    <div class="input-field">
        <h3>Date of Admission : </h3>
        <p>{{ date('d-m-Y', strtotime($student->date_of_addmission)) }}</p>
    </div>

    <div class="input-field" style="padding-top: 20px; width: 90%;">
        <h3>Subjects/Courses : </h3>
        <br>
        <span>
            @foreach($student_subjects as $subject)
                <p style="margin-right: 20px;">{{ $loop->index+1 }}. {{ $subject->subject->name }}</p>
            @endforeach
        </span>
    </div>

    <div class="payment-heading">
        <h3>Payment Information</h3>
    </div>

    <div class="input-field">
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

</body>

</html>
