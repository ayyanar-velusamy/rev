@extends('layouts.app')
@section('content')	
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('groups.index')}}">{{ __('Group Management List') }}</a></li>
			<li class="active"><a>{{ __('Add Group') }}</a></li>
		</ul>
	</div>
	<div class="page-content group_content"> 
		 <form method="POST" class="ajax-form" id="groupAddForm" action="{{route('groups.store')}}" role="form" enctype="multipart/form-data" > 
			@csrf
			<input type="hidden" id="groupPrimaryId" name="primary_id" value="{{ (($group) ? encode_url($group->id) : '') }}" />
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>{{ __('Add Group') }}</h2>
				</div>
				@php( $group_name = ($group) ? $group->group_name : '')
				@php( $group_description = ($group) ? $group->group_description : '')
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
								<div class="form-group arrow_black">
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
							<div class="mlj_rgt_field col-md-8 pl-5">
								<div class="form-group">
								   <label for="inputDescriptionName">{{ __('Group Description') }} <span class="required">*</span></label>
									<textarea id="inputDescriptionName" name="group_description" placeholder="Enter Group Description" maxlength="1024" class="form-control">{{old('group_description', $group_description )}}</textarea>   
									@error('group_description')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
			<div class="btn-footer mt-5">
				<button type="button" onclick="clearGroupAddForm()" class="btn btn-grey">{{ __('Clear') }}</button>
				<a href="{{route('groups.index')}}" class="btn btn-green">{{ __('Back') }}</a>
				@php($group_status = ($group) ? $group->status : '')
				<button type="submit" id="GroupFormSubmitBtn" class="btn {{$group_status}} btn-blue">{{ __('Save') }}</button>					

			</div>
		</form>
		@include('group_management/members_list') 
	</div>
</div>
@endsection