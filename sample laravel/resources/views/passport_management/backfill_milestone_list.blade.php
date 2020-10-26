<div class="comn_dataTable">
	<div class="title_nd_btn">
		<div class="top_left">
			<h3>Milestones List</h3>
		</div>
		<div class="top_right top_right_btn">
		  @if(!str_contains(Request::url(), 'show') && @(GetActionMethodName() != 'show'))
			  <a id="addMilestoneModalBtn" href="" tabindex="0" title="{{ __('Add Milestone')}}"data-toggle="modal" onclick="addMilestone('{{encode_url($backfill->id)}}')"  class="new-user btn btn-green pull-right"><i class="icon-plus"></i> {{ __('Add Milestone')}}</a> 
		  @endif
		</div>
	</div>
<!-- general form elements -->
	<div class="box box-primary">
		<div class="table-responsive">
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
		</div>
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
						   <input type="radio" name="content_type" id="{{$type->name}}" class="backfillMilestoneContentType form-control" value="{{ $type->id}}" >
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
<!-- Milestone add modal -->
<div id="milstoneAdd" class="modal modelBig fade" role="dialog"  data-backdrop="static">
	<div class="modal-dialog modal-dialog-centered" id="loadPassportMilstoneAddModal">
		
	</div>
</div>
