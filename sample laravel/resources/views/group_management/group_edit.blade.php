@extends('layouts.app')
@section('content')	
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('groups.index')}}">{{ __('Group Management List') }}</a></li>
			<li class="active"><a>{{ __('Edit Group') }}</a></li>
		</ul>
	</div>
	<div class="page-content group_content"> 
		 <form method="POST" class="ajax-form" id="groupEditForm" action="{{route('groups.update',[$group->id])}}" role="form" enctype="multipart/form-data" > 
			@csrf
			{{ method_field('PUT')}}
			<input type="hidden" id="groupPrimaryId" name="primary_id" value="{{ (($group) ? encode_url($group->id) : '') }}" />
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>{{ __('Edit Group') }}</h2>
				</div>
				@php( $group_name = ($group) ? $group->group_name : '')			
				<div class="white-content">
					<h3>{{ __('Group Details') }}</h3>
					<div class="inner-content form-all-input pb-5">
						<div class="row m-0">
							<div class="mlj_lft_field col-md-4 p-0 pr-5">
								<div class="form-group">
									<label for="inputGroupName">{{ __('Group Name') }} <span class="required">*</span></label>
									<input type="text" name="group_name" class="form-control" id="inputGroupName" maxlength="64"  value="{{old('group_name', $group_name)}}" placeholder="Enter Group Name">
									@error('group_name')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								@php( $visibility = ($group) ? $group->visibility : '')
								<div class="form-group">
									<label for="inputVisibilityName">{{ __('Visibility') }} <span class="required">*</span></label>
									<select id="inputVisibilityName" name="visibility" class="form-control select2" >
										<option value="">Select Visibility</option>
										<option {{$visibility == 'private' ? 'selected' : ""}} value="private">Private</option>
										<option {{$visibility == 'public' ? 'selected' : ""}} value="public">Public</option>
									</select>   
									@error('visibility')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
							</div>
							@php( $group_description = ($group) ? $group->group_description : '')
							<div class="mlj_rgt_field col-md-8 pl-5">
								<div class="form-group">
								   <label for="inputDescriptionName">{{ __('Group Description') }} <span class="required">*</span></label>
									<textarea id="inputDescriptionName" name="group_description" placeholder="Enter Description" maxlength="1024" class="form-control">{{strip_tags($group_description)}}</textarea>  
									@error('group_description')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
			<div class="btn-footer">
				<button type="button" onclick="resetForm()" class="btn btn-grey">{{ __('Restore') }}</button>
				<a href="{{ back_url(route('groups.index')) }}" class="btn btn-green">{{ __('Back') }}</a>
				@php($group_status = ($group) ? $group->status : '')
				<button type="submit" id="GroupFormSubmitBtn" class="btn {{$group_status}} btn-blue">{{ __('Save') }}</button>	
			</div>
		</form>
		@include('group_management/members_list')
		@include('group_management/journeys_list')
	</div>
</div>
@endsection
