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
						<h2>Message</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Message</span></li>
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
						
								<h2 class="panel-title">Edit Message</h2>
							</header>
							<div class="panel-body">
								<form class="" action="{{action('AdminMessageController@update',$message->id)}}" method="post" enctype="multipart/form-data">
									@csrf
									<input type="hidden" name="_method" value="PUT">
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputDefault">Title</label>
											<div class="col-md-6">
												<input type="text" class="form-control" name="title" id="inputDefault" value="{{$message->title}}">
											</div>
									</div>

                                    <div class="form-group">
										<label class="col-md-2 control-label">Date</label>
										    <div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
													</span>
													<input type="text" name="date" data-plugin-datepicker class="form-control" id="exam_date" value="{{$message->date}}">
													</div>
											</div>
									</div>
                                    <div class="form-group">
										<label class="col-md-2 control-label" for="textareaAutosize">Message</label>
										    <div class="col-md-6">
												<textarea class="form-control" name="message" rows="3" id="textareaAutosize" data-plugin-textarea-autosize>{{$message->message}}</textarea>
											</div>
									</div>

									<div class="row">
										<div class="col-md-6">

											<div class="form-group">
												<div class="checkbox">
												    <label class="col-md-4 control-label">All Students</label>
														<div class="col-md-6">
															<input type="checkbox" id="negative" name="all_student" value="1" {{ ($message->all_student == 1 )? "checked" : "" }}>
														</div>
												</div>
										    </div>
											
										</div>
										<div class="col-md-6">

											<div class="form-group">
												<label class="col-md-4 control-label" for="inputSuccess">Branch Type</label>
												<div class="col-md-6">
													<select class="form-control mb-md" name="student_type" id="student_type">
														@if($message->all_student == 1)
														        <option selected="true" disabled="true">Select Type</option>
																<option value="0">Offline</option>
																<option value="1">Online</option>
														@else
														   <option value="0" {{ ($message->student_type == 0) ? 'selected="selected"' : '' }} >Offline</option>
														   <option value="1" {{ ($message->student_type == 1) ? 'selected="selected"' : '' }} >Online</option>
														@endif

													</select>
								
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label" for="inputSuccess">Branch</label>
												<div class="col-md-6">
													<select class="form-control mb-md" name="branch" id="branch">

														@if($message->all_student == 1)
		                                                   <option value="0" selected="true" disabled="true">Select Branch</option>
														@else
														   <option value="{{$message->branch}}" selected="true">{{$message->branchname->name}}</option>

														@endif
														
														
													</select>
								
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label" for="inputSuccess">Class</label>
												<div class="col-md-6">
													<select class="form-control mb-md" name="class" id="class">

														@if($message->all_student == 1)
															<option value="0" selected="true" disabled="true">Select Class</option>
														@else
														    <option value="{{$message->class}}" selected="true">{{$message->classname->name}}</option>
		                                                @endif
														
														
													</select>
								
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label" for="inputSuccess">Batch</label>
												<div class="col-md-6">
													<select class="form-control mb-md" name="batch" id="batch">

														@if($message->all_student == 1)
															<option value="0" selected="true" disabled="true">Select Batch</option>
														@else
														     <option value="{{$message->batch}}" selected="true">{{$message->batchname->name}}</option>
														@endif
														
														
													</select>
								
												</div>
											</div>
											
										</div>
									</div>

									<div class="form-group">
										<label class="col-md-2 control-label" for="inputSuccess">Status</label>
											<div class="col-md-6">
												<select class="form-control mb-md" name="status" id="">
													<option selected="true" disabled="true">Select Status</option>
													<option value="1" {{($message->status) == 1 ? 'selected':'' }}>Active</option>
													<option value="0" {{($message->status) == 0 ? 'selected':''}}>Inactive</option>
														
												</select>
								
											</div>
									</div>
									<button type="submit" class="mb-xs mt-xs mr-xs btn btn-success">Update</button>
									
						

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

			var op =" "; 

				$.ajax({
					type:'post',
					url:'{{url('student/search_class')}}',
					data:{'branch_id':branch_id},
					
					success:function(data){
					

				    op+='<option value="0" selected disabled>Select Class</option>';
					for(var i=0;i<data.length;i++){
						op+='<option value="'+data[i].id+'">'+data[i].name+'</option>';
						console.log(data[i].id);
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
					data:{'class_id':class_id,student_type:1},
					
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
