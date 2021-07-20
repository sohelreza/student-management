@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/bootstrap-multiselect/bootstrap-multiselect.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/dropzone/css/basic.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/dropzone/css/dropzone.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/summernote/summernote.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/summernote/summernote-bs3.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/codemirror/lib/codemirror.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/codemirror/theme/monokai.css')}}" />

@endsection

@section('content')
   <header class="page-header">
						<h2>MCQ Exam</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>MCQ Exam</span></li>
							</ol>
					    </div>
					</header>
					 
                    @include('admin.layout.message')
					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
									<a href="#" class="fa fa-times"></a>
								</div>
						
								<h2 class="panel-title">Edit MCQ Exam</h2>
							</header>
							<div class="panel-body">
								<form class="" action="{{action('AdminMCQExamController@update_mcq_exam',$exam->id)}}" method="post">
									@csrf
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputDefault">Exam Title</label>
											<div class="col-md-6">
												<input type="text" class="form-control" name="name" id="inputDefault" value="{{$exam->name}}">
											</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="textareaAutosize">Instruction</label>
										    <div class="col-md-6">
												<textarea class="form-control" name="description" rows="3" id="textareaAutosize" data-plugin-textarea-autosize>{{$exam->description}}</textarea>
											</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputSuccess">Branch Type</label>
										<div class="col-md-6">
											<select class="form-control mb-md" name="student_type" id="student_type">
												
												<option value="0" {{ ($exam->student_type == 0) ? 'selected="selected"' : '' }} >Offline</option>
												<option value="1" {{ ($exam->student_type == 1) ? 'selected="selected"' : '' }} >Online</option>
												
											</select>
						
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputSuccess">Branch</label>
										<div class="col-md-6">
											<select class="form-control mb-md" name="branch_id" id="branch">
												<option value="{{$exam->branch_id}}" selected="true">{{$exam->branch->name}}</option>
												
											</select>
						
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputSuccess">Class</label>
										<div class="col-md-6">
											<select class="form-control mb-md" name="class_id" id="class">
												<option value="{{$exam->class_id}}" selected="true">{{$exam->class->name}}</option>
												
											</select>
						
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputSuccess">Batch</label>
										<div class="col-md-6">
											<select class="form-control mb-md" name="batch_id" id="batch">
												<option value="{{$exam->batch_id}}" selected="true">{{$exam->batch->name}}</option>
												
											</select>
						
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputSuccess">Subject</label>
										<div class="col-md-6">
											<select class="form-control mb-md" name="subject_id" id="subject">
												<option value="{{$exam->subject_id}}" selected="true">{{$exam->subject->name}}</option>
											</select>
						
										</div>
									</div>
                                    <div class="form-group">
										<label class="col-md-2 control-label">Exam Date</label>
										    <div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
													</span>
													<input type="text" name="exam_date" id="exam_date" data-plugin-datepicker class="form-control" value="{{$exam->exam_date}}">
													</div>
											</div>
									</div>
									 <div class="form-group">
										<label class="col-md-2 control-label">Exam Time</label>
										    <div class="col-md-3">
												<div class="input-group">
													<span class="input-group-addon">
															<i class="fa fa-clock-o"></i>
													</span>
													<input type="text" name="start_time" data-plugin-timepicker class="form-control" value="{{date("g:i A", strtotime($exam->start_time))}}">
												</div>
											</div>
											<div class="col-md-3">
												<div class="input-group">
													<span class="input-group-addon">
															<i class="fa fa-clock-o"></i>
													</span>
													<input type="text" name="end_time" data-plugin-timepicker class="form-control" value="{{date("g:i A", strtotime($exam->end_time))}}">
												</div>
											</div>
											
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputDefault">Exam Duration(In Minute)</label>
										<div class="col-md-6">
											<input type="number" step="0.01" name="total_exam_duration" class="form-control" id="inputDefault" value="{{$exam->total_exam_duration}}">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputDefault">Exam Marks</label>
										<div class="col-md-6">
											<input type="number" step="0.01" name="total_exam_marks" class="form-control" id="inputDefault" value="{{$exam->total_exam_marks}}">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputDefault">Passing Percentage(In %)</label>
										<div class="col-md-6">
											<input type="number" step="0.01" name="passing_percentage" class="form-control" id="inputDefault" value="{{$exam->passing_percentage}}">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputDefault">Time Per Question(In Seconds)</label>
										<div class="col-md-6">
											<input type="number" step="0.01" name="duration_per_question" class="form-control" id="inputDefault" value="{{$exam->duration_per_question}}">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputDefault">Mark Per Question</label>
										<div class="col-md-6">
											<input type="number" step="0.01" name="mark_per_question" class="form-control" id="inputDefault" value="{{$exam->mark_per_question}}">
										</div>
									</div>
									<div class="form-group">
										<div class="checkbox">
										    <label class="col-md-2 control-label">Negative Marking</label>
										    <div class="col-md-6">
											  <input type="checkbox" id="negative" name="negative_marking" value="1" {{ $exam->negative_marking == 1 ? 'checked' : '' }}>
										    </div>
										</div>
									</div>

									
										<div class="form-group" id="negative_mark">
											<label class="col-md-2 control-label" for="inputDefault">Negative Mark Per Question</label>
											<div class="col-md-6">
												<input type="number" step="0.01" name="negative_mark_per_question" class="form-control" id="inputDefault" value="{{$exam->negative_mark_per_question}}">
											</div>
										</div>
									

									

									<button type="submit" class="mb-xs mt-xs mr-xs btn btn-success pull-right">Edit Exam</button>
									
						

								</form>	
							</div>
						</section>
@endsection

