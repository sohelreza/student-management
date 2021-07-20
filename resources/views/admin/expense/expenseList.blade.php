@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
@endsection

@section('content')
   <header class="page-header">
						<h2>Expense</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Expense</span></li>
							</ol>
					    </div>
					</header>


					<section class="panel">
							<header class="panel-heading">
						        <h2 class="panel-title">Search Filter</h2>
							</header>
							<div class="panel-body">
                                <form method="get" action="{{action('ExpenseController@expenseSearch')}}">
			                    @csrf
			                        <div class="form-group">
									    <label class="col-md-2 control-label">Start Date</label>
										    <div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</span>
													<input type="text" name="start_date" id=""  data-plugin-datepicker class="form-control">
												</div>
											</div>
									</div>
									 <div class="form-group">
									    <label class="col-md-2 control-label">End Date</label>
										    <div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</span>
													<input type="text" name="end_date" id=""  data-plugin-datepicker class="form-control">
												</div>
											</div>
									</div> 

									<button type="submit" class="mb-xs mt-xs mr-xs btn btn-success">Search</button>                        
			                                                
			                    </form>
								
							</div>
						</section>



					

					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
								
								<a class="text-success" href="{{ action('ExpenseController@create') }}"><i class="fa fa-plus"></i> Add
								</a>
								
								<a class="text-danger" href="{{ action('ExpenseController@expensePdf') }}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF
								</a>
								
								</div>
						
								<h2 class="panel-title">Expense List</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Name</th>
											<th>Branch</th>
											<th>Added By</th>
											<th>Date</th>
											{{-- <th>Expense Head</th> --}}
											<th>Amount</th>
											<th>Action</th>

										    
										</tr>
									</thead>
									<tbody>
										@foreach($expenses as $expense)
										<tr class="gradeX">
											<td>{{$expense->name}}</td>
											<td>
												{{($expense->branch_id != null) ? $expense->branch->name:'' }}
											</td>
											<td>
												{{($expense->expense_head_id != null) ? $expense->admin->name:'' }}
											</td>
											<td>{{$expense->date}}</td>
											
											<td>{{$expense->amount}}</td>
											<td>
												<a href="{{ route('expenses.edit',$expense->id) }}" class="mb-xs mt-xs mr-xs btn btn-primary" >Edit</a>

												<form method="post" action="{{ route('expenses.destroy',$expense->id) }}"  style="display: inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete')">Delete</button>
                                                </form>
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
