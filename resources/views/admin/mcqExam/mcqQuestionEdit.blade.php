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
						<h2>MCQ Question</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>MCQ Question</span></li>
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
						
								<h2 class="panel-title">Add MCQ Question</h2>
							</header>
							<div class="panel-body">
							    <form class="" action="{{action('AdminMCQExamController@update_mcq_question',$question->id)}}" method="post">
									@csrf
									<div class="form-group">
										<label class="col-md-3 control-label" for="inputDefault">Question Number</label>
										<div class="col-md-9">
											<input type="text" name="question_number" class="form-control" id="inputDefault" value={{$question->question_number}}>
										</div>
									</div>
									<div class="form-group mb-3">
									    <label class="col-md-3 control-label">Question</label>
										    <div class="col-md-9">
												<textarea name="question_title" id="editor" rows="10">{{$question->question_title}}
												</textarea>
											</div>
									</div>

									<div class="form-group mb-3">
									    <label class="col-md-3 control-label">Enter Choices</label>

										<table class="table table-bordered table-striped mb-none" id="datatable-default">
											<thead>
												<tr>
													<th>No</th>
													<th>Correct</th>
													<th>Choice</th>
		                                        </tr>
											</thead>
											<tbody>

												@foreach($question->options as $option)
												
												<tr class="gradeX">
													<td><input type="hidden" name="option_number[]" id="inputDefault" value="{{$option->option_number}}">
														 
													        @if($option->option_number == 1)
													        A
													        @elseif($option->option_number == 2)
													        B
													        @elseif($option->option_number == 3)
													        C
													        @elseif($option->option_number == 4)
													        D
													        @endif
                                                    </td>
													
													<td>
												    <input type="hidden" name="right_answer[{{$loop->index}}]" value="0" />
													<input type="checkbox" id="negative" name="right_answer[{{$loop->index}}]" value="1" {{ $option->right_answer == 1 ? 'checked' : '' }}></td>
													
													<td><textarea name="option_title[]" id="editor{{$loop->index}}" rows="10">{{$option->option_title}}</textarea></td>
												</tr>

												@endforeach

												
											</tbody>
									    </table>  
										    
									</div>

									{{-- <input type="hidden" name="exam_id" value="{{$exam->id}}">  --}}

									<button type="submit" class="mb-xs mt-xs mr-xs btn btn-success pull-right">Update Question</button>
									
						

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

<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>

<script>
       CKEDITOR.replace('editor', {
            {{--filebrowserUploadUrl: '{{ asset('backend/ckeditor/ck_upload.php') }}',--}}
            filebrowserUploadUrl: '{{route('admin.uploadCqImage', ['_token' => csrf_token() ])}}',
            filebrowserUploadMethod: 'form'
        });
</script>
<script>
       CKEDITOR.replace('editor0', {
            {{--filebrowserUploadUrl: '{{ asset('backend/ckeditor/ck_upload.php') }}',--}}
            filebrowserUploadUrl: '{{route('admin.uploadCqImage', ['_token' => csrf_token() ])}}',
            filebrowserUploadMethod: 'form'
        });
</script>
<script>
       CKEDITOR.replace('editor1', {
            {{--filebrowserUploadUrl: '{{ asset('backend/ckeditor/ck_upload.php') }}',--}}
            filebrowserUploadUrl: '{{route('admin.uploadCqImage', ['_token' => csrf_token() ])}}',
            filebrowserUploadMethod: 'form'
        });
</script>
<script>
       CKEDITOR.replace('editor2', {
            {{--filebrowserUploadUrl: '{{ asset('backend/ckeditor/ck_upload.php') }}',--}}
            filebrowserUploadUrl: '{{route('admin.uploadCqImage', ['_token' => csrf_token() ])}}',
            filebrowserUploadMethod: 'form'
        });
</script>
<script>
       CKEDITOR.replace('editor3', {
            {{--filebrowserUploadUrl: '{{ asset('backend/ckeditor/ck_upload.php') }}',--}}
            filebrowserUploadUrl: '{{route('admin.uploadCqImage', ['_token' => csrf_token() ])}}',
            filebrowserUploadMethod: 'form'
        });
</script>
@endsection
