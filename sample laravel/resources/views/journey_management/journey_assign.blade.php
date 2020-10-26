@extends('layouts.app')

@section('content')

<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('journeys.index')}}">{{ __('Predefined Learning Journey List') }}</a></li>
			<li class="active"><a href="javascript:">Assign</a></li>
		</ul>
	</div>
   <!-- Main row -->
	<div class="page-content plj_assign">
        <!-- left column -->
		<form method="POST" class="ajax-form1" id="journeyAssignForm" action="{{route('journeys.store_assign')}}" role="form" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="journey_id" value="{{ Request::route('id') }}">
		<input type="hidden" name="assignment_type" value="predefined">
		<div class="white-box col-md-12 pad-zero">	
			<!--<div class="white-box-head">	
				<h2>Assign Journey : {{$journey->journey_name}}</h2>
			</div>-->
			<div class="white-top-content">
				<ul class="nav nav-tabs" id="plj_assignTab">
				<li class="nav-item">
				  <a class="nav-link active" onclick="activeAssignTab('user')" data-toggle="tab" href="#assignUser">User</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" onclick="activeAssignTab('group')" data-toggle="tab" href="#assignGroup">Group</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" onclick="activeAssignTab('grade')" data-toggle="tab" href="#assignGrade">Grade</a>
				</li>
			  </ul>
			</div>
			<div class="white-content">
				<div class="inner-content form-all-input pt-0">
					<div class="row">
						<div class="col-md-5  pl-0">
							<div class="tab-content">
								<div id="assignUser" class="tab-pane active">
									<div class="addMultipleUser pl-0">
										<div class="form-group">
											<div class="adduser_field">
												<label for="inputUserName">{{ __('User') }} <span class="required">*</span></label>
												<select class="select2 form-control" id="inputUserName">
													<option value="">Select User</option>
													@foreach($users as $user)
													<option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
													@endforeach
												</select> 
												<span class="error adduser-error " style="display:none;"></span>
											</div>
											<div class="adduser_btn">
												<button type="button" id="assignAddUser" class="btn btn-green" > Add User</button>
											</div>
										</div>
										<div class="addMulUserscroll">
											<ul class="addMulUserList mb-0" id="addMulUserList"></ul>
										</div>
										<span id="user-error" class=" userempty-error" style="display:none;"></span>
									</div>
								</div>
								<div id="assignGroup" class="tab-pane">
									<div class="addMultipleUser pl-0">
										<div class="form-group">
											<div class="adduser_field">
												<label for="inputGroupName">{{ __('Group') }} <span class="required">*</span></label>
												<select class="form-control select2" id="inputGroupName">
													<option value="">Select Group</option>
													@foreach($groups as $group)
													<option value="{{$group->id}}">{{$group->group_name}}</option>
													@endforeach
												</select>
												<span class=" adduser-error " style="display:none;"></span>
											</div>
											<div class="adduser_btn">
												<button type="button" id="assignAddGroup" class="btn btn-green" > Add Group</button>
											</div>
										</div>
										<div class="addMulUserscroll">
											<ul class="addMulUserList  mb-0" id="addMulGroupList"></ul>
										</div>
										
										
										<span id="group-error" class=" userempty-error" style="display:none;"></span>
									</div>
								</div>
								<div id="assignGrade" class="tab-pane">
									<div class="addMultipleUser pl-0">
										<div class="form-group">
											<div class="adduser_field">
												<label for="inputGradeName">{{ __('Grade') }} <span class="required">*</span></label>
												<select class="form-control select2" id="inputGradeName">
													<option value="">Select Grade</option>
													@foreach($grades as $grade)
													<option value="{{$grade->node_id}}">{{$grade->node_name}}</option>
													@endforeach
												</select>
												<span id="grade-error" class="error adduser-error " style="display:none;"></span>
											</div>
											<div class="adduser_btn">
												<button type="button" id="assignAddGrade" class="btn btn-green" > Add Grade</button>
											</div>
										</div>
										<div class="addMulUserscroll">
											<ul class="addMulUserList  mb-0" id="addMulGradeList"></ul>
										</div>
										<span class="userempty-error" style="display:none;"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-7 pr-0"> 
							<div class="row">
								<div class="col-md-6"> 
									<div class="form-group">
										<label for="inputVisibility_group">{{ __('Journey Visibility') }} <span class="required">*</span></label>
										<select class="select2 form-control" id="inputVisibility_group" name="j_visibility">
											<option value="">Select visibility of the Journey</option>
											<option value="private" >Private</option>
											<option value="public" >Public</option>
										</select>
									</div>
								</div>
								<div class="col-md-6"> 
									<div class="form-group">
										<label for="inputJourneyCompulOpt_group">{{ __('Journey Compulsory or Optional') }} <span class="required">*</span></label>
										<select class="form-control select2" id="inputJourneyCompulOpt_group" name="j_read"> 
											<option value="">Choose Compulsory or Optional</option>
											<option value="optional" >Optional</option>
											<option value="compulsory" >Compulsory</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="white-content">
				<h3>Milestone List</h3>
				<div class="inner-content form-all-input ">
					<div class="pljAssignMilestone_details">
						@foreach($journey->milestones as $key=>$milestone)
						<input type="hidden" name="milestone_id[]" value="{{$milestone->id}}">
						<input name="payment_type[{{$milestone->id}}]" type="hidden" value="{{ $milestone->payment_type}}">
						<div class="row milestone_info mn-15">
							<div class="col-md-3 form-group">
								<label for="inputTitleName_{{$milestone->id}}">{{ __('Milestone Title') }}: <span class="maxname label_rgt">{{$milestone->title}}</span> </label>
							</div>
							<div class="col-md-2 form-group">
								<label for="inputTitleName_{{$milestone->id}}">{{ __('Milestone Type') }}: <span class="label_rgt">{{ucfirst($milestone->milestone_type_name())}}</span></label>
							</div>
							<div class="col-md-2 form-group">
								<label for="inputTitleName_{{$milestone->id}}">{{ __('Free or Paid') }}: <span class="label_rgt">{{ ucfirst($milestone->payment_type)}}</span></label>
							</div>
						</div>	
						
						
						<div class="row mn-15">
							<!--<div class="col-md-3 form-group">
								<label for="inputTitleName_{{$milestone->id}}">{{ __('Milestone Title') }}</label>
								<input disabled type="text" class="form-control" id="inputTitleName_{{$milestone->id}}" value="{{$milestone->title}}">
							</div>
							<div class="col-md-3 form-group">
							   <label for="inputName">{{ __('Milestone Type') }}</label>
								<select disabled class="form-control" "{{old('content_type_id')}}" >
									<option value="">Select option</option>
									@foreach($content_types as $type)
									<option {{ $type->id == $milestone->content_type_id ? 'selected' : '' }} value="{{ $type->id }}">{{$type->name}}</option>
									@endforeach
								</select>  
							</div>-->
							<div class="col-md-3 form-group">
								<label for="inputDateName{{$milestone->id}}">{{ __('Targeted Completion Date') }} <span class="required">*</span></label>
								<input type="hidden" id="start_date{{$milestone->id}}"  name="start_date[{{$milestone->id}}]" class="datepicker" value ="{{old('start_date',get_date($milestone->start_date))}}">
								<input type="text" name="target_date[{{$milestone->id}}]" class="form-control datepicker" placeholder="Pick Targeted Completion Date" id="inputDateName{{$milestone->id}}" value="{{get_date(date('Y-m-d', strtotime('+'.(($key+1)*14).' days', strtotime(get_db_date()))))}}">
							</div>
							<div class="col-md-2 form-group">
							   <label for="inputMilestoneVisibility{{$milestone->id}}">{{ __('Visibility') }} <span class="required">*</span></label>
								<select name="visibility[{{$milestone->id}}]"  id="inputMilestoneVisibility{{$milestone->id}}" class="form-control select2" >
									<option value="">Select visibility</option>
									<option {{ $milestone->visibility == "private" ? 'selected' : '' }} value="private">Private</option>
									<option {{ $milestone->visibility == "public" ? 'selected' : '' }} value="public">Public</option>
								</select>   
							   @error('visibility')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							<div class="col-md-2 form-group">
							   <label for="inputMilestoneCompulOpt{{$milestone->id}}">{{ __('Compulsory or Optional') }} <span class="required">*</span></label>
								<select name="read[{{$milestone->id}}]" id="inputMilestoneCompulOpt{{$milestone->id}}" class="form-control select2">
									<option value="">Choose Compulsory or Optional</option>
									<option {{ $milestone->read == "optional" ? 'selected' : '' }} value="optional">Optional</option>
									<option {{ $milestone->read == "compulsory" ? 'selected' : '' }} value="compulsory">Compulsory</option>
								</select>   
							   @error('visibility')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							<!--<div class="col-md-3 form-group">
							   <label for="inputPaymentType_{{$milestone->id}}">{{ __('Free or Paid') }} </label>
							   <input readonly name="payment_type[{{$milestone->id}}]" type="text" class="form-control" id="inputPaymentType_{{$milestone->id}}" value="{{ ucfirst($milestone->payment_type)}}">
							</div>-->
							@if($milestone->payment_type != "free")
							<div class="col-md-2 form-group">
							   <label for="inputPrice{{$milestone->id}}">{{ __('Price') }} <span class="required">*</span></label>
							   <input type="text" name="price[{{$milestone->id}}]"  class="form-control priceField" id="inputPrice{{$milestone->id}}" value="{{ $milestone->price}}">
							</div>
							<div class="col-md-3 form-group">
							   <label for="inputApprover{{$milestone->id}}">{{ __('Approver') }} <span class="required">*</span></label>
								<select name="approver_id[{{$milestone->id}}]" id="inputApprover{{$milestone->id}}" class="form-control select2" "{{old('payment_type')}}" >
									<option value="">Select Approver</option>
									@foreach($approvers as $approver)
										@if($approver->id == user_id())
											<option {{ $approver->id == $milestone->approver_id ? 'selected' : '' }} value="{{$approver->id}}">{{ __('lang.my_self') }}</option>
										@else	
											<option {{ $approver->id == $milestone->approver_id ? 'selected' : '' }} value="{{$approver->id}}">{{$approver->first_name}} {{$approver->last_name}}</option>
										@endif									
									@endforeach
								</select>   
							   @error('approver')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							@endif
						</div>
						@endforeach
					</div>
				</div>
			</div>  
		</div>
			<div class="btn-footer">
				<button type="button" onclick="resetForm()" class="btn btn-grey" id="resetAssign">Clear</button>
				<a href="{{ back_url(route('journeys.index')) }}" class="btn btn-green">{{ __('Back') }}</a>
				<button type="submit" class="btn btn-blue" id="assign_btn">Assign</button>
			</div>
		</form>
	</div>
</div>
@endsection
