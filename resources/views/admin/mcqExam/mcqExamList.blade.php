@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />



@endsection

@section('content')
   <header class="page-header">
						<h2>MCQ Exam List</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>MCQ Exam List</span></li>
							</ol>
					    </div>
					</header>

					@include('admin.layout.message')

					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
								<a class="add"  href="{{ action('AdminMCQExamController@add_mcq_exam') }}"><i class="fa fa-plus"></i> Add
								</a>
								</div>
						
								<h2 class="panel-title">MCQ Exam List</h2>
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
											<th>Exam Time</th>
											<th>Exam Duration (min)</th>
											<th>Exam Mark</th>
											<th>Status</th>
											<th>Answer Sheet Publish</th>
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
											<td>{{date("g:i A", strtotime($exam->start_time))}} to {{date("g:i A", strtotime($exam->end_time))}}</td>
											<td>{{$exam->total_exam_duration}}</td>
											<td>{{$exam->total_exam_marks}}</td>

                                            <td>
												<form action="{{action('AdminMCQExamController@changeStatus')}}" method="post">
												@csrf
													<input type="hidden" name="exam_id" value="{{$exam->id}}">
													<select class="form-control mb-md status" name="status">
														<option value="1" {{ $exam->status == 1 ? 'selected' : '' }}>Active</option>
														<option value="0" {{ $exam->status == 0 ? 'selected' : '' }}>Deactive</option>
													</select>
												</form>
											</td>

											 <td>
												<form action="{{action('AdminMCQExamController@changeResultPublishStatus')}}" method="post">
												@csrf
													<input type="hidden" name="exam_id" value="{{$exam->id}}">
													<select class="form-control mb-md status" name="publish_answer">
														<option value="1" {{ $exam->publish_answer == 1 ? 'selected' : '' }}>Show Answer</option>
														<option value="0" {{ $exam->publish_answer == 0 ? 'selected' : '' }}>Donot Show Answer</option>
													</select>
												</form>
											</td>
												
											<td>
												
											  	<a class="mb-xs mt-xs mr-xs btn btn-danger btn-xs" href="{{ action('AdminMCQExamController@delete_mcq_exam',$exam->id) }}">Delete</a>
	                                             
											  	<a class="mb-xs mt-xs mr-xs btn btn-primary btn-xs" href="{{ action('AdminMCQExamController@edit_mcq_exam',$exam->id) }}">Edit</a>

											  	<a class="mb-xs mt-xs mr-xs btn btn-primary btn-xs" href="{{ action('AdminMCQExamController@add_mcq_question',$exam->id) }}">Add Question</a>
											  	<a class="mb-xs mt-xs mr-xs btn btn-primary btn-xs" href="{{ action('AdminMCQExamController@view_mcq_question',$exam->id) }}">View Question</a>

											  	<a class="mb-xs mt-xs mr-xs btn btn-primary btn-xs" href="{{ action('AdminMCQExamController@duplicate_mcq_exam',$exam->id) }}">Duplicate</a>
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
