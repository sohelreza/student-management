@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
@endsection

@section('content')
   <header class="page-header">
						<h2>Online Students</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.students')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Online Students</span></li>
							</ol>
					    </div>
					</header>

                     @include('admin.layout.message')
                     <section class="panel">
							<header class="panel-heading">
						        <h2 class="panel-title">Search Filter</h2>
							</header>
							<div class="panel-body">
                                <form method="get" action="{{action('AdminOnlineStudentController@listSearch')}}">
			                    @csrf
			                        <div class="form-group">
										<label class="col-md-2 control-label" for="inputSuccess">Branch Type</label>
										<div class="col-md-6">
											<select class="form-control mb-md" name="student_type" id="student_type">
												<option selected="true">Select Type</option>
												<option value="0">Offline</option>
												<option value="1">Online</option>
												
											</select>
						
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputSuccess">Branch</label>
										<div class="col-md-6">
											<select class="form-control mb-md" name="branch_id" id="branch">
												<option value="0" selected="true" disabled="true">Select Branch</option>
												
											</select>
						
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputSuccess">Class</label>
										<div class="col-md-6">
											<select class="form-control mb-md" name="class_id" id="class">
												<option value="0" selected="true" disabled="true">Select Class</option>
												
											</select>
						
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label" for="inputSuccess">Batch</label>
										<div class="col-md-6">
											<select class="form-control mb-md" name="batch_id" id="batch">
												<option value="0" selected="true" disabled="true">Select Batch</option>
												
											</select>
						
										</div>
									</div>

									<button type="submit" class="mb-xs mt-xs mr-xs btn btn-success">Search</button>                        
			                                                
			                    </form>
								
							</div>
					</section>
					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
								</div>
						
								<h2 class="panel-title">Online Students List</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Image</th>
											<th>Name</th>
											<th>Registration ID</th>
											<th>Form No.</th>
											<th>Phone</th>
											<th>Class</th>
											<th>Batch</th>
											<th>Branch</th>
											<th>Date of Addmission</th>
											<th>Payment Due Date</th>
											<th>Total</th>
											<th>Paid</th>
											<th>Due</th>
											<th>Payment Status</th>
											<th>Action</th>

										    
										</tr>
									</thead>
									<tbody>
										@foreach($students as $student)
										<tr class="gradeX">
											<td>
												@if($student->image == null)
												    <img style="height: 80px;width: 80px" src="{{ asset('images/person4.jpg') }}" alt=""/>
											    @elseif($student->image != null)
													<img src='{{ asset('img/'.$student->image) }}'>
														
												@endif
											</td>
											<td>{{$student->first_name}} {{$student->last_name}}</td>
											<td>{{$student->registration_id}}</td>
											<td>{{$student->form_number}}</td>
											<td>{{$student->phone}}</td>
											<td>{{$student->classname->name}}</td>
											<td>{{$student->batch->name}}</td>
											<td>{{$student->branch->name}}</td>
											<td>
                                                @php
												 $date_of_addmission = date('d-m-Y', strtotime($student->date_of_addmission))
                                                @endphp
												{{$date_of_addmission}}
											</td>
											<td>@php
												 $next_payment_date = date('d-m-Y', strtotime($student->next_payment_date))
                                                @endphp
												
												@if($student->next_payment_date == null)
												     <span class="text-danger">Student Not Approved</span>
												@else
													 {{$next_payment_date}} 
											    @endif
											</td>
											@php
											$due=App\StudentPayment::where('student_id',$student->id)->orderBy('id', 'desc')->first();
                                            @endphp
											<td>
												{{$due->total_amount}}
											</td>
											<td>
												{{$due->paid_amount}}
											</td>
											<td>
												{{$due->due_amount}}
											</td>
											<td>
												@php
												$date = new DateTime($student->next_payment_date);
                                                $now = new DateTime();
                                                @endphp

                                                @if($date < $now)
                                                  <span class="text-danger">Due</span>
                                                @else
                                                 <span class="text-success">Paid</span>
                                                @endif
											</td>
                                            
                                            
											<td>
												<a href="{{ route('admin.student_view',$student->id) }}" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary" >View</a>
												<a href="{{ route('admin.student_view_payment',$student->id) }}" class="mb-xs mt-xs mr-xs btn btn-sm btn-danger" >Payments</a>
												<a href="{{ route('admin.student_change_due_date',$student->id) }}" class="mb-xs mt-xs mr-xs btn btn-sm btn-danger" >Change Due Date</a>
												<a href="{{ route('admin.online_student_registration_pdf',$student->id) }}" class="mb-xs mt-xs mr-xs btn btn-sm btn-danger" >Registration Pdf</a>


                                                @if($student->next_payment_date == null)
	                                                <form method="post" action="{{ route('admin.online_student_delete',$student->id) }}"  style="display: inline">
	                                                @csrf
	                                                @method('delete')
	                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete')">Delete</button>
	                                                </form>
                                                @endif

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
@endsection
