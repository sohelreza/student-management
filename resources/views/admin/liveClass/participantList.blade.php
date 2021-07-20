@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
@endsection

@section('content')
   <header class="page-header">
						<h2>Participant List</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Participant List</span></li>
							</ol>
					    </div>
					</header>

					@php
						$attendance=App\ZoomMeetingAttendance::where('meeting_id',$meeting->id)->get();
						
                    @endphp
					@if (sizeof($attendance) > 0)
					<div class="row ml-2">
				        <div class="alert alert-danger col-sm-6">
				            Attendace Already taken
				        </div>
			        </div>
			        @endif

					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
								
								</div>
						
								<h2 class="panel-title">Participant</h2>
							</header>
							
							<div class="panel-body">

                                <form action="{{ action('ZoomClass@submit_attendance') }}" method="POST">
							    @csrf


								<table class="table table-bordered table-striped mb-none" id="">
									<thead>
										<tr>
											<th>Id</th>
											<th>Name</th>
											<th>User Email</th>
											<th>Duration(Minute)</th>
											<th>Action</th>
										    
									</thead>
										</tr>
									<tbody>

										

										@foreach($groups as $group)
										<tr class="gradeX">
											<td>{{$group['id']}}</td>
											<td>{{$group['name']}}</td>
											<td>{{$group['user_email']}}</td>
											<td>{{round($group['duration']/60,2)}}</td>
                                            <td>
												<input type="hidden" name="student_email[]" value="{{$group['user_email']}}">
												<input type="hidden" name="duration[]" value="{{$group['duration']}}">
												<input type="hidden" name="meeting_id[]" value="{{$meeting->id}}">


												@php
													// $student_attendance=App\ZoomMeetingAttendance::where('meeting_id',$meeting->id)->get();
													
							                    @endphp
												@if (sizeof($attendance) > 0)
												
												@else

												<label>
												<input type="radio" name="status[{{$loop->index}}]" id="optionsRadios1" value="1" checked="true">
												Present
												</label>

												<label>
												<input type="radio" name="status[{{$loop->index}}]" id="optionsRadios2" value="0">
												Absent
												</label>
										        
										        @endif

												
                                                
											</td>
										
											
										</tr>
										@endforeach
									</tbody>
								</table>
								@if (sizeof($attendance) <= 0)
								<button type="submit" class="btn btn-primary pull-right mt-4">Save Attendance</button> 
							     @endif
							</form>
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
