@extends('layouts.app')

@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a >Profile Details</a></li>
			<li class="active"><a>View Profile</a></li>
		</ul>
	</div>
   <!-- Main row -->
	<div class="page-content user_manage">
        <!-- left column -->
		<div class="white-box">	
			<div class="white-box-head">	
				<h2>View Profile</h2>
			</div>
			<div class="white-content">
				<h3>Personal Information</h3>
				<div class="inner-content form-all-input">
					<div class="row">
						<div class="col-md-4">
							<div class="add-user text-center">
							@if($user->image != "")
								<img width=150 height=150 src="{{asset('storage/user-uploads/avatar/'.$user->image) }}" class="img-circle" alt="User Image">
							@else
								<img width=150 height=150 src="{{asset('images/user_profile.png') }}" class="img-circle" alt="User Image">
							@endif
							</div>
						</div>
						 <div class="col-md-8 pad-zero">
							<div class="row">
								<div class="col-md-6 left-pad pdr-45">
									<div class="form-group">
										<label for="inputFirstName">{{ __('First Name') }}</label>
										<input class="form-control" type="text"  maxlength="40"  value="{{$user->first_name}}" disabled />
									</div>
								</div>
								<div class="col-md-6 right-pad pdl-45">
									<div class="form-group">
										<label for="inputLastName">{{ __('Last Name') }}</label>
										<input class="form-control" type="text"  value="{{$user->last_name}}" disabled />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 left-pad pdr-45">
									<div class="form-group">
										<label for="inputEmail">{{ __('Email ID') }}</label>
										<input class="form-control" type="email" disabled value="{{$user->email}}" />
									</div>
								</div>
								<div class="col-md-6 right-pad pdl-45">
									<div class="form-group">
										<label for="inputMobile">{{ __('Phone Number') }}</label>
										<input class="form-control" type="phone" disabled value="{{$user->mobile}}" />
									</div>
								</div>
							</div>
							
							@if(false)
							
							<div class="row">
								<div class="col-md-6 left-pad pdr-45">
									<div class="form-group checkbox_status">
										<label class="check_label">Status</label>
										<label class="switch round">
											<input id="userStatusHidden" type="hidden" value="inactive" name="status" disabled>
											<input {{$user->status == 'active' ? 'checked' :''}} type="checkbox" disabled />
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
			<a href="{{route('users.index')}}" class="btn btn-green">{{ __('Back') }}</a>
			<a href="{{route('profile_edit')}}" class="btn btn-blue">{{ __('Edit') }}</a>
			<button type="button" id="changePassword" data-toggle="modal" data-target="#changePasswordModal" class="btn  btn-red">{{ __('Change Password') }}</button>
		</div>
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
										<input name="current_password" class="form-control" maxlength="40" type="password" placeholder="Enter Current Password"  />
									</div>
									<div class="form-group">
										<label for="inputFirstName">{{ __('New Password ') }} <span class="required">*</span></label>
										<input name="password" class="form-control" maxlength="40" type="password" placeholder="Enter New Password"  />
									</div>
									<div class="form-group">
										<label for="inputFirstName">{{ __('Re-Enter Password') }} <span class="required">*</span></label>
										<input name="password_confirmation" class="form-control" maxlength="40" type="password" placeholder="Re-Enter Password"  />
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
