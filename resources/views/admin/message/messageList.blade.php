@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
@endsection

@section('content')
   <header class="page-header">
						<h2>Messages</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Messages</span></li>
							</ol>
					    </div>
					</header>

					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
								<a class="" href="{{ action('AdminMessageController@create') }}"><i class="fa fa-plus"></i> Add
								</a>
								</div>
						
								<h2 class="panel-title">Messages</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Title</th>
											<th>Date</th>
											<th>Message</th>
											<th>Branch</th>
											<th>Class</th>
											<th>Batch</th>
											<th>Status</th>
                                            <th>Action</th>
										    
									</thead>
										</tr>
									<tbody>

										@foreach($messages as $message)
										<tr class="gradeX">
											<td>{{$message->title}}</td>
											<td>{{$message->date}}</td>
											<td>{{$message->message}}</td>
											@if($message->all_student==1)
												<td>All</td>
												<td>All</td>
												<td>All</td>
											@else
												<td>{{$message->branchname->name}}</td>
												<td>{{$message->classname->name}}</td>
												<td>{{$message->batchname->name}}</td>
											@endif

											<td>
												@if($message->status==0)
												Inactive
											    @elseif($message->status==1)
											    Active
											    @endif
											</td>
											
											<td>

												
												
                                                   
												<a href="{{ route('messages.edit',$message->id) }}" class="mb-xs mt-xs mr-xs btn btn-primary" >Edit</a>

												<form method="post" action="{{ route('messages.destroy',$message->id) }}"  style="display: inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete')">Delete</button>
                                                </form>
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
