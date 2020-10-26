<div class="comn_dataTable">
	<div class="title_nd_btn">
		<div class="top_left">
			<h3>Milestones List</h3>
		</div>
		<div class="top_right top_right_btn">
		</div>
	</div>
<!-- general form elements -->
	<div class="box box-primary">
		<div class="table-responsive">
			@if($journey_type_id != 5)
			<table width="100%" id="passportMilestoneList" class="table milestoneAddedTable">
			  <thead>
			  <tr>
				<th>Milestone Name</th>
				<th>Milestone Type</th>
				<th>Difficulty</th>
				<th class="text-center">Points Earned</th>
				<th class="text-center">Rating</th>
				<th>Action</th>
			  </tr>
			  </thead>
			</table>
			@else
			<table width="100%" id="backfillMilestoneList" class="table milestoneAddedTable">
			  <thead>
			  <tr>
				<th>Milestone Title</th>
				<th>Milestone Type</th>
				<th>Milestone Difficulty</th>
				<th>Start Date</th>
				<th>Completion Date</th>
				<th>Action</th>
			  </tr>
			  </thead>
			</table>
			@endif
		</div>
	</div>
</div>

<!-- Milestone add modal -->
<div id="milstoneAdd" class="modal modelBig fade" role="dialog"  data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered" id="loadPassportMilstoneAddModal">
	</div>
</div>

<!-- Milestone type selection modal -->
<div id="milstoneContentTypeAdd" class="modal modal600 fade" role="dialog"  data-backdrop="static">
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
<div id="milstoneRatingAdd" class="modal modal600 fade" role="dialog"  data-backdrop="static"> 
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
