@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a>My Trends</a></li>
			<li class="active"><a href="javascript:">Respond</a></li>
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
				  <a class="nav-link" href="{{route('tempchecks.trend_index')}}"  data-tabName="Latest Tempcheck">Latest Tempcheck</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link active" data-toggle="tab" href="#myTrend"  data-tabName="My Trends">My Trends</a>
				</li>
			 </ul>
			<div class="tab-content">
				<div id="myTrend" class="tab-pane active">
					<!-- left column -->
					<form method="POST" class="ajax-form" id="tempcheckAddForm" action="{{route('tempchecks.store_rating')}}" role="form" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="tempcheck_id" value="{{ Request::route('id') }}">
					<div class="white-box aligCenter780">	
						<div class="white-box-head">	
							<h2>My Trends</h2>
						</div>
						<div class="white-content">
								<div class="inner-content form-all-input">
									<div class="row">
										 <div class="col-md-12  pb-5">
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
													<div class="form-group">
														<label>How Do You Feel This Week?</label>
														<ul class="radioTempCheck widthCheck"> 
														@foreach($ratings as $rating)
														<li><label><input type="radio" name="rating" id="inputGender1" {{$assignment->rating == $rating ? 'Checked' : ''}} value="{{ $rating }}"> <i></i>{{ $rating }}</label></li>
														@endforeach
														</ul>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group tempchecksComment">
														<label for="inputCommentName">{{ __('Comments') }}</label>
														<textarea name="comment" id="inputCommentName" class="form-control"  />{{ $assignment->comment }}</textarea>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
						</div>
					</div>  
					<div class="btn-footer mt-5">
						<button type="reset" class="btn btn-grey">Clear</button>
						<a href="{{back_url(route('tempchecks.assigned_index'))}}" class="btn btn-green">{{ __('Back') }}</a>
						<button type="submit" class="btn btn-blue">Save</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
