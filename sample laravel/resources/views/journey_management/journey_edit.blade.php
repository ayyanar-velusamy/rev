@extends('layouts.app')
@section('content')

<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			@php( $breadcrumb = ($journey->journey_type_id === 1) ? 'My' : 'Predefined' )
			<li><a href="{{route('journeys.index')}}">{{__($breadcrumb)}} {{ __('Learning Journey List') }}</a></li>
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
									<input type="text" name="journey_name" class="form-control" id="inputName" value="{{old('journey_name',$journey->journey_name)}}" placeholder="Enter Journey Name">
									@error('journey_name')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								<div class="form-group">
									<label for="inputName">{{ __('Journey Type') }} </label>
									<select name="journey_type_id" disabled class="form-control select2" "{{old('journey_type_id')}}" >
										<option value="">Select Journey Type</option>
										@foreach($journey_types as $type)
										<option  {{$journey->journey_type_id == $type->id ? 'selected' : ""}} value="{{ $type->id }}">{{$type->name}}</option>
										@endforeach
									</select>   
									@error('journey_type_id')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								<div class="form-group">
									<label for="inputName">{{ __('Visibility') }} <span class="required">*</span></label>
									@if($journey->journey_type_id == 2)
										<input type="hidden" name="journey_visibility" value="public"/>
										<input disabled class="form-control" type="text" value="Public"/>
									@else	
									<select name="journey_visibility" class="form-control select2" "{{old('journey_visibility')}}" >
										<option value="">Select Visibility</option>
										<option {{$journey->visibility == 'private' ? 'selected' : ""}} value="private">Private</option>
										<option {{$journey->visibility == 'public' ? 'selected' : ""}} value="public">Public</option>
									</select> 
									@endif
									@error('journey_visibility')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								@php( $read = ($journey) ? $journey->read : '')
								<div class="form-group inputCompulOpt {{ ($journey->journey_type_id == 2) ? '' : 'd-none' }}">  
								   <label for="inputJourneyCompulOpt">{{ __('Compulsory or Optional') }} <span class="required">*</span></label>
									<select id="inputJourneyCompulOpt" name="journey_read" class="form-control select2">
										<option value="">Choose Compulsory or Optional</option>
										<option {{$journey->read == 'optional' ? 'selected' : ""}} value="optional">Optional</option>
										<option {{$journey->read == 'compulsory' ? 'selected' : ""}} value="compulsory">Compulsory</option>
									</select>
								</div>
							</div>
							<div class="mlj_rgt_field col-md-8 pl-5">
								<div class="form-group">
								   <label for="inputName">{{ __('Description') }} <span class="required">*</span></label>
									<textarea name="journey_description" class="form-control"> {{old('journey_description', $journey->journey_description)}}</textarea>   
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
				@if(($journey->journey_type_id != 3) && (($journey->created_by == user_id() && auth()->user()->hasPermissionTo('edit_journeys')) || auth()->user()->hasPermissionTo('edit_others_journeys')))
				<button type="button" onclick="resetForm()" class="btn btn-grey">{{ __('Restore') }}</button>
				@endif
				
				<a href="{{ back_url(route('journeys.index')) }}" class="btn btn-green">{{ __('Back') }}</a>
				@if(($journey->journey_type_id != 3) && (($journey->created_by == user_id() && auth()->user()->hasPermissionTo('edit_journeys')) || auth()->user()->hasPermissionTo('edit_others_journeys')))
				<button type="button" id="journeyFormSaveBtn" class="btn btn-blue {{($journey && $journey->status == 'active') ? '' : 'd-none'}}">{{ __('Save') }}</button>
				<button type="submit" id="journeyFormSubmit" class="btn btn-lightblue {{($journey && $journey->status == 'active') ? 'd-none' : ''}}">{{ __('Save as Draft') }}</button>
				@endif
			</div>
		</form>
		<div id="journeyBreakDown"></div>
		@php( $journey_type_id  = $journey->journey_type_id)	
		@include('journey_management/milestone_list')
	</div>
</div>
@endsection