@section('custom-js')
<script src="{{asset('assets/backend/vendor/select2/select2.js')}}"></script>
<script src="{{asset('assets/backend/vendor/jquery-autosize/jquery.autosize.js')}}"></script>
<script src="{{asset('assets/backend/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js')}}"></script>

<script src="{{asset('assets/backend/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js')}}"></script>
<script src="{{asset('assets/backend/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js')}}"></script>
<script src="{{asset('assets/backend/vendor/select2/select2.js')}}"></script>
<script src="{{asset('assets/backend/vendor/bootstrap-multiselect/bootstrap-multiselect.js')}}"></script>
<script src="{{asset('assets/backend/vendor/jquery-maskedinput/jquery.maskedinput.js')}}"></script>
<script src="{{asset('assets/backend/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js')}}"></script>
<script src="{{asset('assets/backend/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script>
<script src="{{asset('assets/backend/vendor/bootstrap-timepicker/js/bootstrap-timepicker.js')}}"></script>
<script src="{{asset('assets/backend/vendor/fuelux/js/spinner.js')}}"></script>
<script src="{{asset('assets/backend/vendor/dropzone/dropzone.js')}}"></script>
<script src="{{asset('assets/backend/vendor/bootstrap-markdown/js/markdown.js')}}"></script>
<script src="{{asset('assets/backend/vendor/bootstrap-markdown/js/to-markdown.js')}}"></script>
<script src="{{asset('assets/backend/vendor/bootstrap-markdown/js/bootstrap-markdown.js')}}"></script>
<script src="{{asset('assets/backend/vendor/codemirror/lib/codemirror.js')}}"></script>
<script src="{{asset('assets/backend/vendor/codemirror/addon/selection/active-line.js')}}"></script>
<script src="{{asset('assets/backend/vendor/codemirror/addon/edit/matchbrackets.js')}}"></script>
<script src="{{asset('assets/backend/vendor/codemirror/mode/javascript/javascript.js')}}"></script>
<script src="{{asset('assets/backend/vendor/codemirror/mode/xml/xml.js')}}"></script>
<script src="{{asset('assets/backend/vendor/codemirror/mode/htmlmixed/htmlmixed.js')}}"></script>
<script src="{{asset('assets/backend/vendor/codemirror/mode/css/css.js')}}"></script>
<script src="{{asset('assets/backend/vendor/summernote/summernote.js')}}"></script>
<script src="{{asset('assets/backend/vendor/bootstrap-maxlength/bootstrap-maxlength.js')}}"></script>
<script src="{{asset('assets/backend/vendor/ios7-switch/ios7-switch.js')}}"></script>

<script src="{{asset('assets/backend/javascripts/forms/examples.advanced.form.js')}}"></script>


<script type="text/javascript">

	$(document).ready(function(){

		$(document).on('change','#student_type',function(){

			var student_type = $(this).val();

			console.log(student_type)

			var op =" "; 

				$.ajax({
					type:'post',
					url:'{{url('student/search_branch')}}',
					data:{'student_type':student_type},
					
					success:function(data){
					
                     console.log(data)
				    op+='<option value="0" selected="true" disabled="true">Select Branch</option>';
					for(var i=0;i<data.length;i++){
						op+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
						console.log(data[i].id);
					}

					$('#branch').html(" ");

					$('#branch').append(op);
					
				},
				error:function(){

				}
			});

			});

	});
	
</script>


<script type="text/javascript">

	$(document).ready(function(){

		$(document).on('change','#branch',function(){

			var branch_id = $(this).val();

			console.log(branch_id)

			var op =" "; 

				$.ajax({
					type:'post',
					url:'{{url('student/search_class')}}',
					data:{'branch_id':branch_id},
					
					success:function(data){
					
                    console.log(data);
				    op+='<option value="0" selected disabled>Select Class</option>';
					for(var i=0;i<data.length;i++){
						op+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
						
					}

					$('#class').html(" ");

					$('#class').append(op);
					
				},
				error:function(){

				}
			});

			});

	});
	
</script>

<script type="text/javascript">

	$(document).ready(function(){

		$(document).on('change','#class',function(){

			var class_id = $(this).val();
			var branch_id = $('#branch').val();
			var student_type = $('#student_type').val();

			var op =" "; 

				$.ajax({
					type:'post',
					url:'{{url('student/search_batch')}}',
					data:{'branch_id':branch_id,'class_id':class_id,'student_type':student_type},
					
					success:function(data){
						console.log(data);

				    op+='<option value="0" selected disabled>Select Batch</option>';
					for(var i=0;i<data.length;i++){
						op+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
						console.log(data[i].id);
					}

					$('#batch').html(" ");

					$('#batch').append(op);
					
				},
				error:function(){

				}
			});

		    var op2 =""; 

				$.ajax({
					type:'post',
					url:'{{url('student/search_subject')}}',
					data:{'class_id':class_id,'student_type':student_type},
					
					success:function(data){
						console.log(data);

				    op2+='<option value="0" selected disabled>Select Subject</option>';
					for(var i=0;i<data.length;i++){
						op2+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
						console.log(data[i].id);
					}

					$('#subject').html(" ");

					$('#subject').append(op2);
					
				},
				error:function(){

				}
			});		

			});

	});
	
</script>


<script type="text/javascript">
	$(document).ready(function() {
         // $("#negative_mark").hide();
	    $('#negative').change(function() {
	    // this will contain a reference to the checkbox   
	    if (this.checked) {
	        $("#negative_mark").show(200);
	    } else {
	        $("#negative_mark").hide(200);
	    }
	    });  
    });
</script>

<script>
$( document ).ready(function() {
    $("#exam_date").datepicker({ 
        format: 'yyyy-mm-dd'
    });
    $("#from-datepicker").on("change", function () {
        var fromdate = $(this).val();
        alert(fromdate);
    });
}); 
</script>


@endsection
