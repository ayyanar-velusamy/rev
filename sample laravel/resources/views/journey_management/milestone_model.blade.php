@php($action = $post_data['action'])
<!-- Milestone Render form modal -->
@php($journey_id = (!empty($data)) ? $data->journey_id : $post_data['journey_id'])
@php($journey_type_id = (!empty($data)) ? $data->journey_type_id : $post_data['journey_type_id'])
@php($milestone_id = (!empty($data)) ? encode_url($data->milestone_id) : '')
@php($payment_type = (!empty($data)) ? $data->payment_type : '')
@php($required = ($action != 'view') ? '*' : '')
@php($disabled = ($action == 'view') ? 'disabled' : '')
@php($visibility = (!empty($data)) ? $data->visibility : '')
@php($read = (!empty($data)) ? $data->read : '')	
@php($payment_type_readonly = '')
@php($price_readonly = '')
@php($approver_readonly = '')

@if($action == 'add')
	@php($visibility_readonly = ($post_data['visibility'] == 'private') ? 'readonly' : '')
	@php($visibility = ($post_data['visibility'] == 'private') ? 'private' : 'public')
	@php($read_readonly = ($post_data['read'] == 'compulsory') ? 'readonly' : '')
	@php($read = ($post_data['read'] == 'compulsory') ? 'compulsory' : '')
@else
	@php($visibility_readonly = ((!empty($data) && $data->journey_visibility == 'private' && $data->visibility == 'private')) ? 'readonly' : '')
	@php($read_readonly = ((!empty($data) && $data->journey_read == 'compulsory' && $data->read == 'compulsory')) ? 'readonly' : '')
	@if($journey_type_id != 2)
		@php($payment_type_readonly = (!empty($data)) ? 'readonly' : '')
		@php($price_readonly = (!empty($data)) ? 'readonly' : '')
		@php($approver_readonly = (!empty($data)) ? 'readonly' : '')
	@endif
@endif

@if($action == 'edit')
	{!! Form::open([ 'route' => ['update_milestone',$milestone_id], 'enctype' => 'multipart/form-data', 'class' => 'ajax-form clearfix', 'id'=>'milestoneModalForm' ]) !!}
@else
	{!! Form::open([ 'route' => 'store_milestone', 'enctype' => 'multipart/form-data', 'class' => 'ajax-form clearfix', 'id'=>'milestoneModalForm' ]) !!}	
@endif
<input type="hidden" id="MilestoneId" name="milestone_id" value="{{$milestone_id}}">
<input type="hidden" id="milestoneJourneyId" name="journey_id" value="{{$journey_id}}">
<input type="hidden" id="contentTypeId" name="content_type_id" value="{{$content_type_id}}">

