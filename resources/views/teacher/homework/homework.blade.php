@extends('admin.layout.master')

@section('custom-css')
<link rel="stylesheet" href="{{asset('assets/backend/vendor/select2/select2.css')}}" />
<link rel="stylesheet" href="{{asset('assets/backend/vendor/jquery-datatables-bs3/assets/css/datatables.css')}}" 
/>
<link rel="stylesheet" href="{{asset('assets/backend/vendor/magnific-popup/magnific-popup.css')}}" />

@endsection

@section('content')
   <header class="page-header">
						<h2>Homework</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('teacher.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Homework</span></li>
							</ol>
					    </div>
					</header>

					<section class="panel">
							<header class="panel-heading">
								<div class="panel-actions">
									<a href="#" class="fa fa-caret-down"></a>
									<a href="#" class="fa fa-times"></a>
								</div>
						
								<h2 class="panel-title">Homework</h2>
							</header>
							<div class="panel-body">
								<table class="table table-bordered table-striped mb-none" id="datatable-default">
									<thead>
										<tr>
											<th>Student Name</th>
											<th>Teacher</th>
											<th>Class</th>
											<th>Batch</th>
											<th>Branch</th>
											<th>Subject</th>
											<th>Title</th>
											<th>Submission Date</th>
											<th>Score</th>
											<th>Evaluation Date</th>
											<th>Action</th>

										    
										</tr>
									</thead>
									<tbody>
										@foreach($homeworks as $homework)
										<tr class="gradeX">
											<td>{{$homework->student->first_name}} {{$homework->student->last_name}}</td>
											<td>{{$homework->teacher->name}}</td>
											<td>{{$homework->class->name}}</td>
											<td>{{$homework->batch->name}}</td>
											<td>{{$homework->branch->name}}</td>
											<td>{{$homework->subject->name}}</td>
											<td>{{$homework->title}}</td>
											<td>{{$homework->submission_date}}</td>
											<td>{{$homework->score}}</td>
											<td>{{$homework->evaluation_date}}</td>
											<!-- @foreach($homework->images as $image)
											<td><img src="{{'homework/'.$image->homework_image}}" width="100%" height="100%"></td>
											@endforeach -->
											<td><a href="{{ route('teacher.pdfHomework',$homework->id) }}"  class="mb-xs mt-xs mr-xs btn btn-default" >PDF</a>
										    <a href="{{ route('teacher.evaluateHomework',$homework->id) }}"  class="mb-xs mt-xs mr-xs btn btn-default" >Evaluate</a>											</td>

											<div id="modalForm" class="modal-block modal-block-primary mfp-hide">
													<section class="panel">
														<header class="panel-heading">
															<h2 class="panel-title">Evaluate</h2>
														</header>
														<div class="panel-body">
															<form id="demo-form" class="form-horizontal mb-lg" novalidate="novalidate">
																<div class="form-group mt-lg">
																	<label class="col-sm-3 control-label">Name</label>
																	<div class="col-sm-9">
																		<input type="number" name="name" class="form-control" placeholder="Type your name..." required/>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-sm-3 control-label">Email</label>
																	<div class="col-sm-9">
																		<input type="email" name="email" class="form-control" placeholder="Type your email..." required/>
																	</div>
																</div>
															</form>
														</div>
														<footer class="panel-footer">
															<div class="row">
																<div class="col-md-12 text-right">
																	<button class="btn btn-primary modal-confirm">Submit</button>
																	<button class="btn btn-default modal-dismiss">Cancel</button>
																</div>
															</div>
														</footer>
													</section>
												</div>

											</div>
											
											{{--<td><img src="{{ URL::to('/homework/20200322_105930.jpg') }}" width="50" height="50"></td> --}}
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
<script src="{{asset('assets/backend/vendor/jquery-placeholder/jquery.placeholder.js')}}"></script>
<script src="{{asset('assets/backend/javascripts/ui-elements/examples.modals.js')}}"></script>

<script>
// $('#datatable-default').dataTable( {
//   "order": [[ 6, "desc" ]]
// });
</script>

@endsection
