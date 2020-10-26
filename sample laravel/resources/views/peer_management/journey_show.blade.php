@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('journeys.index')}}">{{ __('Peers') }}</a></li>
			<li><a href="{{route('journeys.index')}}">{{ __('View Passport') }}</a></li>
			<li class="active"><a>{{ __('View Journey') }}</a></li>
		</ul>
	</div>
      <!-- Main row -->
	<div class="page-content peers journey_content"> 
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
								<input disabled type="text" name="journey_name" class="form-control" id="inputName" value="{{old('journey_name',$journey->journey_name)}}" placeholder="Enter Journey Name">
							</div>
							<div class="form-group">
							   <label for="inputAssignedByName">{{ __('Journey Assigned By') }}</label>
								<input disabled type="text" name="assigned_by" class="form-control" id="inputAssignedByName" value="{{old('journey_name',$journey->creator())}}" placeholder="Enter Assigned By">
							</div>	
							<div class="form-group">
							   <label for="inputPointEarned">{{ __('Points Earned') }}</label>
								<input disabled type="text" name="pointEarned" class="form-control" id="inputPointEarned" value="{{old('journey_name',$journey->creator())}}" placeholder="Enter Points Earned">
							</div>
						</div>
						<div class="mlj_rgt_field col-md-8 pl-5">
							<div class="form-group">
								<label for="inputDescriptionName">{{ __('Description') }}</label>
								<textarea disabled name="journey_description" class="form-control">{{old('journey_description', $journey->journey_description)}}
								</textarea>
							</div>
							<div class="row m-0">
								<div class="col-md-6 p-0 pr-5">
									@php($complete_percentage = ($journey->progress()) ? $journey->progress()->complete_percentage : 0)
									<div class="form-group">
										<label for="inputProgressName">{{ __('Progress') }}</label>
										<div id="inputProgressName" class="progress">				
											<div class="progress-bar" style="width:{{$complete_percentage}}%"><span>{{($complete_percentage != "") ? $complete_percentage."%" : ""}}</span></div>
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
			<a href="{{ back_url(route('journeys.index')) }}" class="btn btn-green">{{ __('Back') }}</a>
			<a href="{{ back_url(route('journeys.index')) }}" class="btn btn-blue">{{ __('View Journey') }}</a>
		</div>
		<div id="journeyBreakDown"></div>
		@include('peer_management/peer_milestone_list')
	</div>
</div>
@endsection
