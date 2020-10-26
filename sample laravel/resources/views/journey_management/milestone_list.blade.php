<div class="comn_dataTable">
	<div class="title_nd_btn">
		<div class="top_left">
			<h3>Milestones Added</h3>
		</div>
		<div class="top_right top_right_btn">
		  @if(!str_contains(Request::url(), 'show') && @(GetActionMethodName() != 'show'))
			  @can('add_journeys')
			  @php($j_id = ($journey) ? encode_url($journey->id) : '')
			  @php($j_vis = ($journey) ? $journey->visibility : '')
			  @php($j_t_id = ($journey) ? $journey->journey_type_id : '')
			  @php($j_read = ($journey) ? $journey->read : '')
			  <a id="addMilestoneModalBtn" href="" tabindex="0" title="{{ __('Add Milestone')}}"data-toggle="modal" onclick="addMilestone('{{$j_id}}','{{$j_vis}}','{{$j_t_id}}','{{$j_read}}')"  class="new-user btn btn-green pull-right"><i class="icon-plus"></i> {{ __('Add Milestone')}}</a> 
			  @endcan
		  @endif
		</div>
	</div>
	<!-- general form elements -->
	<div class="box box-primary">
		<div class="table-responsive">
			@php($assignment_type = (isset($assigned_data)) ? $assigned_data->assignment_type : '')
			<table width="100%" id="{{(($journey_type_id == 3 || $journey_type_id == 4 || $assignment_type == 'library') ? 'assignedMilestoneList' : (( $journey_type_id == 2 ) ? 'prdefinedMilestoneList' : 'journeyMilestoneList'))}}" class="table milestoneAddedTable">
			  <thead>
			  <tr>
				<th>Milestone Title</th>
				<th>Milestone Type</th>
				<th>Days left for completion</th>
				<th class="compORoptional">Compulsory or Optional</th>
				<th class="visibility">Visibility</th>
				<th>Action</th>
			  </tr>
			  </thead>
			</table>
		</div>
	</div>
</div>

