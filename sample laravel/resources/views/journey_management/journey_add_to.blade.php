<div class="modal modal-danger fade show" style="display: block;" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-dialog-centered">
		  <div class="modal-content">
			<div class="modal-header">	
				<h2>Add to My Learning Journey</h2>
			</div>
			<div class="modal-body">
				<form method="POST" class="ajax-form" id="journeyAssignForm" action="{{route('journeys.store_assign')}}" role="form" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="journey_id" value="{{ Request::route('id') }}">

					<div class="row">
						@foreach($journey->milestones as $milestone)
						<div class="row">
							<input type="hidden" name="milestone_id[]" value="{{$milestone->id}}">
							<div class="form-group">
								<label for="inputTitleName">{{ __('Milestone Title') }}</label>
								<input disabled type="text" class="form-control" id="inputTitleName" value="{{$milestone->content->title}}">
							</div>
							<div class="form-group">
							   <label for="inputName">{{ __('Milestone Type') }}</label>
								<select disabled class="form-control" "{{old('content_type_id')}}" >
									<option value="">Select option</option>
									@foreach($content_types as $type)
									<option {{ $type->id == $milestone->content->content_type_id ? 'selected' : '' }} value="{{ $type->id }}">{{$type->name}}</option>
									@endforeach
								</select>  
							</div>
							<div class="form-group">
								<label for="inputDateName">{{ __('Targeted Completion Date') }}</label>
								<input type="date" name="target_date[]" class="form-control" id="inputDateName" value="{{old('target_date')}}">
							</div>
							<div class="form-group">
							   <label for="inputName">{{ __('Visibility') }}</label>
								<select name="visibility[]" class="form-control" "{{old('visibility')}}" >
									<option value="">Select option</option>
									<option {{ $milestone->visibility == "private" ? 'selected' : '' }} value="private">Private</option>
									<option {{ $milestone->visibility == "public" ? 'selected' : '' }} value="public">Public</option>
								</select>   
							   @error('visibility')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							<div class="form-group">
							   <label for="inputName">{{ __('Compulsory or Optional') }}</label>
								<select name="read[]" class="form-control">
									<option value="">Select option</option>
									<option {{ $milestone->read == "optional" ? 'selected' : '' }} value="optional">Optional</option>
									<option {{ $milestone->read == "compulsory" ? 'selected' : '' }} value="compulsory">Compulsory</option>
								</select>   
							   @error('visibility')
							   <span class="invalid-feedback err" role="alert">{{$message}}</span>
							   @enderror
							</div>
							<div class="form-group">
							   <label for="inputName">{{ __('Process Type') }}</label>
							   <input disabled type="text" class="form-control" id="inputvisibilityName" value="{{ ucfirst($milestone->payment_type)}}">
							</div>
							@if($milestone->payment_type != "free")
							<div class="form-group">
							   <label for="inputName">{{ __('Approver') }}</label>
								<select name="approver_id[{{$milestone->id}}]" class="form-control" "{{old('payment_type')}}" >
									<option value="">Select option</option>
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
							@endif
						</div>
						@endforeach
					</div>
			</form>
		  </div>
		  <!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</div>

		


