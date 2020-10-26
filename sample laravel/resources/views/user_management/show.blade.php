@extends('layouts.app')

@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('users.index')}}">User Management List</a></li>
			<li class="active"><a>View User</a></li>
		</ul>
	</div>
   <!-- Main row -->
	<div class="page-content user_manage">
        <!-- left column -->
		<div class="white-box">	
			<div class="white-box-head">	
				<h2>View User</h2>
			</div>
			<div class="white-content">
				<h3>Personal Information</h3>
				<div class="inner-content form-all-input">
					<div class="row">
						<div class="col-md-4">
							<div class="add-user text-center">
							@if($user->image != "")
								<img width=150 height=150 src="{{ profile_image($user->image) }}" class="img-circle" alt="User Image">
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
							<div class="row">
								<div class="col-md-6 left-pad pdr-45">
									<div class="form-group">
										<label for="inputFirstName">Roll Name</label>
										<input class="form-control" type="text"  value="{{ $user->roles->first()->name }}" disabled />
									</div>
								</div>
								<div class="col-md-6 right-pad pdl-45">
									<div class="form-group">
										<label for="inputDesignation">{{ __('Designation') }}</label>
										<input type="text" name="designation"  class="form-control" maxlength="64" id="designation" value="{{old('designation',$user->designation)}}" disabled>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 left-pad pdr-45">
									<div class="form-group">
										<label for="inputTeam">{{ __('Team ') }}</label>
										 <input type="text" name="team" class="form-control" maxlength="64" id="team " value="{{old('team',$user->team)}}" disabled>
									</div>
								</div>
								<div class="col-md-6 right-pad pdl-45">
									<div class="form-group">
										<label for="inputDepartment ">{{ __('Department ') }}</label>
										<input type="tel" name="department " class="form-control" maxlength="64" id="department" value="{{old('department',$user->department)}}"  disabled>
									</div>
								</div>
							</div>
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
						</div>
					</div>
				</div>
			</div>
			<div class="white-content"> 
				<h3>User Grade</h3>
				<div class="inner-content form-all-input selec_grade">
					<div class="row" id="renderGrade">
						<!--<?php $i = 0;?>
						@foreach($org_data as $data)
							<div class="form-group col-sm-4 select-unit">
								<label class="label_data_{{$data->set_id}}" data-text="{{ $data->set_name }}" for="unit">{{ $data->set_name }}</label>
								<select disabled name="gradeId[{{$data->set_id}}]" class="form-control select_level level_id_{{$data->set_id}}" data-set-id="{{ $data->set_id}}">
									<option value="">Select {{$data->set_name}}</option>
									@foreach($data->orgchart as $row)
										@if(@ $user_grade[$i]->chart_value_id == $row->node_id)
											<option selected value="{{ $row->node_id }}" data-node_id ="{{$row->node_id}}" data-node_parent="{{$row->node_parent}}">{{$row->node_name}}</option>
										@else
											<option value="{{ $row->node_id }}" data-node_id ="{{$row->node_id}}" data-node_parent="{{$row->node_parent}}">{{$row->node_name}}</option>
										@endif
																		
									@endforeach
								</select>
							</div>
							<?php $i++; ?>
						@endforeach-->
					</div>
				</div>
			</div>
		</div>  
		<div class="btn-footer">
			<a href="{{route('users.index')}}" class="btn btn-green">{{ __('Back') }}</a>
			@can('edit_users')
			<a href="{{route('users.edit',[encode_url($user->id)])}}" class="btn btn-blue">{{ __('Edit') }}</a>
			@endcan
		</div>
	</div>
</div>
@endsection
