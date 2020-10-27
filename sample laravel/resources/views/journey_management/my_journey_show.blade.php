@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('journeys.index')}}">{{ __('My Learning Journey List') }}</a></li>
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
							<div class="form-group">
							   <label for="inputName">{{ __('Journey Type') }}</label>
								<select disabled name="journey_type_id" class="form-control" "{{old('journey_type_id')}}" >
									<option value="">Select option</option>
									@foreach($journey_types as $type)
									<option  {{$journey->journey_type_id == $type->id ? 'selected' : ""}} value="{{ $type->id }}">{{$type->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group">
							   <label for="inputCreatedDateName">{{ __('Created Date') }}</label>
								<input disabled type="text" name="created_date" class="form-control" id="inputCreatedDateName" value="{{old('created_date',get_date($journey->created_at))}}" placeholder="Enter journey name">
							</div>
							
							<div class="form-group">
							   <label for="inputAssignedByName">{{ __('Journey Assigned By') }}</label>
								<input disabled type="text" name="assigned_by" class="form-control" id="inputAssignedByName" value="{{old('journey_name',$journey->creator())}}" placeholder="Enter journey name">
							</div>	
							@php($complete_percentage = ($journey->progress()) ? $journey->progress()->complete_percentage : 0)
							<div class="form-group">
								<label for="inputProgressName">{{ __('Progress') }}</label>
								<div id="inputProgressName" class="progress">				
									<div class="progress-bar" style="width:{{$complete_percentage}}%"><span>{{($complete_percentage != "") ? $complete_percentage."%" : ""}}</span></div>
								</div>
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
									<div class="form-group">
										<label for="inputName">{{ __('Visibility') }}</label>
										<select disabled name="visibility" class="form-control select2" "{{old('visibility')}}" >
											<option value="">Select option</option>
											<option {{$journey->visibility == 'private' ? 'selected' : ""}} value="private">Private</option>
											<option {{$journey->visibility == 'public' ? 'selected' : ""}} value="public">Public</option>
										</select>
									</div>
								</div>
								<div class="col-md-6 p-0 pl-5">
									<div class="form-group">
										<label for="inputName">{{ __('Compulsory or Optional') }}</label>
										<select disabled name="read" class="form-control select2" "{{old('visibility')}}" >
											<option value="">Select option</option>
											<option {{$journey->read == 'optional' ? 'selected' : ""}} value="optional">Optional</option>
											<option {{$journey->read == 'compulsory' ? 'selected' : ""}} value="compulsory">Compulsory</option>
										</select>
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
			@if($journey->journey_type_id == 1 && (($journey->created_by == user_id() && auth()->user()->hasPermissionTo('edit_journeys')) || auth()->user()->hasPermissionTo('edit_others_journeys')))
			<a href="{{route('journeys.edit',[encode_url($journey->id)])}}" class="btn btn-blue">{{ __('Edit') }}</a>
			@endif
		</div>
		<div id="journeyBreakDown"></div>		
		@php( $journey_type_id  = $journey->journey_type_id)	
		@include('journey_management/milestone_list')
	</div>
</div>
@endsection