@extends('layouts.app')
@section('content')

<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a>Profile Details</a></li>
			<li class="active"><a href="javascript:">Edit Profile</a></li>
		</ul>
	</div>
	<div class="page-content user_manage">
		<form method="POST" class="ajax-form" id="userProfileEditForm" action="{{route('users.profile_update')}}" role="form" enctype="multipart/form-data">
			@csrf
			{{ method_field('POST') }}
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>Edit Profile</h2>
				</div>
				<div class="white-content">
					<h3>Personal Information</h3>
					<div class="inner-content form-all-input">
						<div class="row">
							<div class="col-md-4">
								<div class="account-bg ">
									<div class="add-user text-center"> 
										@if($user->image != "")
											<img width=150 src="{{asset('storage/user-uploads/avatar/'.$user->image) }}" class="img-circle img-responsive" alt="User Image" id="profile-adminImg">
										@else
											<img width=150 src="{{asset('images/user_profile.png') }}" class="img-circle user-image img-responsive" alt="User Image" id="profile-adminImg">
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
											<input name="first_name" class="form-control" maxlength="40" type="text"  value="{{$user->first_name}}" placeholder="Enter First Name" />
										</div>
									</div>
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputLastName">{{ __('Last Name') }} <span class="required">*</span></label>
											<input name="last_name" class="form-control" maxlength="40" type="text"  value="{{$user->last_name}}"  placeholder="Enter Last Name"/>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group">
											<label for="inputEmail">{{ __('Email address') }} <span class="required"></span></label>
											<input disabled class="form-control" maxlength="64" type="email" value="{{$user->email}}" />
										</div>
									</div>
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputMobile">{{ __('Phone Number') }} <span class="required">*</span></label>
											<input name="mobile" class="form-control" maxlength="13" type="phone" value="{{$user->mobile}}"  placeholder="Enter Phone Number" />
										</div>
									</div>
								</div>
								
								@if(false)
								
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
								@endif
							</div>
						</div>
					</div>
				</div> 
			</div>   
			<div class="btn-footer">
				<button type="reset" onclick="resetForm()" class="btn btn-grey">{{ __('Restore') }}</button>
				<a href="{{url('/profile')}}" class="btn btn-green">{{ __('Back') }}</a>
				<button type="submit" id="userEditFormSubmit" class="btn  btn-blue">{{ __('Save') }}</button>
				<button type="button" id="changePassword" data-toggle="modal" data-target="#changePasswordModal" class="btn  btn-red">{{ __('Change Password') }}</button>
			</div>
		</form> 
		<div class="modal modal475 modal-danger fade" id="changePasswordModal" data-backdrop="static">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">	
						<h2>Change Password</h2>
						<button type="reset" class="btn-close" title="Close" data-dismiss="modal">x</button>
					</div>
					<div class="modal-body">
						{!! Form::open([ 'route' => 'change_password', 'enctype' => 'multipart/form-data', 'class' => 'ajax-form clearfix', 'id'=>'changePasswordModalForm' ]) !!}
						@csrf
						<div class="white-box"> 
							<div class="white-content pt-0">
								<div class="inner-content form-all-input">
									<div class="form-group">
										<label for="inputFirstName">{{ __('Current Password') }} <span class="required">*</span></label>
										<input name="current_password" class="form-control" maxlength="16" type="password" placeholder="Enter Current Password"  />
									</div>
									<div class="form-group">
										<label for="inputFirstName">{{ __('New Password ') }} <span class="required">*</span></label>
										<input name="password" class="form-control" maxlength="16" id="password"  type="password" placeholder="Enter New Password"  />
									</div>
									<div class="form-group">
										<label for="inputFirstName">{{ __('Re-Enter Password') }} <span class="required">*</span></label>
										<input name="password_confirmation" id="password-confirm" class="form-control" maxlength="16" type="password" placeholder="Re-Enter Password"  />
									</div>
								</div>
							</div>
						</div>
						<div class="btn-footer  mt-4 pt-2">
							  <button type="reset" id="changePwdCancel" class="btn btn-grey" data-dismiss="modal">Cancel</button>
							  <button type="submit" id="submitChangePassword" class="btn btn-green" >Save</button>
						</div>
						{{ Form::close() }}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
