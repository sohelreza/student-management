@extends('admin.layout.master')

@section('content')
   <header class="page-header">
						<h2>Dashboard</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="{{route('teacher.dashboard')}}">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Dashboard</span></li>
							</ol>
					    </div>
					</header>

						<div class="row">

					<!-- start: page -->
					<div class="row">
						
						<div class="col-md-6 col-lg-12 col-xl-6">
							<div class="row">
								<div class="col-md-12 col-lg-4 col-xl-4">
									<section class="panel panel-featured-left panel-featured-primary">
										<div class="panel-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-primary">
														<i class="fa fa-user"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">No of students</h4>
														<div class="info">
															<strong class="amount">{{$student}}</strong>
														</div>
													</div>
													{{-- <div class="summary-footer">
														<a class="text-muted text-uppercase" href="{{url('admin/students')}}">(view all)</a>
													</div> --}}
												</div>
											</div>
										</div>
									</section>
								</div>
								<div class="col-md-12 col-lg-4 col-xl-4">
									<section class="panel panel-featured-left panel-featured-primary">
										<div class="panel-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-success">
														<i class="fa fa-user"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">No of admins</h4>
														<div class="info">
															<strong class="amount">{{$admin}}</strong>
														</div>
													</div>
													{{-- <div class="summary-footer">
														<a class="text-muted text-uppercase" href="{{url('admin/admins')}}">(view all)</a>
													</div> --}}
												</div>
											</div>
										</div>
									</section>
								</div>
								<div class="col-md-12 col-lg-4 col-xl-4">
									<section class="panel panel-featured-left panel-featured-primary">
										<div class="panel-body">
											<div class="widget-summary">
												<div class="widget-summary-col widget-summary-col-icon">
													<div class="summary-icon bg-danger">
														<i class="fa fa-user"></i>
													</div>
												</div>
												<div class="widget-summary-col">
													<div class="summary">
														<h4 class="title">No of teachers</h4>
														<div class="info">
															<strong class="amount">{{$teacher}}</strong>
														</div>
													</div>
													{{-- <div class="summary-footer">
														<a class="text-muted text-uppercase" href="{{url('admin/teachers')}}">(view all)</a>
													</div> --}}
												</div>
											</div>
										</div>
									</section>
								</div>
							</div>
						</div>
					</div>

					<!-- end: page -->
@endsection