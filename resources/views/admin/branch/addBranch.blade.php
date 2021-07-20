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
						<h2>Branches</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Branches</span></li>
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
						
								<h2 class="panel-title">Add Branches</h2>
							</header>
							<div class="panel-body">
								<form class="" action="{{action('BranchController@store')}}" method="post">
									@csrf
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputDefault">Name</label>
											<div class="col-md-6">
												<input type="text" class="form-control" name="name" id="inputDefault">
											</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="textareaAutosize">Address</label>
										    <div class="col-md-6">
												<textarea class="form-control" name="address" rows="3" id="textareaAutosize" data-plugin-textarea-autosize></textarea>
											</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputSuccess">Branch Type</label>
										<div class="col-md-6">
											<select class="form-control mb-md" name="student_type" id="student_type">
												<option value="0" selected="true">Offline</option>
												<option value="1">Online</option>
												<option value="2">Both</option>
											
											</select>
						
										</div>
									</div>

									<button type="submit" class="mb-xs mt-xs mr-xs btn btn-success">Add</button>

									
						

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
@endsection
