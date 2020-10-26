@extends('layouts.app')

@section('content')

<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a>Library Management</a></li>
			<li class="active"><a href="javascript:">Assign Library</a></li>
		</ul>
	</div>
   <!-- Main row -->
	<div class="page-content lib_assign">
        <!-- left column -->
		<form method="POST" class="ajax-form1" id="contentAssignForm" action="{{route('libraries.store_assign')}}" role="form" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="content_id" value="{{ Request::route('id') }}">
		<div class="white-box">	
			<div class="white-content">
				<h3>Assign Library : {{$content->title}}</h3>
				<div class="inner-content form-all-input">
					<div class="libAssignTab">
						<div class="white-top-content">
							<ul class="nav nav-tabs">
								<li class="nav-item">
								  <a class="nav-link active" data-toggle="tab" href="#userTab1">User</a>
								</li>
								<li class="nav-item">
								  <a class="nav-link" data-toggle="tab" href="#groupTab1">Group</a>
								</li>
							</ul>
						</div>
						<div class="row">
							<div class="col-md-5">
								<div class="tab-content">
									<div id="userTab1" class="container tab-pane active">
										<div class="addMultipleUser pl-0">
											<div class="form-group">
												<div class="adduser_field pr-4">
													<label for="inputUserName">{{ __('User') }} <span class="required">*</span></label>
													<select class="form-control select2" id="inputUserName">
														<option value="">Select User</option>
														@foreach($users as $user)
														<option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
														@endforeach
													</select>
													<span class="error adduser-error " style="display:none;"></span> 
												</div>
												<div class="adduser_btn">
													<button type="button" id="assignAddUser" class="btn btn-blue" > Add User</button>
												</div>
											</div>
											<div class="addMulUserscroll">
												<ul class="addMulUserList  mb-0" id="addMulUserList"></ul>
											</div>
											<span id="user-error" class="error userempty-error" style="display:none;"></span>
										</div>
									</div> 
									<div id="groupTab1" class="container tab-pane">
										<div class="addMultipleUser pl-0">
											<div class="form-group">
												<div class="adduser_field pr-4">
													<label for="inputGroupName">{{ __('Group') }} <span class="required">*</span></label>
													<select class="form-control select2" id="inputGroupName">
														<option value="">Select Group</option>
														@foreach($groups as $group)
														<option value="{{$group->id}}">{{$group->group_name}}</option>
														@endforeach
													</select>
													
												</div>
												<div class="adduser_btn">
													<button type="button" id="assignAddGroup" class="btn btn-blue" > Add Group</button>
												</div>
											</div>
											<div class="addMulUserscroll">
												<ul class="addMulUserList  mb-0" id="addMulGroupList"></ul>
											</div>
											<span id="group-error" class="error adduser-error " style="display:none;"></span>
											<span class="error userempty-error" style="display:none;"></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-7 px-0">
								<div class="row">
									<input type="hidden" name="milestone_id" value="{{$content->milestone_id}}">
									<!--<div class="form-group">
										<label for="inputTitleName">{{ __('Content Title') }} <span class="required">*</span></label>
										<input disabled type="text" class="form-control" id="inputTitleName" value="{{$content->title}}">
									</div>
									<div class="form-group">
									   <label for="inputName">{{ __('Content Type') }} <span class="required">*</span></label>
										<select disabled class="form-control" "{{old('content_type_id')}}" >
											<option value="">Select option</option>
											@foreach($content_types as $type)
											<option {{ $type->id == $content->content_type_id ? 'selected' : '' }} value="{{ $type->id }}">{{$type->name}}</option>
											@endforeach
										</select>  
									</div>-->
									<div class="form-group col-md-6">
									   <label for="inputJourneyName">{{ __('Journey') }} <span class="required">*</span></label>
										<select name="journey_id" id="inputJourneyName" class="form-control select2" "{{old('content_type_id')}}" >
											<option value="">Select option</option>
										</select>  
									</div>
									<div class="form-group col-md-6">
										<label for="inputDateName">{{ __('Targeted Completion Date') }} <span class="required">*</span></label>
										<input type="text" name="target_date" class="form-control datepicker" id="inputDateName" value="{{old('target_date')}}">
									</div>
									<div class="form-group col-md-6">
									   <label for="inputName">{{ __('Visibility') }} <span class="required">*</span></label>
										<select name="visibility" class="form-control select2" "{{old('visibility')}}" >
											<option value="">Select option</option>
											<option {{ $content->visibility == "private" ? 'selected' : '' }} value="private">Private</option>
											<option {{ $content->visibility == "public" ? 'selected' : '' }} value="public">Public</option>
										</select>   
									   @error('visibility')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
									<div class="form-group col-md-6">
									   <label for="inputName">{{ __('Compulsory or Optional') }} <span class="required">*</span></label>
										<select name="read" class="form-control select2">
											<option value="">Select option</option>
											<option {{ $content->read == "optional" ? 'selected' : '' }} value="optional">Optional</option>
											<option {{ $content->read == "compulsory" ? 'selected' : '' }} value="compulsory">Compulsory</option>
										</select>   
									   @error('visibility')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
									<div class="form-group col-md-6">
									   <label for="inputProcessName">{{ __('Free or Paid') }} <span class="required">*</span></label>
									   <input readonly name="payment_type" type="text" class="form-control" id="inputProcessName" value="{{ ucfirst($content->payment_type)}}">
									</div>
									@if($content->payment_type != "free")
									<div class="form-group col-md-6">
									   <label for="inputName">{{ __('Approver') }} <span class="required">*</span></label>
										<select name="approver_id" class="form-control select2" "{{old('payment_type')}}" >
											<option value="">Select option</option>
											@foreach($approvers as $approver)
												@if($approver->id == user_id())
													<option {{ $approver->id == $content->approver_id ? 'selected' : '' }} value="{{$approver->id}}">{{ __('lang.my_self') }}</option>
												@else	
													<option {{ $approver->id == $content->approver_id ? 'selected' : '' }} value="{{$approver->id}}">{{$approver->first_name}} {{$approver->last_name}}</option>
												@endif							
											@endforeach
										</select>   
									   @error('approver')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
									@endif
								</div>
							</div>
						</div>
					</div>
					<div class="btn-footer">
						<button type="button" data-toggle="modal" data-target="#libAssignModal" id="clearForm" class="btn btn-grey">{{ __('Clear') }}</button>
						<a href="{{route('libraries.index')}}" class="btn btn-green">{{ __('Back') }}</a>
						<button type="submit" class="btn btn-blue">{{ __('Assign') }}</button>
					</div>
				</div>
			</div>  
		</div>
		</form>
			
@endsection