<!-- Modal content-->
<div class="modal-content text-left">
	<div class="modal-header">
		<button type="reset" class="btn-close" title="Close" data-dismiss="modal">x</button>
		<h2 id="milstoneAddTitle">{{($action != 'view') ? ucfirst($action)." Milestone" : "View: ".$data->title }}</h2>
	</div>
	<div class="modal-body">
		<div class="white-box">	
			<div class="white-content">
				<h3>{{ __('Milestone Details') }}</h3>
				<div class="inner-content form-all-input">
					<div class="row">
						<div class="milstoneGrid col-md-4">
							@if($action != 'view')
							<div class="form-group inputTitleSec">
								<label for="inputTitleName">{{ __('Title') }} <span class="required">{{$required}}</span></label>
								@php($title = (!empty($data)) ? $data->title : '')
								<input type="text" name="title" class="form-control" id="inputTitleName" maxlength="64" value="{{old('title',$title)}}" placeholder="Enter Title">
							</div>
							@endif
							
							@if($content_type_id != 6)
							<div class="form-group inputProviderSec">
								<label for="inputProviderName">{{ __($providerSec) }} <span class="required">{{$required}}</span></label>
								@php($provider = (!empty($data)) ? $data->provider : '')
								<input {{$disabled}} type="text" name="provider" class="form-control" id="inputProviderName" maxlength="64" value="{{old('provider',$provider)}}" placeholder="Enter {{ __($providerSec) }}">
							</div>	
							@endif
							
							<div class="form-group ">
							   <label for="inputDifficultyName">{{ __('Difficulty') }} <span class="required">{{$required}}</span></label>
							   @php($difficulty = (!empty($data)) ? $data->difficulty : '')
								<select {{$disabled}} name="difficulty" id="inputDifficultyName" class="select2 form-control" "{{old('difficulty')}}" > 
									<option value="">Choose Difficulty</option>
									<option {{ ($difficulty == 'beginner') ? 'selected' : ''}} value="beginner">Beginner</option>
									<option {{ ($difficulty == 'intermediate') ? 'selected' : ''}} value="intermediate">Intermediate</option>
									<option {{ ($difficulty == 'advanced') ? 'selected' : ''}} value="advanced">Advanced</option>
								</select>
							</div>
							@if($journey_type_id == 3 && $action == 'view')
								@if($payment_type == 'free')
								<div class="form-group viewShowSec">
									<label for="inputPriceName">{{ __('Assigned by') }}</label>
									 @php($assigned_by = (!empty($data)) ? $data->assigned_by : '')
									<input {{$disabled}} type="text" name="assignedby" class="form-control" value="{{$assigned_by}}">
								</div>						
								@endif	
							@endif
							@if($journey_type_id == 1)
							<div class="form-group">
							   <label for="inputVisibilityName">{{ __('Visibility') }} <span class="required">{{$required}}</span></label>
							   @if($visibility_readonly != "")
								   <input type="hidden" name="visibility" class="form-control" value="{{$visibility}}">
								   <input readonly type="text" class="form-control" value="{{ucfirst($visibility)}}">
							   @else
								<select {{$disabled}} {{$visibility_readonly}} name="visibility" id="inputVisibilityName" class="select2 form-control">
									<option value="">Choose Visibility</option>
									<option {{ ($visibility == 'private') ? 'selected' : ''}} value="private">Private</option>
									<option {{ ($visibility == 'public') ? 'selected' : ''}} value="public">Public</option>
								</select>
								@endif
							</div>
							@endif
							@if($journey_type_id == 1)							
							<div class="form-group">
							   <label for="inputPaymentTypeName">{{ __('Free or Paid') }} <span class="required">{{$required}}</span></label>
							   @if($payment_type_readonly != "")
							   <input type="hidden" name="payment_type" class="form-control" value="{{$payment_type}}">
							   <input readonly type="text" class="form-control" value="{{ucfirst($payment_type)}}">
								@else
							    <select {{$disabled}} {{$payment_type_readonly}} name="payment_type" id="inputPaymentTypeName" class="select2 form-control" "{{old('payment_type')}}" >
									<option value="">Choose Paid or Free</option>
									<option {{ ($payment_type == 'free') ? 'selected' : ''}} value="free">Free</option>
									<option {{ ($payment_type == 'paid') ? 'selected' : ''}} value="paid">Paid</option>
								</select>
								@endif
							</div>
							@endif
							
							@if($journey_type_id == 1)
								@if(in_array($content_type_id,[2,3,4,5]))
								<div class="form-group inputLengthSec">
								   <label for="inputLengthName">{{ __($lengthSec) }} <span class="required"></span></label>
									@php($length = (!empty($data)) ? $data->length : '')
									<input {{$disabled}} type="text" name="length" class="form-control" maxlength="2048" id="inputLengthName" value="{{old('length', $length)}}" placeholder="Enter {{ __($lengthSec) }}">
								</div>
								@endif
							@endif
							
							@if($action == 'view' && $journey_type_id == 2)
								<div class="form-group viewShowSec">
									<label for="inputPriceName">{{ __('Created by') }}</label>
									 @php($created_by = (!empty($data)) ? $data->created_by : '')
									<input {{$disabled}} type="text" name="assignedby" class="form-control" value="{{ $created_by }}">
								</div>
							@endif
							
							@if($action == 'view' && $journey_type_id == 3 && $payment_type == 'paid')
							<div class="form-group">
								<label for="inputVisibilityName">{{ __('Visibility') }} <span class="required">{{$required}}</span></label>
								@if($visibility_readonly != "")
								   <input type="hidden" name="visibility" class="form-control" value="{{$visibility}}">
								   <input readonly type="text" class="form-control" value="{{ucfirst($visibility)}}">
							   @else
								<select {{$disabled}} {{$visibility_readonly}} name="visibility" id="inputVisibilityName" class="select2 form-control " "{{old('visibility')}}" >
									<option value="">Choose Visibility</option>
									<option {{ ($visibility == 'private') ? 'selected' : ''}} value="private">Private</option>
									<option {{ ($visibility == 'public') ? 'selected' : ''}} value="public">Public</option>
								</select>
								@endif
							</div>
							@endif
							
							@if($action == 'view' && $journey_type_id == 3 && $payment_type == 'paid')							
							<div class="form-group viewShowSec">
							   <label for="inputReadName">{{ __('Compulsory or Optional') }} <span class="required">{{$required}}</span></label>
							   @if($read_readonly != "")
							   <input type="hidden" name="read" class="form-control" value="{{$read}}">
							   <input readonly type="text" class="form-control" value="{{ucfirst($read)}}">
								@else
								<select {{$disabled}} {{$read_readonly}} name="read" id="inputReadName" class="form-control select2">
									<option value="">Compulsory or Optional</option>
									<option {{ ($read == 'optional') ? 'selected' : ''}} value="optional" >Optional</option>
									<option {{ ($read == 'compulsory') ? 'selected' : ''}} value="compulsory" >Compulsory</option>
								</select>
								@endif
							</div>	
							@endif
							
							@if($action == 'view' && $payment_type != 'free' && $journey_type_id != 2)	
							<div class="form-group viewShowSec">
							   <label for="inputApproverStatus">{{ __('Approval Status') }}</label>
							    @php($approval_status = (!empty($data)) ? $data->approval_status : '')
								<select {{$disabled}} id="inputApproverStatus" class="select2 form-control">
									<option value="">Choose Approver Status</option>
									<option {{ ($approval_status == 'pending') ? 'selected' : ''}} value="pending" >Pending</option>
									<option {{ ($approval_status == 'approved') ? 'selected' : ''}} value="approved" >Approved</option>
									<option {{ ($approval_status == 'rejected') ? 'selected' : ''}} value="rejected" >Rejected</option>
								</select> 
							</div>
							@endif
							
							@if($action == 'view')
								@if($journey_type_id == 1 && $payment_type == 'paid')
								<div class="form-group viewShowSec">
									<label for="inputDaysLeft">{{ __('Days Left for Completion') }}</label>
									 @php($days_left = (!empty($data)) ? $data->days_left : '')
									<input {{$disabled}} type="text" class="form-control" id="inputDaysLeft" value="{{$days_left}}">
								</div>									
								@if($content_type_id == 1 || $content_type_id == 6 || $content_type_id == 7 )
								<div class="form-group viewShowSec">
									<label for="inputPriceName">{{ __('Assigned by') }}</label>
									 @php($assigned_by = (!empty($data)) ? $data->assigned_by : '')
									<input {{$disabled}} type="text" name="assignedby" class="form-control" value="{{$assigned_by}}">
								</div>
								@endif	
								@endif
							@endif
							@if($journey_type_id == 1 && ($action != 'view' || (($action == 'view' && ($content_type_id == 1 || $content_type_id == 6 || $content_type_id == 7 ) && $content_type_id != 2 && $content_type_id != 3 ) || ($payment_type == 'paid'))))
								<div class="form-group inputTags">
								   <label for="inputTagsName">{{ __('Tags') }}</label>
									@php($tags = (!empty($data)) ? $data->tags : '')
									<select {{$disabled}} name="tags[]" multiple class=" form-control tagsInput" id="inputTagsName">
									@if($tags != "")
									@foreach(explode(',',$tags) as $tag)
									<option selected value="{{$tag}}">{{$tag}}</option>
									@endforeach
									@endif
									</select>
								</div>
							@endif	
							@if($journey_type_id == 1 && $action == 'view' && $data->status == 'completed' && ($content_type_id == 6 && $payment_type != 'free'))	
							<div class="form-group viewShowSec">
								<label for="inputRating">{{ __('Rating') }} <span class="required">{{$required}}</span></label>
								 @php($rating = (!empty($data)) ? $data->rating : '')
								<input {{$disabled}} type="text" class="form-control" id="inputRating" value="{{$rating}}">
							</div>
							@endif
						</div>
						<div class="milstoneGrid col-md-8">
							<div class="row m-0">									
								<div class="form-group inputURLSec col-md-6 pl-0">
									<label for="inputURLName">{{ __('URL') }} <span class="required">{{($content_type_id != 4) ? $required : ''}}</span> </label>
									 @php($url = (!empty($data)) ? $data->url : '')
									<input {{$disabled}} type="text" name="url" class="form-control" maxlength="2048" id="inputURLName" value="{{old('url',$url)}}" placeholder="Enter URL">
								</div>
								<div class="form-group col-md-6 pr-0">
								   <label for="inputName">{{ __('Milestone Type') }} </label>
								      	<select name="content_type_id" id="content_type_id" disabled class=" form-control" "{{old('content_type_id')}}" >
										<option value="">Select option</option>
										@foreach($content_types as $type)
										<option {{ ($content_type_id == $type->id) ? 'selected' : ''}} value="{{ $type->id }}">{{$type->name}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="form-group">
							   <label for="inputDescriptionName">{{ __('Description') }}</label>
							    @php($description = (!empty($data)) ? $data->description : '')
								<textarea {{$disabled}} id="inputDescriptionName" name="description" maxlength="1024" placeholder="Enter Description" class="form-control">{{old('description', $description)}}</textarea>
							</div>
							
							@if($journey_type_id == 1)
							<div class="row m-0">
								<div class="form-group col-md-6 pl-0">
								   <label for="start_date">{{ __('Start Date') }}</label>
								    @php($start_date = (!empty($data)) ? get_date($data->start_date) : get_date())
								<input {{$disabled}} type="text" name="start_date" class="form-control datepicker" id="start_date" value="{{old('start_date',$start_date)}}" placeholder="Pick Start Date ">
								</div>
								<div class="form-group col-md-6 pr-0">
								   <label for="inputName">{{ __('Targeted Completion Date') }} <span class="required">{{$required}}</span></label>
								    @php($end_date = (!empty($data)) ? get_date($data->end_date) : '')
								<input {{$disabled}} type="text" name="end_date" class="form-control datepicker" id="end_date" value="{{old('end_date',$end_date)}}" placeholder="Pick Targeted Completion Date">
								</div>
							</div>
							@endif
							
							@if($journey_type_id == 1)
							<div class="row m-0">
								<div class="form-group paymentTypeSec {{($payment_type == 'paid') ? '': 'd-none'}} col-md-6 p-0 pr-4">
									<label for="inputPriceName">{{ __('Price') }} <span class="required">{{$required}}</span></label>
									 @php($price = (!empty($data)) ? $data->price : '')
									<input {{$disabled}} {{$price_readonly}} type="text" name="price" class="form-control priceField" id="inputPriceName" maxlength="7" value="{{old('price',$price)}}" placeholder="Enter Price">
								</div>
								<div class="form-group paymentTypeSec {{($payment_type == 'paid') ? '': 'd-none'}} col-md-6 p-0 pl-4">
								   <label for="inputApproverName">{{ __('Approver') }} <span class="required">{{$required}}</span></label>
								    @php($approver_id = (!empty($data)) ? $data->approver_id : '')
									<select {{$disabled}} {{$approver_readonly}} name="approver_id" id="inputApproverName" class="select2 form-control">
										<option value="">Choose Approver</option>
										@foreach($approvers as $approver)
										@if($approver->id == user_id())
											<option {{ ($approver_id == $approver->id) ? 'selected' : ''}} value="{{$approver->id}}">{{ __('lang.my_self') }}</option>
										@else	
											<option {{ ($approver_id == $approver->id) ? 'selected' : ''}} value="{{$approver->id}}">{{$approver->first_name}} {{$approver->last_name}}</option>
										@endif
										@endforeach
									</select>
								</div>
							</div>	
							@endif
							
							@if($action == 'view')								
							<div class="row m-0">
								@if($journey_type_id == 1 && ($content_type_id != 6 || $payment_type == 'paid'))
								<div class="form-group viewShowSec  col-md-6 pl-0">
									<label for="inputDaysLeft">{{ __('Days Left for Completion') }}</label>
									 @php($days_left = (!empty($data)) ? $data->days_left : '')
									<input {{$disabled}} type="text" class="form-control" id="inputDaysLeft" value="{{$days_left}}">
								</div>									
								<div class="form-group viewShowSec  col-md-6 pr-0">
									<label for="inputPriceName">{{ __('Assigned by') }}</label>
									 @php($assigned_by = (!empty($data)) ? $data->assigned_by : '')
									<input {{$disabled}} type="text" name="assignedby" class="form-control" value="{{$assigned_by}}">
								</div>
								@endif
							</div>
							@endif
							
							@if($journey_type_id == 1 && $action != 'view')							
							<div class="form-group milestoneNoteSec "> 
							   <label for="inputNoteName">{{ __('Notes') }} <span data-toggle="tooltip" data-placement="right" data-html="true" title="What are your major takeaways from this Milestone? How will it impact your work?" ><i class="icon-info"></i> </span></label>
							    @php($notes = (!empty($data)) ? $data->notes : '')
								<textarea {{$disabled}} id="inputNoteName" name="notes" placeholder="Enter Notes" class="form-control">{{old('notes', $notes)}}</textarea>
							</div>
							@endif
							
							@if($action == 'view' && $payment_type != 'free' && $journey_type_id != 2)						
							<div class="form-group viewShowSec ">
							   <label for="inputApprovalCommentName">{{ __('Approval Comments') }} </label>
							    @php($approval_comment = (!empty($data)) ? $data->approval_comment : '')
								<textarea {{$disabled}} id="inputApprovalCommentName" name="comments" class="form-control">{{$approval_comment}}</textarea>   
							</div>
							@endif
							
						</div>						
					</div>
					
					@if($journey_type_id != 1)
					<div class="row">
						<div class="form-group col-md-4">
						   <label for="inputPaymentTypeName">{{ __('Free or Paid') }} <span class="required">{{$required}}</span></label>
						   @if($payment_type_readonly != "")
							   <input type="hidden" name="payment_type" class="form-control" value="{{$payment_type}}">
							   <input readonly type="text" class="form-control" value="{{ucfirst($payment_type)}}">
							@else
							<select {{$disabled}} {{$payment_type_readonly}} name="payment_type" id="inputPaymentTypeName" class="select2 form-control" "{{old('payment_type')}}" >
								<option value="">Choose Paid or Free</option>
								<option {{ ($payment_type == 'free') ? 'selected' : ''}} value="free">Free</option>
								<option {{ ($payment_type == 'paid') ? 'selected' : ''}} value="paid">Paid</option>
							</select>
							@endif
						</div>
						<div class="form-group col-md-4">
						   <label for="start_date">{{ __('Start Date') }}</label>
							@php($start_date = (!empty($data)) ? get_date($data->start_date) : get_date())
							<input {{$disabled}} type="text" name="start_date" class="form-control datepicker" id="start_date" value="{{old('start_date',$start_date)}}" placeholder="Pick Start Date ">
						</div>
						<div class="form-group col-md-4">
						   <label for="inputName">{{ __('Targeted Completion Date') }} <span class="required">{{$required}}</span></label>
							@php($end_date = (!empty($data)) ? get_date($data->end_date) : '')
							<input {{$disabled}} type="text" name="end_date" class="form-control datepicker" id="end_date" value="{{old('end_date',$end_date)}}" placeholder="Pick Targeted Completion Date">
						</div>
						<div class="form-group paymentTypeSec {{($payment_type == 'paid') ? '': 'd-none'}} col-md-4">
							<label for="inputPriceName">{{ __('Price') }} <span class="required">{{$required}}</span></label>
							 @php($price = (!empty($data)) ? $data->price : '')
							<input {{$disabled}} {{$price_readonly}} type="text" name="price" class="form-control priceField" id="inputPriceName" maxlength="7" value="{{old('price',$price)}}" placeholder="Enter Price">
						</div>
						<div class="form-group paymentTypeSec {{($payment_type == 'paid') ? '': 'd-none'}} col-md-4">
						   <label for="inputApproverName">{{ __('Approver') }} <span class="required">{{$required}}</span></label>
							@php($approver_id = (!empty($data)) ? $data->approver_id : '')
							<select {{$disabled}} {{$approver_readonly}} name="approver_id" id="inputApproverName" class="select2 form-control">
								<option value="">Choose Approver</option>
								@foreach($approvers as $approver)
								@if($approver->id == user_id())
									<option {{ ($approver_id == $approver->id) ? 'selected' : ''}} value="{{$approver->id}}">{{ __('lang.my_self') }}</option>
								@else	
									<option {{ ($approver_id == $approver->id) ? 'selected' : ''}} value="{{$approver->id}}">{{$approver->first_name}} {{$approver->last_name}}</option>
								@endif
								@endforeach
							</select>
						</div>						
						@if($action == 'view' && $journey_type_id == 3 && $payment_type == 'paid')
						
						@else
						<div class="form-group col-md-4">
							<label for="inputVisibilityName">{{ __('Visibility') }} <span class="required">{{$required}}</span></label>
							@if($visibility_readonly != "")
							   <input type="hidden" name="visibility" class="form-control" value="{{$visibility}}">
							   <input readonly type="text" class="form-control" value="{{ucfirst($visibility)}}">
						   @else
							<select {{$disabled}} {{$visibility_readonly}} name="visibility" id="inputVisibilityName" class="select2 form-control " "{{old('visibility')}}" >
								<option value="">Choose Visibility</option>
								<option {{ ($visibility == 'private') ? 'selected' : ''}} value="private">Private</option>
								<option {{ ($visibility == 'public') ? 'selected' : ''}} value="public">Public</option>
							</select>
							@endif
						</div>									
						<div class="form-group viewShowSec col-md-4">
						   <label for="inputReadName">{{ __('Compulsory or Optional') }} <span class="required">{{$required}}</span></label>
						    @if($read_readonly != "")
							   <input type="hidden" name="read" class="form-control" value="{{$read}}">
							   <input readonly type="text" class="form-control" value="{{ucfirst($read)}}">
							@else
							<select {{$disabled}} {{$read_readonly}} name="read" id="inputReadName" class="form-control select2">
								<option value="">Compulsory or Optional</option>
								<option {{ ($read == 'optional') ? 'selected' : ''}} value="optional" >Optional</option>
								<option {{ ($read == 'compulsory') ? 'selected' : ''}} value="compulsory" >Compulsory</option>
							</select>
							@endif
						</div>	
						@endif
						@if(in_array($content_type_id,[2,3,4,5]))
						<div class="form-group inputLengthSec col-md-4">
						   <label for="inputLengthName">{{ __($lengthSec) }} <span class="required"></span></label>
							@php($length = (!empty($data)) ? $data->length : '')
							<input {{$disabled}} type="text" name="length" class="form-control" maxlength="2048" id="inputLengthName" value="{{old('length', $length)}}" placeholder="Enter {{ __($lengthSec) }}">
						</div>
						@endif
										
						@if($action == 'view')								
							@if($journey_type_id == 3)
							<div class="form-group viewShowSec col-md-4">
								<label for="inputDaysLeft">{{ __('Days Left for Completion') }}</label>
								 @php($days_left = (!empty($data)) ? $data->days_left : '')
								<input {{$disabled}} type="text" class="form-control" id="inputDaysLeft" value="{{$days_left}}">
							</div>
							@if($payment_type == 'paid')
							<div class="form-group viewShowSec col-md-4">
								<label for="inputPriceName">{{ __('Assigned by') }}</label>
								 @php($assigned_by = (!empty($data)) ? $data->assigned_by : '')
								<input {{$disabled}} type="text" name="assignedby" class="form-control" value="{{$assigned_by}}">
							</div>						
							@endif							
							@endif							
						@endif
						<div class="form-group inputTags col-md-4">
						   <label for="inputTagsName">{{ __('Tags') }}</label>
							@php($tags = (!empty($data)) ? $data->tags : '')
							<select {{$disabled}} name="tags[]" multiple class=" form-control tagsInput" id="inputTagsName">
							@if($tags != "")
								@foreach(explode(',',$tags) as $tag)
								<option selected value="{{$tag}}">{{$tag}}</option>
								@endforeach
							@endif
							</select>
						</div>
						@if($action == 'view')								
							@if($journey_type_id == 3)
								@if($data->status == 'completed')	
								<div class="form-group viewShowSec col-md-4">
									<label for="inputRating">{{ __('Rating') }} <span class="required">{{$required}}</span></label>
									 @php($rating = (!empty($data)) ? $data->rating : '')
									<input {{$disabled}} type="text" class="form-control" id="" value="{{$rating}}">
								</div>
								@endif
							@endif
						@endif
						@if($action == 'view' && $data->current_user_id == 'NA' && $data->status == 'completed')
							<div class="form-group viewShowSec col-md-4">
								<label for="inputPoint">{{ __('Points Earned') }}</label>
								 @php($point = (!empty($data)) ? $data->point : '')
								<input {{$disabled}} type="text" class="form-control" id="inputPoint" value="{{$point}}">
							</div>		
						@endif
					</div>
					@endif
					<div class="row">
					
						@if($journey_type_id == 1 && $action == 'view' && ($content_type_id != 1) && ($content_type_id != 7) && ($content_type_id != 6) && ($content_type_id != 5 || $payment_type == 'free') && ($content_type_id != 4 || $payment_type == 'free') && (($content_type_id != 2 && $content_type_id != 3 ) || $payment_type != 'paid'))
							<div class="form-group inputTags  col-md-4">
							   <label for="inputTagsName">{{ __('Tags') }}</label>
							    @php($tags = (!empty($data)) ? $data->tags : '')
								<select {{$disabled}} name="tags[]" multiple class=" form-control tagsInput" id="inputTagsName">
								@if($tags != "")
								@foreach(explode(',',$tags) as $tag)
								<option selected value="{{$tag}}">{{$tag}}</option>
								@endforeach
								@endif
								</select>
							</div>
						@endif
						@if($content_type_id == 6 && $payment_type == 'free')
							<div class="form-group viewShowSec  col-md-4">
								<label for="inputDaysLeft">{{ __('Days Left for Completion') }}</label>
								 @php($days_left = (!empty($data)) ? $data->days_left : '')
								<input {{$disabled}} type="text" class="form-control" id="inputDaysLeft" value="{{$days_left}}">
							</div>									
							<div class="form-group viewShowSec  col-md-4">
								<label for="inputPriceName">{{ __('Assigned by') }}</label>
								 @php($assigned_by = (!empty($data)) ? $data->assigned_by : '')
								<input {{$disabled}} type="text" name="assignedby" class="form-control" value="{{$assigned_by}}">
							</div>
							<div class="form-group viewShowSec col-md-4">
								<label for="inputRating">{{ __('Rating') }} <span class="required">{{$required}}</span></label>
								 @php($rating = (!empty($data)) ? $data->rating : '')
								<input {{$disabled}} type="text" class="form-control" id="inputRating" value="{{$rating}}">
							</div>
						@endif					
						@if($journey_type_id == 1 && $action == 'view' && $data->status == 'completed')	
							@if($content_type_id != 6)
							<div class="form-group viewShowSec col-md-4">
								<label for="inputRating">{{ __('Rating') }} <span class="required">{{$required}}</span></label>
								 @php($rating = (!empty($data)) ? $data->rating : '')
								<input {{$disabled}} type="text" class="form-control" id="inputRating" value="{{$rating}}">
							</div>
							@endif
							@if($action == 'view' && $data->current_user_id == 'NA' && $data->status == 'completed')
							<div class="form-group viewShowSec col-md-4">
								<label for="inputPoint">{{ __('Points Earned') }}</label>
								 @php($point = (!empty($data)) ? $data->point : '')
								<input {{$disabled}} type="text" class="form-control" id="inputPoint" value="{{$point}}">
							</div>		
							@endif
						</div>
						@endif						
					</div>
				</div>
			</div>
		</div>
		<div class="btn-footer pb-5">
			<button type="reset" class="btn-grey btn milestoneCancelBtn" data-dismiss="modal">Cancel</button>
			@if($action != 'view')
			<button type="submit" id="milestoneSaveBtn" class="btn-green btn " id="importehrsub">Save</button>
			@endif	
			@if($action == 'view')
				@if($data->status == 'assigned' && $data->journey_status == 'active' && $data->journey_type_id != 2 && $data->current_user_id == $data->assigned_user_id &&(($data->payment_type != 'free' && $data->approval_status == 'approved') || $data->payment_type == 'free'))			
				<button type="button" id="markAsCompleteBtn" class="btn-blue btn ">Mark as Complete</button>
				@endif
			@endif
		</div>
	</div>
</div>
{{ Form::close() }}
<script>
$("#inputURLName").bind("paste", function(e){
	catchPaste(e, this, function(pastedUrl) {
		// access the clipboard using the api
		if(pastedUrl.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g)){ 
			get_meta_tags(pastedUrl);
		}	
	});
});

