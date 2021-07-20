@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
@endsection

@section('content')
   <header class="page-header">
						<h2>Offline Student Payments</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Offline Student Payments</span></li>
							</ol>
					    </div>
					</header>

					@include('admin.layout.message')

					<section class="panel">
							<header class="panel-heading">
								
						
								<h2 class="panel-title">Offline Student Payments List</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Class</th>
											<th>Batch</th>
											<th>Branch</th>
											<th>Total Amount</th>
											<th>Paid Amount</th>
											<th>Due Amount</th>
											<th>Last Payment Date</th>
											<th>Transaction Id</th>
											<th>Action</th>
                                        </tr>
									</thead>
									<tbody>
										@foreach($payments as $payment)
										<tr class="gradeX">
											<td>{{$payment->classname->name}}</td>
											<td>{{$payment->batch->name}}</td>
											<td>{{$payment->branch->name}}</td>
											<td>{{$payment->total_amount}}</td>
											<td>{{$payment->paid_amount}}</td>
											<td>{{$payment->due_amount}}</td>
											<td>{{$payment->payment_date}}</td>
											<td>{{$payment->transaction_id}}</td>
											<td>
												<a href="{{ route('admin.offline_payment_installments',$payment->id) }}" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary" >View Installment</a>

												<a href="{{ route('admin.add_offline_payment_installment',$payment->id) }}" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary" >Add Installment</a>

												<a href="{{ route('admin.offline_payment_invoice',$payment->id) }}" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary" >Invoice</a>
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
