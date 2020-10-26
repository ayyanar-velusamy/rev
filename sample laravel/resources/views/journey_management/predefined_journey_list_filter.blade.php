<div class="row m-0">
	<div class="form-group journeyName col-md-2 p-0">
		<select class="form-control filterByJourneyId select2">
			<option value="" >Learning Journey Name</option>
			@if($journeys)
				@foreach($journeys as $journey)
					@if($journey->journey_type_id == 2)
					<option value="{{ $journey->journey_name }}" > {{ $journey->journey_name }}</option>
					@endif
				@endforeach
			@endif											
		</select>
	</div>
	<div class="form-group milestoneCount col-md-2 p-0 pl-2">
		<select class="filterByMilestoneCount form-control select2">
			<option value="">Milestone Count</option>
			@if($pre_milestone_counts)}
				@foreach($pre_milestone_counts as $milestone_count)
					<option value="{{ $milestone_count->milestone_count }}" > {{ $milestone_count->milestone_count }} </option>									@endforeach
			@endif												
		</select>
	</div>
	<div class="form-group createdBy col-md-2 p-0 pl-2">
		<select class="filterByCreatedBy form-control select2">
			<option value="">Created By</option>
			@if($created_by)}
				@foreach($created_by as $created)
					@if($created->journey_type_id == 2)
					@if($created->created_by == user_id())
						@php($created->created_name = "Me")
					@endif
					<option value="{{ $created->created_by }}" > {{ $created->created_name }}</option>
					@endif
				@endforeach
			@endif	
		</select>
	</div>
	<div class="form-group createdDate date-rangePicker col-md-2 p-0 pl-2">
		<input type="text" class="filterByCreatedDate form-control daterangepicker" name="created_date" placeholder="Created Date" />
	</div>
	<div class="form-group totalAssignees col-md-2 p-0 pl-2">
		<select class="filterByTotalAssignee form-control select2">
			<option value="">Total No.of Assignees</option>
			@if($total_assignees)
				@foreach($total_assignees as $total)
					<option value="{{ $total }}" > {{ $total }}</option>
				@endforeach
			@endif	
		</select>
	</div>
	<div class="form-group totalActiveAssignees col-md-2 p-0 pl-2">
		<select class="filterByActiveAssignee form-control select2">
			<option value="">Total No.of Active Assignees</option>
			@if($active_assignees)
				@foreach($active_assignees as $total)
					<option value="{{ $total }}" > {{ $total }}</option>
				@endforeach
			@endif		
		</select>
	</div>
</div>

<script>
$( function() {
	
	//Remove milestone count dropdown duplicates	
	removeDuplicateOption('#predefinedlearning .filterByJourneyId');
	removeDuplicateOption('#predefinedlearning .filterByMilestoneCount');
	
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
