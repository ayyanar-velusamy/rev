<div class="row m-0">
	<div class="form-group journeyName col-md-2 p-0 pr-2">
		<select class="form-control filterByJourneyId select2">
			<option value="">Learning Journey Name</option>
			@if($journeys)
				@foreach($journeys as $journey)
					@if($journey->journey_type_id == 3 && $journey->assigned_by == user_id())
					<option value="{{ $journey->journey_name }}" > {{ $journey->journey_name }}</option>
					@endif
				@endforeach
			@endif											
		</select>
	</div>
	<div class="form-group assignedDate date-rangePicker col-md-2 p-0 pr-2">
		<input type="text" class="filterByCreatedDate form-control daterangepicker" name="created_date" placeholder="Assigned Date" />
	</div>	
	
	<div class="form-group filterByGroup col-md-2 p-0 pr-2">
		<select class="filterByGroupId form-control select2">
			<option value="">Group</option>
			@if($assigned_group_list)
				@foreach($assigned_group_list as $group)
					<option value="{{ $group->id }}" > {{ $group->group_name }}</option>
				@endforeach
			@endif	
		</select>
	</div>
	
	<div class="form-group assignedType col-md-2 p-0 pr-2">
		<select class="filterByAssignedType form-control select2">
			<option value="">Assignment Type</option>
			<option value="predefined" >Predefined</option>
			<option value="library" >Library</option>
		</select>
	</div>
									
	<div class="form-group assignedBy col-md-2 p-0 pr-2">
		<select class="filterByAssignedBy form-control select2">
			<option value="">Assigned By</option>
			@if($assigned_by)}
				@foreach($assigned_by as $assigned)
					@if($assigned->assigned_by == user_id())
						@if($assigned->assigned_by == user_id())
							@php($assigned->assigned_name = "Me")
						@endif
						<option value="{{ $assigned->assigned_by }}" > {{ $assigned->assigned_name }}</option>
					@endif
				@endforeach
			@endif		
		</select>
	</div>
	<div class="form-group requestFor assignedTo col-md-2 p-0 pr-2">
		<select class="filterByAssignedTo form-control select2">
			<option value="">Assigned To</option>
			@if($assigned_to)}
				@foreach($assigned_to as $key=>$as_to)
					<optgroup label="{{ucfirst(str_plural($key))}}">
						@foreach($as_to as $to)
						@if($to->type =='user' && $to->type_ref_id == user_id())
							@php($to->name = "Me")
						@endif
						<option value="{{ $to->select_id }}" > {{ $to->name }}</option>
						@endforeach
					</optgroup>
				@endforeach
			@endif
		</select>
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
	removeDuplicateOption('#assignedlearning .filterByJourneyId');
	removeDuplicateOption('#assignedlearning .filterByAssignedBy ');
	
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


