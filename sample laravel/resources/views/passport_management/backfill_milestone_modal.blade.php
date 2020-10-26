@php($action = $post_data['action'])
@php($journey_id = (!empty($data)) ? $data->journey_id : $post_data['journey_id'])
@php($milestone_id = (!empty($data)) ? encode_url($data->id) : '')
@php($required = ($action != 'view') ? '*' : '')
@php($disabled = ($action == 'view') ? 'disabled' : '')

@if($action == 'edit')
	{!! Form::open([ 'route' => ['update_backfill_milestone',$milestone_id], 'enctype' => 'multipart/form-data', 'class' => 'ajax-form clearfix', 'id'=>'backfillMilestoneModalForm' ]) !!}
@else
	{!! Form::open([ 'route' => 'store_backfill_milestone', 'enctype' => 'multipart/form-data', 'class' => 'ajax-form clearfix', 'id'=>'backfillMilestoneModalForm' ]) !!}	
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
						<div class="milstoneGrid col-md-4 pl-2 pr-4">
							<div class="form-group inputTitleSec">
								<label for="inputTitleName">{{ __('Milestone Name ') }} <span class="required">*</span></label>
								@php($title = (!empty($data)) ? $data->title : '')
								<input {{$disabled}} type="text" name="title" class="form-control" id="inputTitleName" maxlength="64" value="{{old('title',$title)}}" placeholder="Enter Milestone Name ">
								@error('title')
								<span class="invalid-feedback err" role="alert">{{$message}}</span>
								@enderror
							</div>									
							<div class="form-group">
								<label for="start_date">{{ __('Start Date') }}</label>
								@php($start_date = (!empty($data)) ? get_date($data->start_date) : get_date())
								<input {{$disabled}} type="text" name="start_date" class="form-control datepicker" id="start_date" value="{{old('start_date',$start_date)}}" placeholder="Pick Start Date ">
								   @error('start_date')
								   <span class="invalid-feedback err" role="alert">{{$message}}</span>
								   @enderror
							</div>
							<div class="form-group">
								   <label for="inputName">{{ __('Completion Date') }} <span class="required">*</span></label>
								   @php($end_date = (!empty($data)) ? get_date($data->end_date) : '')
								<input {{$disabled}} type="text" name="end_date" class="form-control datepicker" id="end_date" value="{{old('end_date',$end_date)}}" placeholder="Pick Completion Date">
								   @error('end_date')
								   <span class="invalid-feedback err" role="alert">{{$message}}</span>
								   @enderror
							</div>
							<div class="form-group inputTags ">
							   <label for="inputTagsName1">{{ __('Tags') }}</label>
								@php($tags = (!empty($data)) ? $data->tags : '')
								<select {{$disabled}} name="tags[]" class=" form-control BacktagsInput" id="inputTagsName" multiple="multiple">
								@if($tags != "")
								@foreach(explode(',',$tags) as $tag)
								<option selected value="{{$tag}}">{{$tag}}</option>
								@endforeach
								@endif
								</select>
							   @error('tags') 
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>									
						</div>
						<div class="milstoneGrid col-md-8 pl-4 pr-2">
							<div class="row m-0">									
								<div class="form-group milestoneType col-md-6 p-0 pr-4">
									<label for="inputName">{{ __('Milestone Type') }} </label>
									<select name="content_type_id" id="backfill_content_type_id" disabled class=" form-control" "{{old('content_type_id')}}" >
										<option value="">Select option</option>
										@foreach($content_types as $type)
										<option {{ ($content_type_id == $type->id) ? 'selected' : ''}} value="{{ $type->id }}">{{$type->name}}</option>
										@endforeach
									</select>  
									@error('content_type_id')
									<span class="invalid-feedback err" role="alert">{{$message}}</span>
									@enderror
								</div>
								<div class="form-group col-md-6 p-0 p1-4">
									<label for="inputDifficultyName">{{ __('Difficulty') }} <span class="required">*</span></label>
									@php($difficulty = (!empty($data)) ? $data->difficulty : '')
									<select {{$disabled}} name="difficulty" id="inputDifficultyName" class="select2 form-control" "{{old('difficulty')}}" > 
										<option value="">Choose Difficulty</option>
										<option {{ ($difficulty == 'beginner') ? 'selected' : ''}} value="beginner">Beginner</option>
										<option {{ ($difficulty == 'intermediate') ? 'selected' : ''}} value="intermediate">Intermediate</option>
										<option {{ ($difficulty == 'advanced') ? 'selected' : ''}} value="advanced">Advanced</option>
									</select>  
								   @error('difficulty')
								   <span class="invalid-feedback err" role="alert">{{$message}}</span>
								   @enderror
								</div>
							</div>
							<div class="form-group">
							   <label for="inputDescriptionName">{{ __('Description ') }}</label>
								@php($description = (!empty($data)) ? $data->description : '')
								<textarea {{$disabled}} id="inputDescriptionName" name="description" maxlength="1024" placeholder="Enter Milestone Description " class="form-control">{{old('description', $description)}}</textarea>   
							   @error('description')
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
			@if($action != 'view')
			<button type="submit" id="milestoneSaveBtn" class="btn-green btn " id="importehrsub">Save</button>
			@endif
		</div>
	</div>
</div>
{{ Form::close() }}

<script>
$(document).ready(function() {
	if($('.select2').length > 0){
		$('.select2').select2({ minimumResultsForSearch: -1});
	}
	
	$("#inputTagsName").select2({ 
		tags: true,
		multiple: true,
		placeholder: "Enter Tags",
		tokenSeparators: [',', ' '],
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

if($('#milstoneAdd .milstoneGrid .select2.form-control').length > 0){
	$('#milstoneAdd .milstoneGrid .select2.form-control').on('change', function(evt){
		$(this).valid();
	});
}
</script>