$(document).ready(function() {
	if($('.select2').length > 0){
		$('.select2').select2({ minimumResultsForSearch: -1});
	}
	$(".tagsInput").select2({ 
		tags: true,
		placeholder: "Enter Tags",
		tokenSeparators: ['', ''],
		maximumInputLength:64,
		 createTag: function(params) {
			if(params.term.match(/^[a-zA-Z]+$/g)){
				return { id: params.term, text: params.term };
			}	
		},
	});
	
});
$(function() {
  $(".datepicker").datepicker({
	   dateFormat: 'M d, yy',
	   minDate: new Date()
  });
});

if($('#end_date').length > 0){
	$('#end_date').on('change', function(evt){
		$(this).valid();
	});
}

/* if ($('select[readonly]').hasClass("select2-hidden-accessible")) {
    // Select2 has been initialized
    $('select[readonly]').select2('destroy');
	$('select[readonly]').attr('tabindex', '-1');
} */

if($('#milstoneAdd .select2.form-control').length > 0){
	$('#milstoneAdd .select2.form-control').on('change', function(evt){
		$(this).valid();
	});
}
$(document).ready(function() { 
	$this = $('input[type="hidden"]#contentTypeId');
	console.log($this.val());
	
	$("#milestoneModalForm").validate({ 
		rules: {
			url: {
				required: function(element) {if ($this.val() == 4) {return false;}else{ return true;}},
				minlength:4,
				maxlength:2048,
				url:true,
				noSpace:function(element){if ($this.val() == 4) {return false;}else{ return true;}},
			},
			title: {
				required: true,
				minlength:4,
				maxlength: 64,
				alphanumeric:true,
			},
			provider: {
				required: true,
				minlength:function(element) {var length = "4"; if ($this.val() == 4 && $this.val() == 3) {length = "1"; }; return length;},
				maxlength:function(element) {var length = "64"; if ($this.val() == 4) {length = "40"; }; return length;},
				alphanumeric:function(element) { return [$this.val()] },
				lettersSpaceonly:function(element) {return [$this.val()]}, 
				
			},
			description: {
				required: false,
				maxlength:1024,
			},
			end_date: {
				required: true,
				greaterThan: '#start_date'
			},
			payment_type: {
				required:true,
			},
			difficulty: {
				required:true,
			},
			visibility: {
				required:true,
			},
			read: {
				required:true,
			},
			price: {
				required:true,
				maxlength: 7,
				number: true,
				min:1,
			},
			approver_id: {
				required:true,
			},
			length: {
				required: false,
				maxlength: 5,
				numeric:true,
				//noSpace:true,
			},
			
			notes: {
				maxlength: 40,
				alphanumeric:true,
			},
			/* "tags[]": {
				maxlength: 64, 
				lettersonly:true,	
			} */
		},

		messages: {
			url: {
				required:"URL cannot be empty.",
				url:"Enter a Valid URL", 
				noSpace:"URL cannot contain space",
			},
			title: {
				required:"Title cannot be empty",
				minlength:"Title cannot be less than 4 characters",
				maxlength:"Title cannot be more than 64 characters",
				alphanumeric:"Title should contain only Alphabets and Numerics", 
			},	
			provider: {
				required:function(element) {var message = "Provider cannot be empty"; if ($this.val() == 4) {message = "Author cannot be empty"; }else if($this.val() == 3){message = "Episode Name cannot be empty";}; return message;},
				minlength:function(element) {var message = "Provider cannot be less than 4 characters"; if ($this.val() == 4) {message = "Author cannot be less than 1 characters"; }else if($this.val() == 3){message = "Episode Name be less than 1 characters";}; return message;},
				maxlength:function(element) {var message = "Provider cannot be more than 64 characters"; if ($this.val() == 4) {message = "Author cannot be more than 40 characters"; }else if($this.val() == 3){message = "Episode Name cannot be more than 64 characters";}; return message;},
				alphanumeric:"Provider should contain only Alphabets and Numerics" , 
				lettersSpaceonly:"Author should contain only alphabets and spaces",
			},
			description: {
				maxlength:"Description cannot be more than 1024 characters",
			},
			notes: {
				maxlength:"Notes cannot be more than 40 characters.",
				alphanumeric: "Notes should contain only Alphabets and Numerics"
			},
			end_date: {
				required:"Targeted Completion Date cannot be empty",
				greaterThan: "Target date should not be less than the start date"
			},
			payment_type: {
				required:"Paid or Free cannot be empty",
			},
			difficulty: {
				required:"Difficulty cannot be empty",
			},
			visibility: {
				required:"Visibility cannot be empty",
			},
			read: {
				required:"Please choose an option",
			},
			price: {
				required:"Price cannot be empty",
				maxlength: "Price cannot be more than 7 characters",
				number:"Price should only consist of Numerics",
				min: "Price cannot be zero",
			},
			approver_id: {
				required:"Approver cannot be empty",
			},
			length: {
				maxlength: "Length cannot exceed more than 5 characters",
				numeric: "Length should contain only numeric's",
				//noSpace: "Length cannot contain space."
			},
			/* "tags[]": {
				maxlength: "Tags cannot be more than 64 characters",
				lettersonly: "fsd",
			} */

		},
		errorElement: "span",
		errorPlacement: function(error, element) {
			$('span.removeclass-valid').remove();
			var placement = $(element).data('error');
			if (placement) {
				$(placement).append(error)
			 } else {
				if(element.hasClass('select2') && element.next('.select2-container').length) {
					error.insertAfter(element.next('.select2-container'));
				}else if(element.hasClass('tagsInput') && element.next('.select2-container').length) {
					error.insertAfter(element.next('.select2-container'));
				}else{
					error.insertAfter(element); 
				}
			}
		}
	});
});  

</script>

