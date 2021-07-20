@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />



@endsection

@section('content')
   <header class="page-header">
						<h2>CQ Exam List</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>CQ Exam Result</span></li>
							</ol>
					    </div>
					</header>

					@include('admin.layout.message')

					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
								{{-- <a class="add"  href="{{ action('AdminMCQExamController@add_mcq_exam') }}"><i class="fa fa-plus"></i> Add
								</a> --}}
								</div>
						
								<h2 class="panel-title">CQ Exam Result</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Exam Title</th>
											<th>Branch</th>
											<th>Class</th>
											<th>Batch</th>
											<th>Subject</th>
											<th>Exam Date</th>
											<th>Exam Duration</th>
											<th>Exam Mark</th>
											<th>Solve Sheet</th>
                                            <th>Action</th>
										    
									</thead>
										</tr>
									<tbody>

										@foreach($exams as $exam)
										<tr class="gradeX">
											<td>{{$exam->name}}</td>
											<td>{{$exam->branch->name}}</td>
											<td>{{$exam->class->name}}</td>
											<td>{{$exam->batch->name}}</td>
											<td>{{$exam->subject->name}}</td>
											<td>{{$exam->exam_date}}</td>
											<td>{{$exam->total_exam_duration}}</td>
											<td>{{$exam->total_exam_marks}}</td>
											<td>
												<a href="{{url('/admin/solve_download')}}/{{$exam->solve_sheet}}" class="text-success" >{{$exam->solve_sheet}}</a>
											</td>
											{{-- <td>
											  <a href="{{url('/admin/solve_download')}}/{{$exam->solve_sheet}}" class="text-success" >{{$exam->solve_sheet}}</a>
                                            <td> --}}
												
                                           
												
											<td>
												<a class="mb-xs mt-xs mr-xs btn btn-primary btn-xs" href="{{ action('AdminCQExamController@cq_exam_result_view',$exam->id) }}">View Enrolled Students</a>

												<a class="mb-xs mt-xs mr-xs btn btn-primary btn-xs" href="{{ action('AdminCQExamController@add_solve_sheet',$exam->id) }}">Add Solve Sheet</a>
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

<script type="text/javascript">
	$('.status').on('change', function(e){
      $(this).closest('form').submit();
      
    });
</script>

@endsection
