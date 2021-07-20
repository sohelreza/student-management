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


<style>

body{
   background: -webkit-linear-gradient(left, #3931af, #00c6ff);
}
.emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
}
.proile-rating{
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
}
.proile-rating span{
    color: #495057;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
}
</style>

@endsection

@section('content')
                    <header class="page-header">
						<h2>View Student </h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>View Student</span></li>
							</ol>
					    </div>
					</header>

                    
					<section class="panel">
							<div class="row">
			                    <div class="col-md-4">
			                        <div class="profile-img">
			                        	@if($student->image == null)
										    <img src="{{ asset('images/person4.jpg') }}" alt=""/>
									    @elseif($student->image != null)
											<img src='{{ asset('img/'.$student->image) }}'>
												
										@endif
			                          
			                        </div>
			                    </div>
			                    <div class="col-md-6">
			                        <div class="profile-head">
			                            <ul class="nav nav-tabs" id="myTab" role="tablist">
			                                <li class="nav-item">
			                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
			                                </li>
			                                <li class="nav-item">
			                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
			                                </li>
			                                <li class="nav-item">
			                                    <a class="nav-link" id="subject-tab" data-toggle="tab" href="#subject" role="tab" aria-controls="profile" aria-selected="false">Subject</a>
			                                </li>
			                            </ul>
			                        </div>
			                    </div>
			                </div>
			                <div class="row">
			                    <div class="col-md-4">
			                        <div style="font-weight: 900" class="profile-work text-center">
			                            <h5>Name: {{$student->first_name}} {{$student->last_name}}</h5>
			                            <h5>Registration Id: {{$student->registration_id}}</h5>
			                          
			                        </div>
			                    </div>
			                    <div class="col-md-8">
			                        
			                       <div style="margin-top: -150px" class="tab-content profile-tab" id="myTabContent"> 
				                       
				                       <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Phone</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{$student->phone}}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Class</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{$student->classname->name}}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Branch</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{$student->branch->name}}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Batch</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{$student->batch->name}}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Student Type</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>
	                                                	@if($student->student_type == 0)
														 Offline
														@elseif($student->student_type == 1)
														 Online
														
														@endif
											        </p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Date of Addmission</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{$student->date_of_addmission}}</p>
	                                            </div>
	                                        </div>
	                                    
	                                    </div> 

	                                    <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="home-tab">
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Date of Birth</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{($student->profile) ? $student->profile->date_of_birth: ''  }}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Gender</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{($student->profile) ? $student->profile->gender: ''  }}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Zoom Acooun Id</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{($student->profile) ? $student->profile->zoom_id: ''  }}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Institution</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{($student->profile) ? $student->profile->institution: ''  }}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Father's Name</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{($student->profile) ? $student->profile->father_name: ''  }}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Father's Phone</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{($student->profile) ? $student->profile->father_phone: ''  }}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Mother's Name</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{($student->profile) ? $student->profile->mother_name: ''  }}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Mother's Name</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{($student->profile) ? $student->profile->mother_phone: ''  }}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Present Address</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{($student->profile) ? $student->profile->present_address: ''  }}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Permanent Address</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{($student->profile) ? $student->profile->permanent_address: ''  }}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Gaurdian Name</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{($student->profile) ? $student->profile->gaurdian_name: ''  }}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Gaurdian Relation</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{($student->profile) ? $student->profile->gaurdian_relation: ''  }}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Gaurdian Phone</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{($student->profile) ? $student->profile->gaurdian_phone: ''  }}</p>
	                                            </div>
	                                        </div>
	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>Gaurdian Address</label>
	                                            </div>
	                                            <div class="col-md-6">
	                                                <p>{{($student->profile) ? $student->profile->gaurdian_address: ''  }}</p>
	                                            </div>
	                                        </div>
	                                        
	                                    </div> 


	                                    <div class="tab-pane" id="subject" role="tabpanel" aria-labelledby="home-tab">
	                                        
	                                        @foreach($student->subjects as $subject)

	                                        <div class="row">
	                                            <div class="col-md-6">
	                                                <label>{{$subject->subject->name}}</label>
	                                            </div>
	                                            
	                                        </div>
	                                        
	                                        @endforeach
	                                       
	                                        
	                                    
	                                    </div>

	                                </div>   
			                           
                               </div>
                            </div>
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
