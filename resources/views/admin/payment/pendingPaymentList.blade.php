@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
@endsection

@section('content')
   <header class="page-header">
						<h2>Pending Online Payments</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Pending Online Payments</span></li>
							</ol>
					    </div>
					</header>

					@include('admin.layout.message')

					<section class="panel">
							<header class="panel-heading">
								
						
								<h2 class="panel-title">Pending  Online Payments List</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Student</th>
											<th>Class</th>
											<th>Batch</th>
											<th>Branch</th>
											<th>Total Amount</th>
											<th>Paid Amount</th>
											<th>Due Amount</th>
											<th>Payment Date</th>
											<th>Transaction Id</th>
											<th>Status</th>
											<th>Action</th>
                                        </tr>
									</thead>
									<tbody>
										@foreach($payments as $payment)
										<tr class="gradeX">
											<td>{{$payment->student->first_name}} {{$payment->student->last_name}}</td>
											<td>{{$payment->classname->name}}</td>
											<td>{{$payment->batch->name}}</td>
											<td>{{$payment->branch->name}}</td>
											<td>{{$payment->total_amount}}</td>
											<td>{{$payment->paid_amount}}</td>
											<td>{{$payment->due_amount}}</td>
											<td>
												@if($payment->payment_date == null)
												 <span class="text-danger">Payment Not Verified</span>
												@else
												
												{{$payment->payment_date}}
												@endif
											</td>
											<td>
												@if($payment->transaction_id == null)
												 <span class="text-danger">Student Transaction Id Not Given</span>
												@else
												 {{$payment->transaction_id}}
												@endif
											</td>
											<td>
												@if($payment->transaction_id !=null && $payment->transaction_id == $payment->admin_transaction_id)
												 <span class="text-success">Payment Verified</span>
												@else
												 <span class="text-danger">Payment Not Verified</span>
												@endif
											</td>
											<td>
												@if($payment->transaction_id !=null)
												<a href="{{ route('admin.student_online_payment_approval',$payment->id) }}" class="mb-xs mt-xs mr-xs btn btn-primary" >Transaction input</a>
												@endif
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</section>
@endsection

@section('custom-js')
<script src="{{asset('assets/backend/vendor/select2/select2.js')}}"></script>
<script src="{{asset('assets/backend/vendor/jquery-datatables/media/js/jquery.dataTables.js')}}"></script>
<script src="{{asset('assets/backend/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js')}}"></script>
<script src="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/js/datatables.js')}}"></script>
<script src="{{asset('assets/backend/javascripts/tables/examples.datatables.default.js')}}"></script>
<script src="{{asset('assets/backend/javascripts/tables/examples.datatables.row.with.details.js')}}"></script>
<script src="{{asset('assets/backend/javascripts/tables/examples.datatables.tabletools.js')}}"></script>
@endsection
