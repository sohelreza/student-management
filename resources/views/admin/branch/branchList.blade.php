@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
@endsection

@section('content')
   <header class="page-header">
						<h2>Branches</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Branches</span></li>
							</ol>
					    </div>
					</header>
                    @include('admin.layout.message')
					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
								<a class="" href="{{ action('BranchController@create') }}"><i class="fa fa-plus"></i> Add
								</a>
								</div>
						
								<h2 class="panel-title">Branches List</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Name</th>
											<th>Address</th>
											<th>Type</th>
											<th>Action</th>

										    
										</tr>
									</thead>
									<tbody>
										@foreach($branches as $branch)
										<tr class="gradeX">
											<td>{{$branch->name}}</td>
											<td>{{$branch->address}}</td>
											<td>
												@if($branch->student_type == 0)
												 Offline
												@elseif($branch->student_type == 1)
												 Online
												@elseif($branch->student_type == 2)
                                                Online & Offline
												@endif
											</td>
											<td>
												<a href="{{ route('branches.edit',$branch->id) }}" class="mb-xs mt-xs mr-xs btn btn-primary" >Edit</a>

												{{-- <form method="post" action="{{ route('branches.destroy',$branch->id) }}"  style="display: inline">
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
