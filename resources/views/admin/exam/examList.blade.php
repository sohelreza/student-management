@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />



@endsection

@section('content')
   <header class="page-header">
						<h2>Exam List</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Exam List</span></li>
							</ol>
					    </div>
					</header>

					@include('admin.layout.message')

					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
								<a class="add"  href="{{ action('AdminExamController@add_exam') }}"><i class="fa fa-plus"></i> Upload Exam result
								</a>
								</div>
						
								<h2 class="panel-title">Exam List</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Name</th>
											<th>Code</th>
											<th>Branch</th>
											<th>Class</th>
											<th>Batch</th>
											<th>Subject</th>
											<th>Total Marks</th>
											<th>Height Marks</th>
                                            <th>Action</th>
										    
									</thead>
										</tr>
									<tbody>

										@foreach($exams as $exam)
										<tr class="gradeX">
											<td>{{$exam->name}}</td>
											<td>{{$exam->code}}</td>
											<td>
												@if($exam->branch_id !== null)
												  {{$exam->branch->name}}
												@else
												N/A
												@endif
												
											</td>
											<td>
												@if($exam->class_id !== null)
												  {{$exam->class->name}}
												@else
												N/A
												@endif
											</td>
											<td>
												@if($exam->batch_id !== null)
												  {{$exam->batch->name}}
												@else
												 N/A
												@endif</td>
											<td>
												@if($exam->subject_id !== null)
												  {{$exam->subject->name}}
												@else
												 N/A
												@endif
											</td>
											
											<td>{{$exam->total_marks}}</td>
											<td>{{$exam->height_marks}}</td>
												
											<td>
	                                             
											  	<a class="mb-xs mt-xs mr-xs btn btn-primary btn-xs" href="{{ action('AdminExamController@exam_result',$exam->id) }}">Enrolls</a>
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