<!-- Milestone add modal -->
<div id="milstoneAdd" class="modal modelBig fade" role="dialog"  data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered" id="loadMilstoneAddModal">
		<!--{!! Form::open([ 'route' => 'store_milestone', 'enctype' => 'multipart/form-data', 'class' => 'ajax-form clearfix', 'id'=>'milestoneModalForm' ]) !!}
		@php($journey_id = ($journey) ? $journey->id : '')
		<input type="hidden" id="MilestoneId" name="milestone_id">
		<input type="hidden" id="milestoneJourneyId" name="journey_id" value="{{$journey_id}}">
		<input type="hidden" id="contentTypeId" name="content_type_id">
		<!-- Modal content--
		<div class="modal-content text-left">
			<div class="modal-header">
				<button type="reset" class="btn-close" title="Close" data-dismiss="modal">x</button>
				<h2 id="milstoneAddTitle">Add Milestone</h2>
			</div>
			<div class="modal-body">
				<div class="white-box">	
					<div class="white-content">
						<h3>{{ __('Milestone Details') }}</h3>
						<div class="inner-content form-all-input">
							<div class="row">
								<div class="milstoneGrid col-md-4 pl-2 pr-4">
									<div class="form-group inputTitleSec">
										<label for="inputTitleName">{{ __('Title') }} <span class="required">*</span></label>
										<input type="text" name="title" class="form-control" id="inputTitleName" maxlength="64" value="{{old('title')}}" placeholder="Enter Title">
										@error('title')
										<span class="invalid-feedback err" role="alert">{{$message}}</span>
										@enderror
									</div>
									<div class="form-group inputProviderSec">
										   <label for="inputProviderName">{{ __('Provider') }} <span class="required">*</span></label>
											<input type="text" name="provider" class="form-control" id="inputProviderName" maxlength="64" value="{{old('provider')}}" placeholder="Enter Provider">
										   @error('journey_name')
										   <span class="invalid-feedback err" role="alert">{{$message}}</span>
										   @enderror
									</div>									
									<div class="form-group ">
									   <label for="inputDifficultyName">{{ __('Difficulty') }} <span class="required">*</span></label>
										<select name="difficulty" id="inputDifficultyName" class="select2 form-control" "{{old('difficulty')}}" > 
											<option value="">Choose Difficulty</option>
											<option value="beginner">Beginner</option>
											<option value="intermediate">Intermediate</option>
											<option value="advanced">Advanced</option>
										</select>   
									   @error('difficulty')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
									<div class="form-group">
									   <label for="inputVisibilityName">{{ __('Visibility') }} <span class="required">*</span></label>
										<select name="visibility" id="inputVisibilityName" class="select2 form-control " "{{old('visibility')}}" >
											<option value="">Choose Visibility</option>
											<option value="private">Private</option>
											<option value="public">Public</option>
										</select>   
									   @error('visibility')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>									
									<div class="form-group">
									   <label for="inputPaymentTypeName">{{ __('Free or Paid') }} <span class="required">*</span></label>
										<select name="payment_type" id="inputPaymentTypeName" class="select2 form-control" "{{old('payment_type')}}" >
											<option value="">Choose Paid or Free</option>
											<option value="free">Free</option>
											<option value="paid">Paid</option>
										</select>   
										@error('payment_type')
										<span class="invalid-feedback err" role="alert">{{$message}}</span>
										@enderror
									</div>
									<div class="form-group inputLengthSec">
									   <label for="inputLengthName">{{ __('Length') }} <span class="required">*</span></label>
										<input type="text" name="length" class="form-control" maxlength="2048" id="inputLengthName" value="{{old('length')}}" placeholder="Enter length">  
										@error('length')
										<span class="invalid-feedback err" role="alert">{{$message}}</span>
										@enderror
									</div>									
									<div class="form-group viewShowSec d-none">
									   <label for="inputApproverStatus">{{ __('Approval Status') }}</label>
										<select id="inputApproverStatus" class="select2 form-control">
											<option value="">Choose Approver Status</option>
											<option value="pending" >Pending</option>
											<option value="approved" >Approved</option>
											<option value="rejected" >Rejected</option>
										</select>   
									   @error('approverstatus')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>	
									<div class="form-group viewShowSec d-none">
									   <label for="inputReadName">{{ __('Compulsory or Optional') }}</label>
										<select name="read" id="inputReadName" class="form-control select2">
											<option value="">Compulsory or Optional</option>
											<option value="optional" >Optional</option>
											<option value="compulsory" >Compulsory</option>
										</select>
									</div>
									<div class="form-group inputTags">
									   <label for="inputTagsName">{{ __('Tags') }}</label>
										<select name="tags[]" multiple class=" form-control tagsInput" id="inputTagsName"></select> 
									   @error('tags')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
									<div class="form-group viewShowSec">
										<label for="inputRating">{{ __('Rating') }} <span class="required">*</span></label>
										<input type="text" class="form-control" id="inputRating">
									</div>									
								</div>
								<div class="milstoneGrid col-md-8 pl-4 pr-2">
									<div class="row m-0">									
										<div class="form-group inputURLSec col-md-6 p-0 pr-4">
											<label for="inputURLName">{{ __('URL') }} <span class="required">*</span> </label>
											<input type="text" name="url" class="form-control" maxlength="2048" id="inputURLName" value="{{old('url')}}" placeholder="Enter URL">
											@error('url')
											<span class="invalid-feedback err" role="alert">{{$message}}</span>
											@enderror
										</div>
										<div class="form-group col-md-6 p-0 p1-4">
										   <label for="inputName">{{ __('Milestone Type') }} </label>
											<select name="content_type_id" id="content_type_id" disabled class=" form-control" "{{old('content_type_id')}}" >
												<option value="">Select option</option>
												@foreach($content_types as $type)
												<option value="{{ $type->id }}">{{$type->name}}</option>
												@endforeach
											</select>  
											@error('content_type_id')
											<span class="invalid-feedback err" role="alert">{{$message}}</span>
											@enderror
										</div>
									</div>
									<div class="form-group">
									   <label for="inputDescriptionName">{{ __('Description') }}</label>
										<textarea id="inputDescriptionName" name="description" maxlength="1024" placeholder="Enter Description" class="form-control">{{old('description', "")}}</textarea>   
									   @error('description')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
									<div class="row m-0">
										<div class="form-group col-md-6 p-0 pr-4">
										   <label for="start_date">{{ __('Start Date') }}</label>
										<input type="text" name="start_date" class="form-control datepicker" id="start_date"  placeholder="Pick Start Date ">
										   @error('start_date')
										   <span class="invalid-feedback err" role="alert">{{$message}}</span>
										   @enderror
										</div>
										<div class="form-group col-md-6 p-0 pl-4">
										   <label for="inputName">{{ __('Targeted Completion Date') }} <span class="required">*</span></label>
										<input type="text" name="end_date" class="form-control datepicker" id="end_date"  placeholder="Pick Targeted Completion Date">
										   @error('end_date')
										   <span class="invalid-feedback err" role="alert">{{$message}}</span>
										   @enderror
										</div>
									</div>
									<div class="row m-0">
										<div class="form-group paymentTypeSec d-none col-md-6 p-0 pr-4">
											<label for="inputPriceName">{{ __('Price') }} <span class="required">*</span></label>
											<input type="text" name="price" class="form-control priceField" id="inputPriceName" maxlength="7" value="" placeholder="Enter Price">
											@error('price')
											<span class="invalid-feedback err" role="alert">{{$message}}</span>
											@enderror
										</div>
										<div class="form-group paymentTypeSec d-none col-md-6 p-0 pl-4">
										   <label for="inputApproverName">{{ __('Approver') }} <span class="required">*</span></label>
											<select name="approver_id" id="inputApproverName" class="select2 form-control">
												<option value="">Choose Approver</option>
												@foreach($approvers as $approver)
												@if($approver->id == user_id())
													<option value="{{$approver->id}}">{{ __('lang.my_self') }}</option>
												@else	
													<option value="{{$approver->id}}">{{$approver->first_name}} {{$approver->last_name}}</option>
												@endif
												@endforeach
											</select>   
										   @error('approver')
										   <span class="invalid-feedback err" role="alert">{{$message}}</span>
										   @enderror
										</div>
									</div>									
									<div class="row m-0">
										<div class="form-group viewShowSec d-none col-md-6 p-0 pr-4">
											<label for="inputDaysLeft">{{ __('Days Left for Completion') }}</label>
											<input type="text" name="daysleft" class="form-control" id="inputDaysLeft" maxlength="7" value="" placeholder="Enter Days Left for Completion">
											@error('daysleft')
											<span class="invalid-feedback err" role="alert">{{$message}}</span>
											@enderror
										</div>
										<div class="form-group viewShowSec d-none col-md-6 p-0 pl-4">
											<label for="inputPriceName">{{ __('Assigned by') }}</label>
											<input type="text" name="assignedby" class="form-control" id="inputAssignedBy" placeholder="Enter Assigned by">
											@error('assignedby')
											<span class="invalid-feedback err" role="alert">{{$message}}</span>
											@enderror
										</div>
									</div>									
									<div class="form-group milestoneNoteSec "> 
									   <label for="inputNoteName">{{ __('Notes') }} <span data-toggle="tooltip" data-placement="right" data-html="true" title="What are your major takeaways from this Milestone? How will it impact your work?" ><i class="icon-info"></i> </span></label>
										<textarea id="inputNoteName" name="notes" placeholder="Enter Notes" class="form-control">{{old('notes', "")}}</textarea>   
									   @error('notes')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>									
									<div class="form-group viewShowSec d-none">
									   <label for="inputApprovalCommentName">{{ __('Approval Comments') }} </label>
										<textarea id="inputApprovalCommentName" name="comments" class="form-control"></textarea>   
									   @error('notes')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="btn-footer pb-5">
					<button type="reset" class="btn-grey btn milestoneCancelBtn" data-dismiss="modal">Cancel</button>
					<button type="submit" id="milestoneSaveBtn" class="btn-green btn " id="importehrsub">Save</button>
					<button type="button" id="markAsCompleteBtn" class="btn-blue btn ">Mark as Complete</button>
				</div>
			</div>
		</div>
		{{ Form::close() }}-->
	</div>
