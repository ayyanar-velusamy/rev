@extends('layouts.app')
@section('content')

<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a>Profile Details</a></li>
			<li class="active"><a href="javascript:">Edit</a></li>
		</ul>
	</div>
	<div class="page-content passport_sec">
		<form method="POST" class="ajax-form" id="passportForm"  role="form" enctype="multipart/form-data">
			@csrf
			
			<div class="white-box">	
				<div class="white-box-head">	
					<h2>Profile Details</h2>
				</div>
				<div class="white-content">
					<h3>Personal Information</h3>
					<div class="inner-content form-all-input">
						<div class="row">
							<div class="col-md-4">
								<div class="account-bg ">
									<div class="add-user text-center">
											<img width=150 src="{{asset('images/user_profile.png') }}" class="img-circle user-image img-responsive" alt="User Image" id="profile-adminImg">
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
											<input name="first_name" class="form-control" maxlength="40" type="text" placeholder="Enter First Name"  />
										</div>
									</div>
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputLastName">{{ __('Last Name') }} <span class="required">*</span></label>
											<input name="last_name" class="form-control" maxlength="40" type="text"  placeholder="Enter Last Name" />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group">
											<label for="inputEmail">{{ __('Email address') }}</label>
											<input name="email" disabled class="form-control" maxlength="64" type="email" placeholder="Enter Email Address"  />
										</div>
									</div>
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputMobile">{{ __('Mobile Number') }} <span class="required">*</span></label>
											<input name="mobile" class="form-control" maxlength="13" type="phone" placeholder="Enter Phone Number"  />
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 left-pad pdr-45">
										<div class="form-group">
											<label for="inputFirstName">Roll Name </label>
											<select class="form-control select2" disabled >
												<option>Admin</option>
												<option>User</option>
											</select>
										</div>
									</div>
									<div class="col-md-6 right-pad pdl-45">
										<div class="form-group">
											<label for="inputDesignation">{{ __('Designation') }}</label>
											<input type="text" name="designation" class="form-control" maxlength="64" id="designation"  placeholder="Enter Designation " />
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				@if(count($user_grade) > 0)
				<div class="white-content"> 
				<h3>User Grade</h3>
				<div class="inner-content form-all-input">
					<div class="row" >
						<?php $i = 0;?>
						@foreach($org_data as $data)
							@foreach($data->orgchart as $row)
							@if(@ $user_grade[$i]->chart_value_id == $row->node_id)
							<div class="form-group col-sm-4 select-unit">
								<label class="label_data_{{$data->set_id}}" data-text="{{ $data->set_name }}" for="unit">{{ $data->set_name }}</label>
								<select disabled class="form-control select_level level_id_{{$data->set_id}}" data-set-id="{{ $data->set_id}}">
									<option selected value="{{ $row->node_id }}" data-node_id ="{{$row->node_id}}" data-node_parent="{{$row->node_parent}}">{{$row->node_name}}</option>
								</select>
							</div>
							@endif						
							@endforeach
							<?php $i++; ?>
						@endforeach
					</div>
				</div>
			</div>
			@endif
			</div>   
			<div class="btn-footer">
				<button type="reset" class="btn btn-grey">{{ __('Restore') }}</button>
				<a href="{{route('users.index')}}" class="btn btn-green">{{ __('Back') }}</a>
				<button type="submit" id="userEditFormSubmit" class="btn  btn-blue">{{ __('Save') }}</button>
				<button type="button" id="changePassword" data-toggle="modal" data-target="#changePasswordModal" class="btn  btn-red">{{ __('Change Password') }}</button>
			</div>
		</form>  
		<div class="modal modal475 modal-danger fade" id="changePasswordModal">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">	
						<h2>Change Password</h2>
						<button type="reset" class="btn-close" title="Close" data-dismiss="modal">x</button>
					</div>
					<div class="modal-body">
						<div class="white-box"> 
							<div class="white-content pt-0">
								<div class="inner-content form-all-input">
									<div class="form-group">
										<label for="inputFirstName">{{ __('Current Password') }} <span class="required">*</span></label>
										<input name="first_name" class="form-control" maxlength="40" type="text" placeholder="Enter Current Password"  />
									</div>
									<div class="form-group">
										<label for="inputFirstName">{{ __('New Password ') }} <span class="required">*</span></label>
										<input name="first_name" class="form-control" maxlength="40" type="text" placeholder="Enter New Password"  />
									</div>
									<div class="form-group">
										<label for="inputFirstName">{{ __('Re-Enter Password') }} <span class="required">*</span></label>
										<input name="first_name" class="form-control" maxlength="40" type="text" placeholder="Re-Enter Password"  />
									</div>
								</div>
							</div>
						</div>
						<div class="btn-footer  mt-4 pt-2">
							  <button type="reset" id="deleteUserCancel" class="btn btn-grey" data-dismiss="modal">Cancel</button>
							  <button type="submit" id="submitChangePassword" class="btn btn-green" >Save</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



@endsection
