@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('users.index')}}">User Management List</a></li>
			<li class="active"><a>Edit User</a></li>
		</ul>
	</div>
	<div class="page-content user_manage">
		<form method="POST" class="ajax-form" id="userEditForm" action="{{route('users.update',[$user->id])}}" role="form" enctype="multipart/form-data">
			@csrf
			{{ method_field('PUT') }}
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>Edit User</h2>
				</div>
				<div class="white-content">
					<h3>Personal Information</h3>
					<div class="inner-content form-all-input">
						<div class="row">
							<div class="col-md-4">
								<div class="account-bg ">
									<div class="add-user text-center">
										@if($user->image != "")
											<img width=150 height=150 src="{{ profile_image($user->image) }}" class="img-circle img-responsive" alt="User Image" id="profile-adminImg">
										@else
											<img width=150 height=150 src="{{asset('images/user_profile.png') }}" class="img-circle user-image img-responsive borderwithout" alt="User Image" id="profile-adminImg">
										@endif
										
										<div class="table-small-img-outer">
											<div class="table-small-img">
											</div>
										</div>
										<div class="text-center account-img acc-upload">
												<label for="profile-user" class="fw600 uploadLabel profile_upload">Change Picture</label>
											<input id="profile-user" name="image"  class="profileAdmin" type="file" accept="image/*"/>
										</div>
										<div class="account-wrap">
											<div id="userprofile" ></div> 
										</div>
										<ul class="list-inline btn-footer">
											<li><a href="javascript:" class="crop-save btn-green btn">Save</a></li>
											<li><a href="javascript:" class="crop-cancel btn-grey btn">Cancel</a></li>
										</ul>
										<p class="error"></p>
									</div>
								</div>
							</div>
							 <div class="col-md-8 pad-zero">
								<div class="row">
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group">
											<label for="inputFirstName">{{ __('First Name') }} <span class="required">*</span></label>
											<input name="first_name" class="form-control" maxlength="40" type="text"  value="{{$user->first_name}}" autofocus />
										</div>
									</div>
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputLastName">{{ __('Last Name') }} <span class="required">*</span></label>
											<input name="last_name" class="form-control" maxlength="40" type="text"  value="{{$user->last_name}}" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group">
											<label for="inputEmail">{{ __('Email ID') }} <span class="required">*</span></label>
											<input name="email" class="form-control" maxlength="64" type="email" value="{{$user->email}}" />
										</div>
									</div>
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputMobile">{{ __('Phone Number') }} <span class="required">*</span></label>
											<input name="mobile" class="form-control" maxlength="13" type="phone" value="{{$user->mobile}}" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group">
											<label for="inputFirstName">Roll Name  <span class="required">*</span></label>
											<select name="roles[]" class="form-control select2">
												<option value="">Select Role</option>
												@foreach($roles as $id=>$role)
												<option {{ $user->roles->first()->id == $id ? 'Selected' : '' }}  value="{{ $id }}">{{ $role }}</option>
												@endforeach
											</select>
											@if ($errors->has('roles')) <p class="help-block">{{ $errors->first('roles') }}</p> @endif
										</div>
									</div>
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputDesignation">{{ __('Designation') }}</label>
											<input type="text" name="designation" class="form-control" maxlength="64" id="designation" value="{{old('designation',$user->designation)}}" placeholder="Enter Designation">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group">
											<label for="inputTeam">{{ __('Team ') }}</label>
											 <input type="text" name="team" class="form-control" maxlength="64" id="team " value="{{old('team',$user->team)}}" placeholder="Enter Team ">
										</div>
									</div>
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputDepartment ">{{ __('Department ') }}</label>
											<input type="tel" name="department" class="form-control" maxlength="64" id="department" value="{{old('department',$user->department)}}" placeholder="Enter Department ">
										</div>
									</div>
								</div>
								<div class="row">	
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group checkbox_status">
											<label class="check_label">Status  <span class="required">*</span></label>
											<label class="switch round">
												<input id="userStatusHidden" type="hidden" value="inactive" name="status">
												<input {{$user->status == 'active' ? 'checked' :''}} name="status" value="active" type="checkbox" />
												<span class="slider round"></span>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> 
			</div>   
			<div class="btn-footer">
				<button type="button" onclick="resetForm()" class="btn btn-grey">{{ __('Restore') }}</button>
				<a href="{{ back_url(route('users.index')) }}" class="btn btn-green">{{ __('Back') }}</a>
				<button type="submit" id="userEditFormSubmit" class="btn  btn-blue">{{ __('Save') }}</button>
			</div>
		</form>  	
	</div>
</div>

@endsection
