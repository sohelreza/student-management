<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Expense</title>
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
            background: black;
            text-align: left;
            color: white;
            font-weight: 300;
            text-transform: uppercase;
            font-size: 10px;
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

        .total-amount-field {
            padding-bottom: 10px;
            padding-top: 10px !important;
            padding-right: 10px;
            float: right;
        }

        .total-amount-field h4 {
            display: inline-block;
            margin: 0px;
        }

        .total-amount-field p {
            display: inline-block;
            margin: 0px;
        }

        .table-data {
            text-align: center;
            font-size: 12px;
            color: black;
            padding: 8px 8px;
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
                Education)</span><span style="color:#2c75e4;"> (Turning Student Into Assets)</span></h5>
        {{-- <h5 style="padding-bottom:-10px !important;"><span style="color:#2c75e4;"> (Turning Student Into Assets)</span>
        </h5> --}}
    </div>

    @php
        $branch=App\Branch::find($request_branch);
        $class=App\ClassName::find($request_class);
        $batch=App\Batch::find($request_batch);
    @endphp


    <div class="input-field" style="padding-top: 20px !important;">
        <h4>Student Type : </h4>
        <p>
            @if($request_student_type == 1)
                Online
            @elseif($request_student_type == 0)
                Offline
            @endif

        </p>
    </div>
    <div class="input-field">
        <h4>Branch : </h4>
        <p>{{ $branch->name }}</p>
    </div>
    <div class="input-field">
        <h4>Class : </h4>
        <p>{{ $class->name }}</p>
    </div>
    <div class="input-field">
        <h4>Batch : </h4>
        <p>{{ $batch->name }}</p>
    </div>




    <div style="text-align: center;">
        <h2 class="head-font">Student List</h2>
    </div>

    <table id="invoice" border="2" cellspacing="0" cellpadding="0" width="100%">

        <thead>
            <tr>

                {{-- <th style="text-align: center;width:14%;"
                    style="background-color:white; color:black;font-size:8px;background-color:lightgrey;padding:10px 10px;">
                    Name
                </th>
                <th style="text-align: center;width:14%;"
                    style="background-color:white;color:black; font-size:8px;background-color:lightgrey;padding:10px 10px;">
                    Registration ID
                </th>
                <th style="text-align: center;width:14%;"
                    style="background-color:white;color:black; font-size:8px;background-color:lightgrey;padding:10px 10px;">
                    Phone
                </th>
                <th style="text-align: center;width:14%;"
                    style="background-color:white;color:black; font-size:8px;background-color:lightgrey;padding:10px 10px;">
                    Subjects/Courses
                </th>
                <th style="text-align: center;width:14%;"
                    style="background-color:white;color:black; font-size:8px;background-color:lightgrey;padding:10px 10px;">
                    Date of Addmission
                </th>
                <th style="text-align: center;width:14%;"
                    style="background-color:white;color:black; font-size:8px;background-color:lightgrey;padding:10px 10px;">
                    Payment Due Date
                </th>
                <th style="text-align: center;width:14%;"
                    style="background-color:white;color:black; font-size:8px;background-color:lightgrey;padding:10px 10px;">
                    Due
                </th> --}}

                <th style="text-align: center;">
                    Name
                </th>
                <th style="text-align: center;font-size:8px">
                    Registration ID
                </th>
                <th style="text-align: center;">
                    Phone
                </th>
                <th style="text-align: center;">
                    Subjects /Courses
                </th>
                <th style="text-align: center;">
                    Date of Addmission
                </th>
                <th style="text-align: center;">
                    Payment Due Date
                </th>
                <th style="text-align: center;">
                    Total
                </th>
                <th style="text-align: center;">
                    Paid
                </th>
                <th style="text-align: center;">
                    Due
                </th>
                <th style="text-align: center;">
                    Payment Status
                </th>

            </tr>
        </thead>

        <tbody>
            @foreach($students as $student)
                <tr>

                    <td class="table-data">
                        {{ $student->first_name }} {{ $student->last_name }}
                    </td>
                    <td class="table-data">
                        {{ $student->registration_id }}
                    </td>
                    <td class="table-data">
                        {{ $student->phone }}
                    </td>
                    <td class="table-data" style="width: 100px; text-align: left;">
                        @foreach($student->subjects as $subject)
                            {{ $loop->iteration }}. {{ $subject->subject->name }} <br>
                        @endforeach
                    </td>
                    <td class="table-data" style="white-space: nowrap; text-align: center;">
                        @php
                            $date_of_addmission = date('d-m-Y', strtotime($student->date_of_addmission))
                        @endphp
                        {{ $date_of_addmission }}
                    </td>
                    <td class="table-data" style="white-space: nowrap; text-align: center;">
                        @php
                            $next_payment_date = date('d-m-Y', strtotime($student->next_payment_date))
                        @endphp
                        @if($student->student_type == 0)
                            {{ $next_payment_date }}
                        @elseif($student->student_type == 1)
                            @if($student->next_payment_date == null)
                                <span class="text-danger">Student Not Approved</span>
                            @else
                                {{ $next_payment_date }}
                            @endif

                        @endif
                    </td>
                     @php
                        $due=App\StudentPayment::where('student_id',$student->id)->orderBy('id', 'desc')->first();
                    @endphp
                    <td class="table-data">
                       {{ $due->total_amount }}
                    </td>
                    <td class="table-data">
                       {{ $due->paid_amount }}
                    </td>
                    <td class="table-data">
                       {{ $due->due_amount }}
                    </td>
                    @if($student->student_type == 1)
                    <td class="table-data">

                        @php
                            $date = new DateTime($student->next_payment_date);
                            $now = new DateTime();
                        @endphp

                    @if($date < $now)
                        <span class="text-danger">Due</span>
                    @else
                        <span class="text-success">Paid</span>
                    @endif

                    </td>
                    @elseif($student->student_type == 0)
                    <td  class="table-data">
                    @if($due->due_amount > 0)
                        <span class="text-danger">Due</span>
                    @else
                        <span class="text-success">Paid</span>
                    @endif
                    </td>
                    @endif

                </tr>
            @endforeach

        </tbody>
    </table>

    <div class="divFooter" style="position: absolute; bottom: 5px;font-size:11px">
        <p style=""> Print Date: {{ Carbon\Carbon::now()->format('d-m-Y') }} & Print Time:
            {{ Carbon\Carbon::now('Asia/dhaka')->format('h:i:s a') }}
        </p>
    </div>

</body>

</html>
