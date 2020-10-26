<div class="row m-0">
	<div class="form-group journeyName col-md-2 p-0">
		<select class="form-control filterByJourneyId select2">
			<option value="">Learning Journey Name</option>
			@if($journeys)
				@foreach($journeys as $journey)
					@if(($journey->journey_type_id == 1 && $journey->user_id == user_id()) || ($journey->journey_type_id == 3 &&  $journey->assigned_status != 'revoked' && $journey->user_id == user_id()))
					<option value="{{ $journey->journey_name }}" > {{ $journey->journey_name }}</option>
					@endif
				@endforeach
			@endif											
		</select>
	</div>
	<div class="form-group milestoneCount col-md-2 p-0 pl-2"> 
		<select class="filterByMilestoneCount form-control select2">
			<option value="">Milestone Count</option>
			@if($milestone_counts)}
				@foreach($milestone_counts as $milestone_count)
					@if($milestone_count->user_id == user_id() && $milestone_count->assigned_status != 'revoked')
					<option value="{{ $milestone_count->milestone_count }}" > {{ $milestone_count->milestone_count }} </option>
					@endif
				@endforeach
			@endif												
		</select>
	</div>
	<div class="form-group assignedBy col-md-2 p-0 pl-2 pr-2">
		<select class="filterByAssignedBy form-control select2">
			<option value="">Assigned By</option>
			@if($assigned_by)}
				@foreach($assigned_by as $assigned)
					@if($assigned->user_id == user_id() && $assigned->assigned_status != 'revoked')
						@if($assigned->assigned_by == user_id())
							@php($assigned->assigned_name = "Me")
						@endif
						<option value="{{ $assigned->assigned_by }}" > {{ $assigned->assigned_name }}</option>
					@endif
				@endforeach
			@endif	
		</select>
	</div>
	<div class="form-group createdDate date-rangePicker col-md-2 p-0 pr-2">
		<input type="text" class="filterByCreatedDate form-control daterangepicker" name="created_date" placeholder="Created Date" />
	</div>
	<div class="form-group completedDate date-rangePicker col-md-2 p-0 pr-2">
		<input type="text" class="filterByCompletedDate form-control daterangepicker" name="completed_date" placeholder="Completed Date" /> 
	</div>
	<div class="form-group compulsory col-md-2 p-0">
		<select class="filterByReadOption form-control select2">
			<option value="">Compulsory or Optional</option>
			<option value="optional" >Optional</option>
			<option value="compulsory" >Compulsory</option>
		</select>
	</div>
</div>

<script>
$( function() {
	
	//Remove milestone count dropdown duplicates
	removeDuplicateOption('#mylearning .filterByJourneyId');
	removeDuplicateOption('#mylearning .filterByMilestoneCount');
	
	$(".daterangepicker").each(function(){
		var placeholder = $(this).attr('placeholder'); 

		 $(this).daterangepicker({
			 datepickerOptions : {
				 //changeMonth: true,
				// changeYear: true,
				 numberOfMonths : 2,
				 dateFormat: 'M d, yy',
				 maxDate: null
			 },
			 initialText : placeholder,
			 presetRanges: [], 
		 });
	});
});
</script>
