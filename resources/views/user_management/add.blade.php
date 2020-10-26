@extends('layouts.app')
@section('content')
	
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('users.index')}}">User Management List</a></li>
			<li class="active"><a>Add User</a></li>
		</ul>
	</div>
	<div class="page-content user_manage"> 
		 <form method="POST" class="ajax-form" id="userAddForm" action="{{route('users.store')}}" role="form" enctype="multipart/form-data" > 
			@csrf
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>Add User</h2>
				</div>
				<div class="white-content">
					<h3>Personal Information</h3>
					<div class="inner-content form-all-input">
						<div class="row">
							<div class="col-md-4 left-pad">
								<div class="account-bg ">
										<div class="add-user text-center">
										<img width=150 data-src="{{asset('images/profile_picture.png') }}" src="{{asset('images/profile_picture.png') }}" class="img-circle img-responsive" alt="User Image" id="profile-adminImg">
										<div class="table-small-img-outer">
											<div class="table-small-img">
											</div>
										</div>
										<div class="text-center account-img acc-upload">
												<!--<label for="profile-user" class="fw600 uploadLabel profile_upload">Change Profile Picture</label>-->
												<label for="profile-user" class="fw600 uploadLabel profile_upload">Upload Picture</label>
											<input id="profile-user" name="image" class="profileAdmin" type="file" accept="image/*"/>
										</div>
										<div class="account-wrap">
											<div id="userprofile" ></div> 
										</div>
										<ul class="list-inline btn-footer" >
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
											<input type="text" name="first_name" class="form-control" maxlength="40" id="first_name" value="{{old('first_name')}}" placeholder="Enter First Name" autofocus />
										</div>
									</div>
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputLastName">{{ __('Last Name') }} <span class="required">*</span></label>
											<input type="text" name="last_name" class="form-control" maxlength="40" id="last_name" value="{{old('last_name')}}" placeholder="Enter Last Name">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group">
											<label for="inputEmail">{{ __('Email ID') }} <span class="required">*</span></label>
											 <input type="email" name="email" class="form-control" maxlength="64" id="email" value="{{old('email')}}" placeholder="Enter Email ID">
										</div>
									</div>
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputMobile">{{ __('Phone Number') }} <span class="required">*</span></label>
											<input type="tel" name="mobile" class="form-control" maxlength="13" id="mobile" value="{{old('mobile')}}" placeholder="Enter Phone Number">
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
												<option value="{{ $id }}">{{ $role }}</option>
												@endforeach
											</select>
											@if ($errors->has('roles')) <p class="help-block">{{ $errors->first('roles') }}</p> @endif
										</div>
									</div>
									
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputDesignation">{{ __('Designation') }}</label>
											<input type="text" name="designation" class="form-control" maxlength="64" id="designation" value="{{old('designation')}}" placeholder="Enter Designation">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group">
											<label for="inputTeam">{{ __('Team ') }}</label>
											 <input type="text" name="team" class="form-control" maxlength="64" id="team " value="{{old('team')}}" placeholder="Enter Team ">
										</div>
									</div>
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputDepartment ">{{ __('Department ') }}</label>
											<input type="tel" name="department" class="form-control" maxlength="64" id="department" value="{{old('department')}}" placeholder="Enter Department ">
										</div>
									</div>
								</div>
								<div class="row">	
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group checkbox_status">
											<label class="check_label">Status  <span class="required">*</span></label>
											<label class="switch round">
												<input id="userStatusHidden" type="hidden" value="active" name="status">
												<input name="status" value="active" disabled="disabled" type="checkbox" checked  />
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
				<button type="button" id="clearForm" class="btn btn-grey">{{ __('Clear') }}</button>
				<a href="{{route('users.index')}}" class="btn btn-green">{{ __('Back') }}</a>
				<button type="submit" id="userAddFormSubmit" class="btn btn-blue">{{ __('Save') }}</button>
			</div>
		</form>
	</div>
</div>
@endsection