</div>

<!-- Milestone type selection modal -->
<div id="milstoneContentTypeAdd" class="modal modal600 fade" role="dialog"  data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered ">
		<!-- Modal content-->
		<div class="modal-content text-left">
			<div class="modal-header">
				<button type="reset" class="btn-close" title="Close" data-dismiss="modal">x</button>
				<h2>Milestone Type</h2>
			</div>
			<div class="modal-body">
				<div class="form-all-input">
					<label>Select Milestone Type <span class="required">*</span></label>
					<div class="row">
						@foreach($content_types as $type)
						<div class="col-md-3 {{$type->name}} form-group milestone_types p-0 pt-2 pb-2">
						   <label for="{{$type->name}}" >
						   <input type="radio" name="content_type" id="{{$type->name}}" class="milestoneContentType form-control" value="{{ $type->id}}" >
						   <i class="{{$type->name}}"></i>
						   <span>{{$type->name}}</span></label>
						</div>
						@endforeach
					</div>
				</div>			
				<div class="btn-footer">
					<button type="reset" class="btn-grey btn" data-dismiss="modal">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Milestone Rating selection modal -->
<div id="milstoneRatingAdd" class="modal modal600 fade" role="dialog"  data-backdrop="static" data-keyboard="false"> 
	<div class="modal-dialog modal-dialog-centered">
		<!-- Modal content-->
		<div class="modal-content text-left">
			<div class="modal-header">
				<button type="reset" class="btn-close" title="Close" data-dismiss="modal">x</button>
				<h2>Rating</h2>
			</div>
			<div class="modal-body">
				<form class="ajax-form" method="POST" action="{{route('journeys.complete_milestone')}}" id="ratingForm"> 
					<div class="ratingFormGroup text-center mb-3">
						<h2 class="bold rating-header" style=""></h2>
						<input type="hidden" id="ratingMilestoneId" name="milestone_id" />
						<input type="hidden" class="ratings" id="ratingID" name="rating"  /> 
						<div class="rating_star">	
							<button type="button" class="btnrating btn btn-default btn-lg" data-attr="1" id="rating-star-1"><i class="icon-star"></i></button>
							<button type="button" class="btnrating btn btn-default btn-lg" data-attr="2" id="rating-star-2"><i class="icon-star"></i></button>
							<button type="button" class="btnrating btn btn-default btn-lg" data-attr="3" id="rating-star-3"><i class="icon-star"></i></button>
							<button type="button" class="btnrating btn btn-default btn-lg" data-attr="4" id="rating-star-4"><i class="icon-star"></i></button>
							<button type="button" class="btnrating btn btn-default btn-lg" data-attr="5" id="rating-star-5"><i class="icon-star"></i></button>
						</div>
					</div>
					<div class="btn-footer">
						<button type="submit" class="btn-green btn" >Submit</button>
					</div>
				</form>	
			</div>
		</div>
	</div>
</div>
