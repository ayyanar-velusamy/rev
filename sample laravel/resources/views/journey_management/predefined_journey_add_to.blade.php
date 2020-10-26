<div class="modal modal1085 modal-danger fade" id="addMyLearningJourneyModal" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg modal-dialog-centered">
		  <div class="modal-content">
			<div class="modal-header">	
				<h2>Add to My Learning Journey</h2>
				<button type="reset" class="btn-close" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body p-0 pb-4">
				<form method="POST" class="ajax-form" id="addToMyLearningjourneyAssignForm" action="{{route('journeys.store_add_to')}}" role="form" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="journey_id" value="{{ Request::route('id') }}">
				<input type="hidden" name="assignment_type" value="add_to">
				<div class="white-box">	
					<div class="white-content">
						<div class="inner-content form-all-input">
							<div class="row mlr-2">
								<div class="col-md-4 plr-2">
									<div class="form-group">
										<label for="inputJourneyName">{{ __('Journey Name') }} </label>
										<input readonly name="journey_name" type="text" class="form-control" id="inputTitleName" value="{{$journey->journey_name}}">
										@error('journey_name')
										<span class="invalid-feedback err" role="alert">{{$message}}</span>
										@enderror
									</div>
								</div>
								<div class="col-md-4 plr-2">
									<div class="form-group">
										<label for="inputJourneyVisibility">{{ __('Journey Visibility') }} <span class="required">*</span></label>
										<select id="inputJourneyVisibility" name="j_visibility" class="form-control select2" >
											<option value="">Select Visibility</option>
											<option value="private">Private</option>
											<option value="public">Public</option>
										</select>   
										@error('visibility')
										<span class="invalid-feedback err" role="alert">{{$message}}</span>
										@enderror
									</div>
								</div>
								<div class="col-md-4 plr-2">
									<!-- <div class="form-group">
										<label for="inputJourneyName">{{ __('Journey Name') }} <span class="required">*</span></label>
										<Select name="journey_name" class="form-control select2" id="inputJourneyName">
										</select>
										@error('journey_name')
										<span class="invalid-feedback err" role="alert">{{$message}}</span>
										@enderror
									</div> -->
								</div>
							</div>
						</div>	
					</div>	
					<div class="white-content" >
						<h3>Milestone List</h3>
						<div class="inner-content form-all-input " id="mileStoneScroll">
						@foreach($journey->milestones as $key=>$milestone) 
						<input type="hidden" name="milestone_id[]" value="{{$milestone->id}}">
						<input name="payment_type[{{$milestone->id}}]" type="hidden" value="{{ $milestone->payment_type}}">
						<div class="row mn-15">
							<div class="form-group col-md-3">
								<div class="milestone_info">
									<div class="form-group ">
										<label for="inputPaymentTypeName_{{$milestone->id}}"><span class="label_lft">{{ __('Milestone Title') }} :</span>  <span class="maxname label_rgt">{{$milestone->title}}</span></label>
										<label for="inputPaymentTypeName_{{$milestone->id}}"><span class="label_lft">{{ __('Milestone Type') }} :</span>  <span class="label_rgt">{{ucfirst($milestone->milestone_type_name())}}</span></label>
										<label for="inputPaymentTypeName_{{$milestone->id}}"><span class="label_lft">{{ __('Free or Paid') }} :</span>  <span class="label_rgt">{{ ucfirst($milestone->payment_type)}} </span></label>
										@if($milestone->payment_type == 'paid')
										<label for="inputPriceName_{{$milestone->id}}"><span class="label_lft">{{ __('Price') }} :</span>  <span class="label_rgt">${{ $milestone->price }} </span></label>
										@endif
									</div> 
								</div>
							</div>
						<!--<div class="form-group col-md-3">
								<label for="inputTitleName_{{$milestone->id}}">{{ __('Milestone Title') }} </label>
								<p><span class="maxname">{{$milestone->title}}</span></p>
								<input disabled type="text" class="form-control" id="inputTitleName_{{$milestone->id}}" value="{{$milestone->title}}">
							</div>
							<div class="form-group col-md-3">
							   <label for="inputName">{{ __('Milestone Type') }} <span class="required">*</span></label>
								<select disabled class="form-control select2" "{{old('content_type_id')}}" >
									<option value="">Select option</option>
									@foreach($content_types as $type)
									<option {{ $type->id == $milestone->content_type_id ? 'selected' : '' }} value="{{ $type->id }}">{{$type->name}} </option>

									@endforeach
								</select>  
							</div>-->
							<div class="form-group col-md-3">
								<label for="inputDateName{{$milestone->id}}">{{ __('Targeted Completion Date') }} <span class="required">*</span></label>
								<input type="text" name="target_date[{{$milestone->id}}]" class="form-control datepicker" placeholder="Pick Targeted Completion Date" id="inputDateName{{$milestone->id}}" value="{{get_date(date('Y-m-d', strtotime('+'.(($key+1)*6).' days', strtotime(get_db_date()))))}}">
							</div>
							<div class="form-group col-md-3">
							   <label for="inputMilestoneVisibility{{$milestone->id}}">{{ __('Visibility') }} <span class="required">*</span></label>
								<select name="visibility[{{$milestone->id}}]" id="inputMilestoneVisibility{{$milestone->id}}" class="form-control select2" "{{old('visibility')}}" >
									<option value="">Select option</option>
									<option {{ $milestone->visibility == "private" ? 'selected' : '' }} value="private">Private</option>
									<option {{ $milestone->visibility == "public" ? 'selected' : '' }} value="public">Public</option>
								</select>   
							   @error('visibility')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							<div class="form-group col-md-3 d-none">
							   <label for="inputName">{{ __('Compulsory or Optional') }} <span class="required">*</span></label>
								<select name="read[{{$milestone->id}}]" class="form-control select2">
									<option value="">Select option</option>
									<option {{ $milestone->read == "optional" ? 'selected' : '' }} value="optional">Optional</option>
									<option {{ $milestone->read == "compulsory" ? 'selected' : '' }} value="compulsory">Compulsory</option>
								</select>   
							   @error('visibility')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							<!--<div class="form-group col-md-3">
							   <label for="inputPaymentTypeName_{{$milestone->id}}">{{ __('Free or Paid') }} <span class="required">*</span></label>
							   <input type="text" name="payment_type[{{$milestone->id}}]"  class="form-control" id="inputPaymentTypeName_{{$milestone->id}}" readonly value="{{ ucfirst($milestone->payment_type)}}">
							</div>-->
							@if($milestone->payment_type != "free")
							<div class="form-group col-md-3 d-none">
							   <label for="inputPrice_{{$milestone->id}}">{{ __('Price') }} <span class="required">*</span></label>
							   <input type="text" name="price[{{$milestone->id}}]" class="form-control priceField" id="inputPrice_{{$milestone->id}}" value="{{ $milestone->price}}">
							</div>	
							<div class="form-group col-md-3 pr-4">
							   <label for="inputApprover{{$milestone->id}}">{{ __('Approver') }} <span class="required">*</span></label>
								<select name="approver_id[{{$milestone->id}}]" id="inputApprover{{$milestone->id}}" class="form-control select2">
									<option value="">Select option</option>
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
				<div class="btn-footer">
				  <button type="reset" class="btn btn-grey" data-dismiss="modal">Cancel</button>
				  <button type="submit" id="addMyLearningJourneySubmit" class="btn btn-green modal-submit-yes">Add</button>
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


 $("#addMyLearningJourneySubmit").click(function(){
    $("[id^=inputDateName]").each(function(){
        $(this).rules("add", {
            required: true,
			//greaterThan: "#start_date",
            messages: {
               required:"Targeted Completion Date cannot be empty",
			 //  greaterThan: "Target date should not be less than the start date"
            }
        } );            
    });
	$("[id^=inputMilestoneVisibility]").each(function(){
        $(this).rules("add", {
            required: true,
            messages: {
                required: "Visibility of the milestone cannot be empty"
            }
        } );            
    });
	$("[id^=inputApprover]").each(function(){
        $(this).rules("add", {
            required: true,
            messages: {
                required:"Approver cannot be empty",
            }
        } );            
    });

 });



$("#addToMyLearningjourneyAssignForm").validate({ 
	rules: {
		j_visibility: {
			required: true, 
		},
	},
	messages: {
		j_visibility: {
			required:"Visibility of the Journey cannot be empty",
		},
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



if($('#addToMyLearningjourneyAssignForm .form-group select, #addToMyLearningjourneyAssignForm .form-group .datepicker').length > 0){
	$('#addToMyLearningjourneyAssignForm .form-group select, #addToMyLearningjourneyAssignForm .form-group .datepicker').on('change', function(evt){
		$(this).valid();
	});
}
if($("#addMyLearningJourneyModal #mileStoneScroll").length > 0){
	$("#addMyLearningJourneyModal #mileStoneScroll").mCustomScrollbar({ 
		theme:"minimal",
		axis:"y", 
		scrollbarPosition: "outside",
		scrollButtons:{ enable: false }, 
		contentTouchScroll: 20,
		mouseWheel:{ enable: true } ,
		advanced:{
			autoExpandHorizontalScroll:false,
			updateOnContentResize:true,
		},

	});
} 
</script>

