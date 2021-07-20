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
									<a href="{{route('teacher.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>CQ Exam List</span></li>
							</ol>
					    </div>
					</header>

					@include('admin.layout.message')

					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
								<a class="add"  href="{{ action('TeacherCQExamController@add_cq_exam') }}"><i class="fa fa-plus"></i> Add
								</a>
								</div>
						
								<h2 class="panel-title">CQ Exam List</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Exam Title</th>
											<th>Teacher</th>
											<th>Branch</th>
											<th>Class</th>
											<th>Batch</th>
											<th>Subject</th>
											<th>Exam Date</th>
											<th>Exam Time</th>
											<th>Exam Duration (min)</th>
											<th>Exam Mark</th>
											<th>Status</th>
											<th>Rank Publish Status</th>
                                            <th>Action</th>
										    
									</thead>
										</tr>
									<tbody>

										@foreach($exams as $exam)
										<tr class="gradeX">
											<td>{{$exam->name}}</td>
											<td>{{$exam->teacher->name}}</td>
											<td>{{$exam->branch->name}}</td>
											<td>{{$exam->class->name}}</td>
											<td>{{$exam->batch->name}}</td>
											<td>{{$exam->subject->name}}</td>
											<td>{{$exam->exam_date}}</td>
											<td>{{date("g:i A", strtotime($exam->start_time))}} to {{date("g:i A", strtotime($exam->end_time))}}</td>
											<td>{{$exam->total_exam_duration}}</td>
											<td>{{$exam->total_exam_marks}}</td>
                                            <td>
												<form action="{{action('TeacherCQExamController@change_cq_exam_status')}}" method="post">
												@csrf
													<input type="hidden" name="exam_id" value="{{$exam->id}}">
													<select class="form-control mb-md status" name="status">
														<option value="1" {{ $exam->status == 1 ? 'selected' : '' }}>Active</option>
														<option value="0" {{ $exam->status == 0 ? 'selected' : '' }}>Deactive</option>
													</select>
												</form>
											</td>

											 <td>
												<form action="{{action('TeacherCQExamController@changeRankPublishStatus')}}" method="post">
												@csrf
													<input type="hidden" name="exam_id" value="{{$exam->id}}">
													<select class="form-control mb-md status" name="publish_rank">
														<option value="1" {{ $exam->publish_rank == 1 ? 'selected' : '' }}>Show Rank</option>
														<option value="0" {{ $exam->publish_rank == 0 ? 'selected' : '' }}>Donot Show Rank</option>
													</select>
												</form>
											</td>
												
											<td>
												
											  	<a class="mb-xs mt-xs mr-xs btn btn-danger btn-xs" href="{{ action('TeacherCQExamController@delete_cq_exam',$exam->id) }}">Delete</a>
	                                             
											  	<a class="mb-xs mt-xs mr-xs btn btn-primary btn-xs" href="{{ action('TeacherCQExamController@edit_cq_exam',$exam->id) }}">Edit</a>

											  	<a class="mb-xs mt-xs mr-xs btn btn-primary btn-xs" href="{{ action('TeacherCQExamController@add_cq_question',$exam->id) }}">Add Question</a>
											  	<a class="mb-xs mt-xs mr-xs btn btn-primary btn-xs" href="{{ action('TeacherCQExamController@view_cq_question',$exam->id) }}">View Question</a>
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
