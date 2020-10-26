@extends('layouts.app')
@section('content')

<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('journeys.index')}}">{{ __('Assigned Learning Journey List') }}</a></li>
			<li class="active"><a>{{ __('Edit Journey') }}</a></li>
		</ul>
	</div>
	<div class="page-content journey_content"> 
		 <form method="POST" class="ajax-form" id="journeyUpdateForm" action="{{route('journeys.update',[$journey->id])}}" role="form" enctype="multipart/form-data">
			<input type="hidden" name="journey_type_id" value="{{$journey->journey_type_id}}"/>
			<input type="hidden" id="addJourneyStatus" name="status" value="{{ $journey->status }}" />
              @csrf
			{{ method_field('PUT')}}
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>{{ __('Edit Journey') }}</h2>
				</div>
				<div class="white-content">
					<h3>{{ __('Learning Journey') }}</h3>
					<div class="inner-content form-all-input">
						<div class="row m-0">
							<div class="mlj_lft_field col-md-4 p-0 pr-5">
								<div class="form-group">
									<label for="inputName">{{ __('Journey Name') }} <span class="required">*</span></label>
									<input type="text" name="journey_name" maxlength="64" class="form-control" id="inputName" value="{{old('journey_name',$journey->journey_name)}}" placeholder="Enter Journey Name">
									@error('journey_name')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								<div class="form-group">
									<label for="AssignedTo">{{ __('Assigned To') }}</label>
									<input type="text" disabled class="form-control" id="AssignedTo" value="{{$assigned_to->name}} {{(($assigned_to->type != 'user') ? "(".ucfirst($assigned_to->type).")" : "") }}">
								</div>
								<div class="form-group">
									<label for="inputName">{{ __('Visibility') }} <span class="required">*</span></label>
									<select name="journey_visibility" class="form-control select2" "{{old('visibility')}}" >
										<option value="">Choose Visibility </option>
										<option {{$journey->visibility == 'private' ? 'selected' : ""}} value="private">Private</option>
										<option {{$journey->visibility == 'public' ? 'selected' : ""}} value="public">Public</option>
									</select>   
									@error('journey_visibility')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								<div class="form-group inputCompulOpt "> 
								   <label for="inputJourneyCompulOpt">{{ __('Compulsory or Optional') }} <span class="required">*</span></label>
									<select id="inputJourneyCompulOpt" name="journey_read" class="form-control select2">
										<option value="">Choose Compulsory or Optional</option>
										<option {{$journey->read == 'optional' ? 'selected' : ""}} value="optional" >Optional</option>
										<option {{$journey->read == 'compulsory' ? 'selected' : ""}} value="compulsory" >Compulsory</option>
									</select>
								</div>
							</div>
							<div class="mlj_rgt_field col-md-8 pl-5">
								<div class="form-group">
								   <label for="inputName">{{ __('Description') }} <span class="required">*</span></label>
									<textarea name="journey_description" maxlength="1024" class="form-control" placeholder="Enter Journey Description"> {{old('journey_description', $journey->journey_description)}}</textarea>   
									@error('journey_description')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div class="btn-footer">
				@if(($journey->created_by == user_id() && auth()->user()->hasPermissionTo('edit_journeys')))
				<button type="button" onclick="resetForm()" class="btn btn-grey">{{ __('Restore') }}</button>
				@endif
				<a href="{{ back_url(route('journeys.index')) }}" class="btn btn-green">{{ __('Back') }}</a>
				@if(($journey->created_by == user_id() && auth()->user()->hasPermissionTo('edit_journeys')))
				<button type="button" id="journeyFormSaveBtn" class="btn btn-blue">{{ __('Save') }}</button>
				@endif
			</div>
		</form>
		<div id="journeyBreakDown"></div>
		@php( $journey_type_id  = $journey->journey_type_id)	
		@include('journey_management/milestone_list')
	</div>
</div>
@endsection
