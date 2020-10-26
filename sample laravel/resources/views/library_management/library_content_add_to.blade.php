<div class="modal modal1116 modal-danger fade" data-backdrop="static" id="addAddContentModal"> 
		<div class="modal-dialog modal-lg modal-dialog-centered">
		  <div class="modal-content">
			<div class="modal-header">	
				<h2>Add to My Journey</h2>
				<button type="reset" class="btn-close" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">
				<form method="POST" class="ajax-form" id="addToMyLearningjourneyMilestoneForm" action="{{route('libraries.store_add_to')}}" role="form" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="content_id" value="{{ Request::route('id') }}">
					<div class="white-box">
						<div class="white-content p-0">
							<div class="inner-content form-all-input p-0">
								<div class="row">
									<!--<input type="hidden" name="content_id" value="{{$content->id}}">
									<div class="form-group">
										<label for="inputTitleName">{{ __('Content Title') }} <span class="required">*</span></label>
										<input disabled type="text" class="form-control" id="inputTitleName" value="{{$content->title}}">
									</div>-->
									<div class="form-group arrow_black col-md-4 px-4">
								   <label for="inputName">{{ __('Journey') }} <span class="required">*</span></label>
									<select name="journey_id" class="form-control select2" "{{old('journey_id')}}" >
										<option value="">Select Journey</option>
										@foreach($journey as $key=>$val)
										<option value="{{ $key }}">{{$val}}</option>
										@endforeach
									</select>   
									   @error('journey_type_id')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
								  </div>
									<!--<div class="form-group arrow_black col-md-4 px-4">
									   <label for="inputName">{{ __('Content Typ ase') }} <span class="required">*</span></label>
										<select disabled class="form-control select2" "{{old('content_type_id')}}" >
											<option value="">Select option</option>
											@foreach($content_types as $type)
											<option {{ $type->id == $content->content_type_id ? 'selected' : '' }} value="{{ $type->id }}">{{$type->name}}</option>
											@endforeach
										</select>  
									</div>-->
									<div class="form-group form-group col-md-4 px-4">
										<label for="inputStartDateName">{{ __('Start Date') }} <span class="required">*</span></label>
										<input type="text" name="start_date" class="form-control datepicker" id="inputStartDateName" value="{{old('target_date')}}" placeholder="Choose Start Date">
									</div>
									<div class="form-group form-group col-md-4 px-4">
										<label for="inputDateName">{{ __('Targeted Completion Date') }} <span class="required">*</span></label>
										<input type="text" name="target_date" class="form-control datepicker" id="inputDateName" value="{{old('target_date')}}" placeholder="Choose Targeted Completion Date">
									</div>
									<div class="form-group arrow_black col-md-4 px-4">
									   <label for="inputName">{{ __('Visibility') }} <span class="required">*</span></label>
										<select name="visibility" class="form-control select2" "{{old('visibility')}}" >
											<option value="">Select Visibility</option>
											<option {{ $content->visibility == "private" ? 'selected' : '' }} value="private">Private</option>
											<option {{ $content->visibility == "public" ? 'selected' : '' }} value="public">Public</option>
										</select>   
									   @error('visibility')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>
								<!--<<div class="form-group arrow_black col-md-4 px-4">
									   <label for="inputName">{{ __('Compulsory or Optional') }} <span class="required">*</span></label>
										<select name="read" class="form-control select2">
											<option value="">Select option</option>
											<option {{ $content->read == "optional" ? 'selected' : '' }} value="optional">Optional</option>
											<option {{ $content->read == "compulsory" ? 'selected' : '' }} value="compulsory">Compulsory</option>
										</select>   
									   @error('visibility')
									   <span class="invalid-feedback err" role="alert">{{$message}}</span>
									   @enderror
									</div>-->
									<div class="form-group  col-md-4 px-4">
									   <label for="inputName">{{ __('Free or Paid') }} <span class="required">*</span></label>
									   <input readonly name="payment_type" type="text" class="form-control" id="inputvisibilityName" value="{{ ucfirst($content->payment_type)}}">
									</div>
									@if($content->payment_type != "free")
									<div class="form-group arrow_black  col-md-4 px-4">
									   <label for="inputName">{{ __('Approver') }} </label>
										<select name="approver_id" class="form-control select2" "{{old('payment_type')}}" >
											<option value="">Select Approver</option>
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
					<div class="btn-footer mt-4">
					  <button type="button" class="btn btn-grey" data-dismiss="modal">Cancel</button>
					  <button type="submit" class="btn btn-green modal-submit-yes">Save</button>
					</div>
			</form>
			
		  </div>
		  <!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</div>

<script>
$(document).ready(function() {
	if($('.select2').length > 0){
		$('.select2').select2({ minimumResultsForSearch: -1});
	}
});	
$( function() {
  $(".datepicker").datepicker({
	   dateFormat: 'M d, yy',
	   minDate: new Date()
  });
});
</script>		


