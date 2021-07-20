@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
@endsection

@section('content')
   <header class="page-header">
						<h2>Live Classes</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Live Classes</span></li>
							</ol>
					    </div>
					</header>

					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
								<a class="" href="{{ action('ZoomClass@add') }}"><i class="fa fa-plus"></i> Add
								</a>
								</div>
						
								<h2 class="panel-title">Live Classes</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Class Topic</th>
											<th>Teacher</th>
											<th>Api Name</th>
											<th>Time</th>
											<th>Duration</th>
											<th>Branch Type</th>
											<th>Branch</th>
											<th>Class</th>
											<th>Batch</th>
											<th>Subject</th>
											<th>Status</th>
                                            <th>Action</th>
										    
									</thead>
										</tr>
									<tbody>

										@foreach($data['classes'] as $meeting)
										<tr class="gradeX">
											<td>{{$meeting->topic}}</td>
											<td>{{$meeting->teacher->name}}</td>
											<td>{{$meeting->zoom->zoom_api_name}}</td>
											<td>{{$meeting->when}}</td>
											<td>{{$meeting->duration}} min</td>
											<td>
												@if($meeting->student_type ==1 )
												  Online
												@elseif($meeting->student_type ==0)
												  Offline
												@endif
												
											</td>
											<td>{{$meeting->branchname->name}}</td>
											<td>{{$meeting->classname->name}}</td>
											<td>{{$meeting->batchname->name}}</td>
											<td>{{$meeting->subjectname->name}}</td>

											<td>
												<form action="{{action('ZoomClass@changeStatus')}}" method="post">
												@csrf
													<input type="hidden" name="meeting_id" value="{{$meeting->id}}">
													<select class="form-control mb-md status" name="status">
														<option value="1" {{ $meeting->live_status == 1 ? 'selected' : '' }}>Waiting</option>
														<option value="2" {{ $meeting->live_status == 2 ? 'selected' : '' }}>Live</option>
														<option value="3" {{ $meeting->live_status == 3 ? 'selected' : '' }}>Finnished</option>
												    </select>
												</form>
											
											</td>
											<td>
												@if($meeting->live_status != 3)
                                                   
												<a href="{{$meeting->start_url}}" target="_blank" class="mb-xs mt-xs mr-xs btn btn-default btn-xs " ><i class="fa fa-sign-in"></i> Start Class</a>
										  	    @endif

												<a class="mb-xs mt-xs mr-xs btn btn-default btn-xs" href="{{ action('ZoomClass@delete',$meeting->meeting_id) }}">Delete</a>

												<a class="mb-xs mt-xs mr-xs btn btn-default btn-xs" href="{{ action('ZoomClass@edit',$meeting->id) }}">Edit</a>
                                                
                                                {{-- <a href="{{ url('admin/meetings/participants/'.$meeting->meeting_id) }}" class="mb-xs mt-xs mr-xs btn btn-default btn-xs " ><i class="fa fa-eye"></i> See Meeting Participants</a>

                                                <a href="{{ url('admin/meetings/attendance/'.$meeting->id) }}" class="mb-xs mt-xs mr-xs btn btn-default btn-xs " ><i class="fa fa-eye"></i> See Attendance</a> --}}

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
