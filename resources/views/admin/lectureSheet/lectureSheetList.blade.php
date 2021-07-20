@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" />
@endsection

@section('content')
   <header class="page-header">
						<h2>Lecture Sheets</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('admin.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Lecture Sheets</span></li>
							</ol>
					    </div>
					</header>

					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
								<a class="" href="{{ action('AdminLectureSheetController@create') }}"><i class="fa fa-plus"></i> Add
								</a>
								</div>
						
								<h2 class="panel-title">Lecture Sheets</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Name</th>
											<th>Date</th>
											<th>Branch</th>
											<th>Class</th>
											<th>Batch</th>
											<th>Subject</th>
											<th>File</th>
                                            <th>Action</th>
										    
									</thead>
										</tr>
									<tbody>

										@foreach($lectures as $lecture)
										<tr class="gradeX">
											<td>{{$lecture->name}}</td>
											<td>{{$lecture->date}}</td>
											<td>{{$lecture->branchname->name}}</td>
											<td>{{$lecture->classname->name}}</td>
											<td>{{$lecture->batchname->name}}</td>
											<td>{{$lecture->subjectname->name}}</td>
											
											<td>
												<a href="{{url('/admin/lecture_download')}}/{{$lecture->file}}" class="text-success" > {{$lecture->file}}</a></td>

												{{-- <embed
												    src="{{ action('AdminContentController@content_view', ['id'=> $content->id]) }}"
												    style="width:600px; height:800px;"
												    frameborder="0"
												> --}}

												{{-- <iframe src="{{url('/admin/content_view')}}/{{$content->file}}" width="100%" height="600"></iframe> --}}

												{{-- <a href="http://docs.google.com/gview?url={{ URL::to($content->file) }}" target="_blank">{{$content->file}}</a> --}}

												{{-- <a href="{{url('/admin/content_view')}}/{{$content->id}}" class="text-success" > View Content</a></td> --}}

												{{-- <a href="{{ asset('content/resume.pdf') }}">Open the pdf!</a> --}}
											<td>
												
                                                   
												<a href="{{ route('lecture_sheets.edit',$lecture->id) }}" class="mb-xs mt-xs mr-xs btn btn-primary" >Edit</a>

												<form method="post" action="{{ route('lecture_sheets.destroy',$lecture->id) }}"  style="display: inline">
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
