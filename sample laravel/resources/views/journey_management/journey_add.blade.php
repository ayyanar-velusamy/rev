@extends('layouts.app')
@section('content')	
@php( $journey_type_id = ($journey) ? $journey->journey_type_id : '')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			@if($journey_type_id == "" || $journey_type_id == 1)
				<li id="journeyNameBreadcrumb"><a href="{{route('journeys.index')}}">{{ __('My Learning Journey List') }}</a></li>
			@else
				<li id="journeyNameBreadcrumb"><a href="{{route('journeys.index')}}">{{ __('Predefined Learning Journey List')}}</a></li>
			@endif
			<li class="active"><a>{{ __('Add Journey') }}</a></li>
		</ul>
	</div>
	<div class="page-content journey_content"> 
		 <form method="POST" class="ajax-form" id="journeyAddForm" action="{{route('journeys.store')}}" role="form" enctype="multipart/form-data" > 
			@csrf
			<input type="hidden" id="saveType" name="save_type" />
			<input type="hidden" id="journeyPrimaryId" name="primary_id" value="{{ (($journey) ? encode_url($journey->id) : '') }}" />
			<input type="hidden" id="addJourneyStatus" name="status" value="{{ (($journey) ? $journey->status : 'draft') }}" />
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>{{ __('Add Journey') }}</h2>
				</div>
				@php( $journey_name = ($journey) ? $journey->journey_name : '')
				@php( $journey_description = ($journey) ? $journey->journey_description : '')
				<div class="white-content">
					<h3>{{ __('Learning Journey') }}</h3>
					<div class="inner-content form-all-input">
						<div class="row m-0">
							<div class="mlj_lft_field col-md-4 p-0 pr-5">
								<div class="form-group">
									<label for="inputName">{{ __('Journey Name') }} <span class="required">*</span></label>
									<input type="text" name="journey_name" class="form-control" id="inputName" maxlength="64"  value="{{old('journey_name', $journey_name)}}" placeholder="Enter Journey Name">
									@error('journey_name')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								<div class="form-group">
									<label for="inputJourneyTypeName">{{ __('Journey Type') }} <span class="required">*</span></label>
									<select id="inputJourneyTypeName" name="journey_type_id" class="form-control select2">
										<option value="">Select Journey Type</option>
										@foreach($journey_types as $type)
										<option {{ (old("journey_type_id",$journey_type_id) == $type->id) ? 'selected':''}} value="{{ $type->id }}">{{$type->name}}</option>
										@endforeach
									</select>   
									@error('journey_type_id')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								@php( $visibility = ($journey) ? $journey->visibility : '')
								<div class="form-group inputJourneyVisibility">
									<label for="inputJourneyVisibilityName">{{ __('Visibility') }} <span class="required">*</span></label>
									<select id="inputJourneyVisibilityName" name="journey_visibility" class="form-control select2" {{($journey_type_id == 2) ? 'readonly' : '' }} >
										<option value="">Choose Visibility </option>
										<option {{$visibility == 'private' ? 'selected' : ""}} value="private">Private</option>
										<option {{$visibility == 'public' ? 'selected' : ""}} value="public">Public</option>
									</select>   
									@error('journey_visibility')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								<div class="form-group plj_visibility d-none"> 
							   <label for="inputName">{{ __('Visibility') }}</label>
								<input disabled type="text" class="form-control" value="Public">
							</div>
								@php( $read = ($journey) ? $journey->read : '')
								<div class="form-group inputCompulOpt {{ ($journey_type_id == 2) ? '' : 'd-none' }}"> 
								   <label for="inputJourneyCompulOpt">{{ __('Compulsory or Optional') }} <span class="required">*</span></label>
									<select id="inputJourneyCompulOpt" name="journey_read" class="form-control select2">
										<option value="">Choose Compulsory or Optional</option>
										<option {{$read == 'optional' ? 'selected' : ""}} value="optional" >Optional</option>
										<option {{$read == 'compulsory' ? 'selected' : ""}} value="compulsory" >Compulsory</option>
									</select>
								</div>
							</div>
							<div class="mlj_rgt_field col-md-8 pl-5">
								<div class="form-group">
								   <label for="inputName">{{ __('Description') }} <span class="required">*</span></label>
									<textarea name="journey_description" placeholder="Enter Description" maxlength="1024" class="form-control">{{old('journey_description', $journey_description )}}</textarea>   
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
				<button type="button" onclick="clearJouneyAddForm()" class="btn btn-grey">{{ __('Clear') }}</button>
				<a href="{{route('journeys.index')}}" class="btn btn-green">{{ __('Back') }}</a>
				@php( $journey_status = ($journey) ? $journey->status : '')
				<button type="button" id="journeyFormSaveBtn" class="btn btn-blue {{$journey_status}} d-none">{{ __('Save') }}</button>					
				<button type="submit" id="journeyFormSubmit" class="btn btn-lightblue {{($journey && $journey->status == 'active') ? 'd-none' : ''}}">{{ __('Save as Draft') }}</button>
			</div>
		</form>
		<div id="journeyBreakDown"></div>
		@include('journey_management/milestone_list')
	</div>
</div>
@endsection
