@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
@endsection

@section('content')
   <header class="page-header">
						<h2>Student Exam Result</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Student Exam Result</span></li>
							</ol>
					    </div>
					</header>

					@include('admin.layout.message')

					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
								
								</div>
						
								<h2 class="panel-title">Student Exam Resultt</h2>
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
											<th>Student Answer</th>
											<th>Result</th>
											<th>Mark</th>
											
										    
									</thead>
										</tr>
									<tbody>

										@foreach($exam->questions as $question)
										<tr class="gradeX">
											<td>{{$question->question_number}}</td>
											<td>{{strip_tags($question->question_title)}}</td>
											@foreach($question->options as $option)
											<td>{{$option->option_title}}</td>
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
												@foreach($question->answers as $answer)
											      
											        @if($answer->option_id == 1)
											        A
											        @elseif($answer->option_id == 2)
											        B
											        @elseif($answer->option_id == 3)
											        C
											        @elseif($answer->option_id == 4)
											        D
											        @endif

											     
											    @endforeach
											</td>

											@php
												 $x= $question->mcq_right_answers ->map(function ($thing) {
					                 	               return $thing->option_number;
					                                    
					                              })->toArray();

												 $y= $question->exam_enroll_answers ->map(function ($thing) {
					                 	               return $thing->option_id;
					                                    
					                              })->toArray();

                                                if (count($x) == count($y) ) {

            
											        if ( count( $x ) == count( $y ) && !array_diff( $x, $y ) ) {
											               $right=1;
											           } else {
											             $right=0;
											           }
											         
											        } else {

											           if (count($y) == 0) {
											             $right=-1;
											           }else{
											              $right=0;
											           }
											         
											        }

											   if ($right == 1) {

											          $score=$exam->mark_per_question;
											          



											    }elseif($right == 0){
											          
											         if ($exam->negative_marking == 1) {


											            $score=-$exam->negative_mark_per_question;
											           
											          }else{
											          	$score=0;
											          }
											          
											    }elseif($right == -1){
											    	$score=0;
											    }     
											        
																							
										    @endphp
											<td>
												@if($right == 1)
												 <span style="color:green">Right</span>
												@elseif($right == 0)
												 <span style="color:red">Wrong</span>
												@elseif($right == -1)
												  <span style="color:grey">No answer</span>
												@endif
											</td>
											<td>
												{{$score}}
											</td>
												
											
											
										</tr>
										@endforeach
									</tbody>
									<tfoot>
								    <tr>
								      <td></td>
								      <td></td>
								      <td></td>
								      <td></td>
								      <td></td>
								      <td></td>
								      <td></td>
								      <td></td>
								      <td>Total Mark</td>
								      <td>{{$exam->enroll->score}}</td>
								    </tr>
								  </tfoot>
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
