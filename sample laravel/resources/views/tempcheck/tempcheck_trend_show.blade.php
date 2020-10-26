@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a>Latest Tempcheck List</a></li>
			<li class="active"><a href="javascript:">View</a></li>
		</ul>
	</div>
    <!-- Main row -->
	<div class="page-content tempcheck_content">
		<div class="pageTabTop">
			<ul class="nav nav-tabs" id="joureyTab">
				<li class="nav-item">
				  <a class="nav-link" href="{{route('tempchecks.index')}}" data-tabName="Tempcheck">Tempcheck</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link active"  data-toggle="tab" href="#myTrend" data-tabName="Latest Tempcheck">Latest Tempcheck</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="{{route('tempchecks.assigned_index')}}" data-tabName="My Trends">My Trends</a>
				</li>
			 </ul>
			<div class="tab-content">
				<div id="myTrend" class="tab-pane active">
					<div class="white-box aligCenter780">	
						<ul class="nav nav-tabs" id="graphTab">
							<li class="nav-item">
							  <a class="nav-link" onclick="tempcheckGraph('{{Request::route('id')}}','{{Request::route('user_id')}}')" data-toggle="tab" href="#tempchecksGraph" data-tabName="Tempcheck">Graph</a>
							</li>
							<li class="nav-item">
							  <a class="nav-link active"  data-toggle="tab" href="#tempchecksView" data-tabName="Latest Tempcheck">Latest Tempcheck</a>
							</li>
						 </ul>
						 <div class="tab-content">
							<div id="tempchecksGraph" class="tab-pane ">
								<figure class="highcharts-figure">
									<div id="container"></div>
								</figure>
							</div>
							<div id="tempchecksView" class="tab-pane active">
								<div class="white-content">
									<div class="inner-content form-all-input">
										<div class="row">
											 <div class="col-md-12 pad-zero">
												<div class="row">
													<!--<div class="col-md-6 left-pad pdr-45">
														<div class="form-group">
															<label for="inputFirstName">{{ __('First Name') }}</label>
															<input disabled id="inputFirstName" class="form-control" type="text" value="{{$assignment->user()->first_name}}" /></input>
														</div>
													</div>
													<div class="col-md-6 left-pad pdr-45">
														<div class="form-group">
															<label for="inputLastName">{{ __('Last Name') }}</label>
															<input disabled id="inputLastName" class="form-control" type="text" value="{{$assignment->user()->last_name}}" /></input>
														</div>
													</div>
													<div class="col-md-6 left-pad pdr-45">
														<div class="form-group">
															<label for="inputRoleName">{{ __('Role') }}</label>
															<input disabled id="inputRoleName" class="form-control" type="text" value="{{$assignment->user()->email}}" /></input>
														</div>
													</div>
													<div class="col-md-6 left-pad pdr-45">
														<div class="form-group">
															<label for="inputEmailName">{{ __('Email ID') }}</label>
															<input disabled id="inputEmailName" class="form-control" type="text" value="{{$assignment->user()->email}}" /></input>
														</div>
													</div>-->
													@php($ratings = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10))
													<div class="col-md-12">
														<h5></h5>
														<div class="form-group">
															<label>{{$assignment->question}}?</label>
															<ul class="radioTempCheck grey widthCheck">
																@foreach($ratings as $rating)
																<li><label><input disabled type="radio" name="rating" id="inputGender1" {{$assignment->rating == $rating ? 'Checked' : ''}} value="{{ $rating }}"> <i></i>{{ $rating }}</label></li>
																@endforeach
															</ul>
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group tempchecksComment">
															<label for="inputCommentName">{{ __('Comments') }}</label>
															<textarea disabled id="inputCommentName" class="form-control"  />{{ $assignment->comment }}</textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>  
					<div class="btn-footer">
						<a href="{{back_url(route('tempchecks.trend_index'))}}" class="btn btn-green">{{ __('Back') }}</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
