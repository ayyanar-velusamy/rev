@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			@if(Request::route('user_id') == "")
			<li><a href="{{url('\passport')}}">{{ __('Passport') }}</a></li>
			@else
			<li><a href="{{route('peers.index')}}">{{ __('Peers') }}</a></li>
			<li><a href="{{route('users.passport',encode_url(user_id()))}}">{{ __('Passport') }}</a></li>
			@endif
			<li class="active"><a>{{ __('View Journey') }}</a></li>
		</ul>
	</div>
      <!-- Main row -->
	<div class="page-content journey_content"> 
		<div class="white-box">	
			<div class="white-box-head">	
				<h2>{{ __('View Journey') }}</h2>
			</div>
			<div class="white-content">
				<h3>{{ __('Learning Journey') }}</h3>
				<div class="inner-content form-all-input">
					<div class="row m-0">					
						<div class="mlj_lft_field col-md-4 p-0 pr-5">
							<div class="form-group">
							   <label for="inputName">{{ __('Journey Name') }}</label>
								<input disabled type="text" name="journey_name" class="form-control" id="inputName" value="{{old('journey_name',$journey->journey_name)}}" placeholder="Enter journey name">
							</div>
							@if($journey->journey_type_id != 5)
							<div class="form-group">
							   <label for="inputAssignedByName">{{ __('Journey Assigned By') }}</label>
								<input disabled type="text" name="assigned_by" class="form-control" id="inputAssignedByName" value="{{old('journey_name',$journey->creator())}}" placeholder="Enter journey name">
							</div>
							@endif
							@if(Request::route('user_id') == "")
							<div class="form-group">
							   <label for="inputCompletedDateByName">{{ __('Completed Date') }}</label>
								<input disabled type="text" class="form-control" id="inputPointByName" value="{{get_date($point_data->completed_date)}}" >
							</div>
							@endif
							@if($journey->journey_type_id != 5)
							<div class="form-group">
							   <label for="inputPointByName">{{ __('Points Earned') }}</label>
								<input disabled type="text" class="form-control" id="inputPointByName" value="{{$point_data->points}}" >
							</div>
							@endif
						</div>
						<div class="mlj_rgt_field col-md-8 pl-5">
							<div class="form-group">
								<label for="inputDescriptionName">{{ __('Description') }}</label>
								<textarea disabled name="journey_description" class="form-control {{(Request::route('user_id') != "") ? 'desSmall' : '' }}">{{old('journey_description', $journey->journey_description)}}
								</textarea>
							</div>
							@if($journey->journey_type_id != 5)
							<div class="row m-0">
								@if(Request::route('user_id') == "")
								<div class="form-group col-md-6">
								   <label for="inputRatingByName">{{ __('Rating') }}</label>
									<input disabled type="text" class="form-control" id="inputPointByName" value="{{round($point_data->ratings)}} / 5" >
								</div>
								@endif

								@php($complete_percentage = ($journey->progress('user',Request::route('user_id'))) ? $journey->progress('user',Request::route('user_id'))->complete_percentage : 0)
								@php($complete_percentage = ($journey->deleted_at == "" ) ? $complete_percentage : 100)
								<div class="form-group col-md-6">
									<label for="inputProgressName">{{ __('Progress') }}</label>
									<div id="inputProgressName" class="progress">				
										<div class="progress-bar" style="width:{{$complete_percentage}}%"><span>{{($complete_percentage != "") ? $complete_percentage."%" : ""}}</span></div>
									</div>
								</div>
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="btn-footer">
			@if(Request::route('user_id') == "")
				<a href="{{ back_url(route('passport'))}}" class="btn btn-green">{{ __('Back') }}</a>
				@if($journey->deleted_at == '' && $journey->journey_type_id != 5)
				<a href="{{ route('journeys.my_journey',[encode_url($journey->id)])}}" class="btn btn-blue">{{ __('View Learning Journey') }}</a>
				@endif
			@else
				<a href="{{ route('users.passport',[Request::route('user_id')])}}" class="btn btn-green">{{ __('Back') }}</a>
				@if($journey->journey_type_id == 3)
				<a href="{{ route('journeys.show',[encode_url($journey->parent_id)])}}" class="btn btn-blue">{{ __('View Journey') }}</a>
				@endif
			@endif
		</div>
		<div id="journeyBreakDown"></div>
		@php($journey_type_id = $journey->journey_type_id)
		@include('passport_management/milestone_list')
	</div>
</div>
@endsection
