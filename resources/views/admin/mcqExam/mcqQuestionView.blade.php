@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
@endsection

@section('content')
   <header class="page-header">
						<h2>MCQ Question List</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>MCQ Question List</span></li>
							</ol>
					    </div>
					</header>

					@include('admin.layout.message')

					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
								
								</div>
						
								<h2 class="panel-title">MCQ Question List</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Question No.</th>
											<th>Question Title</th>
											<th>A</th>
											<th>B</th>
											<th>C</th>
											<th>D</th>
											<th>Correct Answer</th>
											<th>Action</th>
										    
									</thead>
										</tr>
									<tbody>

										@foreach($questions as $question)
										<tr class="gradeX">
											<td>{{$question->question_number}}</td>
											<td>{!!$question->question_title!!}</td>
											@foreach($question->options as $option)
											<td>{!!$option->option_title!!}</td>
											@endforeach
											<td>
												@foreach($question->options as $option)
											      @if($option->right_answer == 1)
											        @if($option->option_number == 1)
											        A
											        @elseif($option->option_number == 2)
											        B
											        @elseif($option->option_number == 3)
											        C
											        @elseif($option->option_number == 4)
											        D
											        @endif

											      @endif
											    @endforeach
											</td>
												
											<td>
												
											  	<a class="mb-xs mt-xs mr-xs btn btn-danger btn-xs" href="{{ action('AdminMCQExamController@delete_mcq_question',$question->id) }}">Delete</a>
	                                             
											  	<a class="mb-xs mt-xs mr-xs btn btn-primary btn-xs" href="{{ action('AdminMCQExamController@edit_mcq_question',$question->id) }}">edit</a>

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
