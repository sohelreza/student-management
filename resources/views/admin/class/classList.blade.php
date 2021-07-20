@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
@endsection

@section('content')
   <header class="page-header">
						<h2>Classes</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Classes</span></li>
							</ol>
					    </div>
					</header>
                    @include('admin.layout.message')
                    
					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
								<a class="" href="{{ action('ClassController@create') }}"><i class="fa fa-plus"></i> Add
								</a>
								</div>
						
								<h2 class="panel-title">Classes List</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Name</th>
											<th>Branch</th>
											<th>HSC Year</th>
											<th>Status</th>
											<th>Action</th>
                                        </tr>
									</thead>
									<tbody>
										@foreach($classes as $class)
										<tr class="gradeX">
											<td>{{$class->name}}</td>
											<td>{{$class->branch->name}}</td>
											<td>{{$class->year}}</td>
											<td>
												@if($class->status == 0)
												  Inactive
												@elseif($class->status == 1)
												  Active
												@endif
											</td>

											<td>
												<a href="{{ route('classes.edit',$class->id) }}" class="mb-xs mt-xs mr-xs btn btn-primary" >Edit</a>

												{{-- <form method="post" action="{{ route('classes.destroy',$class->id) }}"  style="display: inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete')">Delete</button>
                                                </form> --}}
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
