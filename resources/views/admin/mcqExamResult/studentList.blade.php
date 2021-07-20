@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />



@endsection

@section('content')
   <header class="page-header">
						<h2>Student List</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Student List</span></li>
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
						
								<h2 class="panel-title">Student List</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="">
									<thead>
										<tr>
											<th>Student Name</th>
											<th>Registration ID</th>
											<th>Exam Title</th>
											<th>Total Marks</th>
											<th>Score</th>
                                            <th>Action</th>
										    
									</thead>
										</tr>
									<tbody>

										@foreach($students as $student)
										<tr class="gradeX">
											<td>{{$student->first_name}}  {{$student->last_name}}</td>
											<td>{{$student->registration_id}}</td>
											<td>{{$student->name}}</td>
											<td>{{$student->total_exam_marks}}</td>
											<td>{{$student->score}}</td>
                                           
												
											<td>
												<a class="mb-xs mt-xs mr-xs btn btn-primary btn-xs" href="{{ url('admin/mcq_student_result/'.$student->exam_id.'/student/'.$student->student_id)}}" >View Result</a>
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
