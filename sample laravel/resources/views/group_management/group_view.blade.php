@extends('layouts.app')
@section('content')	

<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('groups.index')}}">{{ __('Group Management List') }}</a></li>
			<li class="active"><a>{{ __('View Group') }}</a></li>
		</ul>
	</div>
	<div class="page-content group_content view"> 
		 <form method="POST" class="ajax-form" id="groupAddForm" action="{{route('groups.store')}}" role="form" enctype="multipart/form-data" > 
			@csrf
			<input type="hidden" id="groupPrimaryId" name="primary_id" value="{{ (($group) ? encode_url($group->id) : '') }}" />
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>{{ __('View Group') }}</h2>
					@if(is_group_member($group->id))
					<a href="javascript:" id="leaveGroupBtn" onclick="leaveGroup('{{encode_url($group->id)}}','{{$group->group_name}}')" title="Leave Group" class="btn btn-red">Leave Group</a>
					@endif
				</div>
				@php( $group_name = ($group) ? $group->group_name : '')			
				<div class="white-content">
					<h3>{{ __('Group Details') }}</h3>
					<div class="inner-content form-all-input pb-5">
						<div class="row m-0">
							<div class="mlj_lft_field col-md-4 p-0 pr-5">
								<div class="form-group">
									<label for="inputGroupName">{{ __('Group Name') }} </label>
									<input type="text" disabled="disabled" name="group_name" class="form-control" id="inputGroupName" maxlength="64"  value="{{old('group_name', $group_name)}}" placeholder="Enter Journey Name">
									@error('group_name')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								<!--@php( $visibility = ($group) ? $group->visibility : '')
								<div class="form-group">
									<label for="inputVisibilityName">{{ __('Visibility') }} </label>
									<select id="inputVisibilityName" disabled="disabled" name="visibility" class="form-control select2" >
										<option value="">Select Visibility</option>
										<option {{$visibility == 'private' ? 'selected' : ""}} value="private">Private</option>
										<option {{$visibility == 'public' ? 'selected' : ""}} value="public">Public</option>
									</select>   
									@error('visibility')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>-->
								<div class="form-group">
									<label for="inputGroupAdminName">{{ __('Group Admin Name') }} </label>
									<input disabled type="text"  name="admin_name" class="form-control" id="inputGroupAdminName" maxlength="64"  value="" placeholder="Enter Group Admin Name">
								</div>
								
								<div class="form-group">
									<label for="inputCreateDateName">{{ __('Created Date') }} </label>
									<input type="text" disabled="disabled" name="group_name" class="form-control" id="inputCreateDateName" maxlength="64"  value="{{get_date($group->created_at)}}" placeholder="Created Date">
								</div>
							</div>
							@php( $group_description = ($group) ? $group->group_description : '')
							<div class="mlj_rgt_field col-md-8 pl-5">
								<div class="form-group">
								   <label for="inputDescriptionName">{{ __('Group Description') }}</label>
									<textarea id="inputDescriptionName" disabled="disabled" name="group_description" placeholder="Enter Description" maxlength="1024" class="form-control">{{strip_tags($group_description)}}</textarea>  
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
				<a href="{{back_url(route('groups.index'))}}" class="btn btn-green">{{ __('Back') }}</a>
				@if(auth()->user()->hasPermissionTo('edit_groups') || is_group_admin($group->id))
				<a href="{{route('groups.edit',[encode_url($group->id)])}}" class="btn btn-blue">{{ __('Edit') }}</a>
				@endif
	  		</div>
		</form>
		@include('group_management/members_list')
		@include('group_management/journeys_list')
	</div>
</div>
@endsection
