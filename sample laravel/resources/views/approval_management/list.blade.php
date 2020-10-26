@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb"> 
			<li class="active"><a>Approval Management List</a></li>
		</ul>
		<div class="top_search_box">
			<form>
				<input id="dataTableSearch" type="input" name="serching" placeholder="Search" />
			</form>	
		</div>
	</div>
	<div class="page-content approvals_list"> 
		<div class="clearfix">
			<div class="top_left_form">
				<div class="row m-0">
					<div class="form-group journeyName col-md-2 p-0">
						<select class="form-control filterByJourneyId select2">
							<option value="">Learning Journey Name</option>
							@if($journeys)
								@foreach($journeys as $journey)
									<option value="{{ $journey->journey_name }}" > {{ $journey->journey_name }}</option>
								@endforeach
							@endif											
						</select>
					</div>						
					<div class="form-group milestoneType col-md-2 p-0 pl-2">
						<select class="form-control filterByMilestoneType select2">
							<option value="">Milestone Type</option>
							@if($content_types)
								@foreach($content_types as $type)
								<option value="{{ $type->id }}">{{$type->name}}</option>
								@endforeach
							@endif											
						</select>
					</div>
					<div class="form-group milestoneTitle col-md-2 p-0 pl-2">
						<select class="form-control filterByMilestoneId select2">
							<option value="">Milestone Name</option>
							@if($milestones)
								@foreach($milestones as $milestone)
								<option value="{{ $milestone->id }}">{{$milestone->title}}</option>
								@endforeach
							@endif											
						</select>
					</div>
					<div class="form-group requestDate date-rangePicker col-md-2 p-0 pl-2">
						<input type="text" class="filterByRequestDate form-control daterangepicker" name="created_date" placeholder="Requested Date" />
					</div>				
					<div class="form-group requestFor col-md-2 p-0 pl-2">
						<select class="filterByRequestFor form-control select2">
							<option value="">Requested For</option> 
							@if($requested_for)
								@foreach($requested_for as $key=>$req_for)
									 <optgroup label="{{ucfirst(str_plural($key))}}">
									@foreach($req_for as $req)
									@if($req->type_ref_id == user_id() && $key == 'user')
										@php($req->name = "Me")
									@endif
									<option value="{{ $req->select_id }}" > {{ $req->name }}</option>
									@endforeach
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-group requestBy col-md-2 p-0 pl-2">
						<select class="filterByRequestBy form-control select2">
							<option value="">Requested By</option>
							@if($requested_by)}
								@foreach($requested_by as $req)
									<option value="{{ $req->user_id }}" > {{ ($req->user_id != user_id()) ? $req->first_name." ".$req->last_name : "Me"}}</option>
								@endforeach
							@endif	
						</select>
					</div>
					<div class="form-group status col-md-2 p-0 pl-2">
						<select class="filterByStatusOption form-control select2">
							<option value="">Status</option>
							<option value="pending" >Pending</option>
							<option value="approved" >Approved</option>
							<option value="rejected" >Rejected</option>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="comn_dataTable">	
			<div class="table-responsive">	
				<table id="approvalList" class="table table-hover" style="width:100%;"> 
					<thead> 
						<tr>
							<th class="journey_name text-center">Learning Journey Name</th>
							<th class="milestone_type">Milestone <span>Type</span></th>
							<th>Milestone Name</th>
							<th>Requested Date</th>
							<th>Requested for</th>
							<th>Requested By</th>
							<th>Status</th>
							<th>Price</th>
							<th class="actions">Action</th>
							<!--<th class="actions"></th>-->
						</tr>
					</thead>
				</table>
			</div>
		</div>
		<div class="modal modal600 modal-danger fade" id="approval-modal">
				<div class="modal-dialog modal-dialog-centered">
				  <div class="modal-content">
					<div class="modal-header">	
						<h2 id="approval-modal-title"></h2>
						<button type="reset" class="btn-close" title="Close" data-dismiss="modal">x</button>
					</div>
					<div class="modal-body">
						<h4>Are you sure <span id="approval-modal-content"></span><span id="approval-modal-name"></span></h4>
						<form class="ajax-form" method="POST" action="{{url('/')}}" novalidate id="approval-form" > 
						@csrf
							<input type="hidden" name="status" id="approvalStauts">
							<input type="hidden" name="name" id="approvalMilestoneName">
							<div class="form-group comments mt-3 mb-4">
								<label for="inputCommentName">{{ __('Comments') }} <span class="required">*</span></label>
								<textarea type="text" name="comment" maxlength="40" class="form-control" id="inputCommentName" placeholder="Enter comment"></textarea>
							</div>
							<div class="btn-footer">
							  <button type="button" id="approvalNo" class="btn btn-grey" data-dismiss="modal">No</button>
							  <button type="submit" id="approvalYes" class="btn btn-green">Yes</button>
							</div>
						</form>
				  </div>
				  <!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
		</div>
		<!-- Milestone add modal -->
		<div id="milstoneRequestedView" class="modal modelBig fade" role="dialog"  data-backdrop="static">
			<div class="modal-dialog modal-dialog-centered">
				<!-- Modal content-->
				<div class="modal-content text-left">
					<div class="modal-header">
						<button type="reset" class="btn-close" title="Close" data-dismiss="modal">x</button>
						<h2 id="milstoneAddTitle">View Milestone</h2>
					</div>
					<div class="modal-body">
						<div class="white-box">	
							<div class="white-content">
								<h3>{{ __('Milestone Details') }}</h3>
								<div class="inner-content form-all-input">
									<div class="row">
										<div class="approve milstoneGrid col-md-4 pl-2 pr-4">
											<div class="form-group">
											   <label for="inputName">{{ __('Milestone Type') }} </label>
												<select name="content_type_id" id="content_type_id" disabled class="form-control" "{{old('content_type_id')}}" >
													<option value="">Select option</option>
													@foreach($content_types as $type)
													<option value="{{ $type->id }}">{{$type->name}}</option>
													@endforeach
												</select>
											</div>
											<!--<div class="form-group">
												<label for="inputTitleName">{{ __('Title') }}</label>
												<input type="text" name="title" class="form-control" id="inputTitleName">
											</div>-->											
											<div class="form-group inputProviderSec">
													<label for="inputProviderName">{{ __('Provider') }}</label>
													<input type="text" name="provider" class="form-control" id="inputProviderName">
											</div>
											<div class="form-group inputTags">
												<label for="inputPriceName">{{ __('Price') }}</label>
												<input type="text" name="price" class="form-control priceField" id="inputPriceName">
											</div>
											<div class="form-group">
											   <label for="inputCommentDes">{{ __('Comments') }}</label>
												<textarea id="inputCommentDes" name="comment" class="form-control">					
												</textarea>
											</div>
										</div>
										<div class=" approve milstoneGrid col-md-8 pl-4 pr-2">
											<div class="row m-0">
												<div class="form-group col-md-6 p-0 pr-4">
													<label for="inputURLName">{{ __('URL') }}</label>
													<input type="text" name="url" class="form-control" id="inputURLName">
												</div>
												<div class="form-group col-md-6 p-0 pl-4">
												<label for="inputVisibilityName">{{ __('Visibility') }}</label>					   
												   <input type="text" name="visibility" class="form-control" id="inputVisibilityName"> 
												</div>
											</div>
											<div class="row m-0">
												<div class="form-group col-md-6 p-0 pr-4">
												   <label for="inputDifficultyName">{{ __('Difficulty') }}</label>
												   <input type="text" name="difficulty" class="form-control" id="inputDifficultyName">
												</div>
												<div class="form-group col-md-6 p-0 pl-4">
												   <label for="inputReadName">{{ __('Compulsory or Optional') }}</label>
												   <input type="text" name="read" class="form-control" id="inputReadName">
												</div>										
												
											</div>
											<div class="row m-0">
												<div class="form-group inputTags col-md-6 p-0 pr-4">
													<label for="inputTagsName">{{ __('Tags') }}</label>
													<select name="tags" multiple class=" form-control tagsInput" id="inputTagsName"></select>
												</div>
												<div class="form-group col-md-6 p-0 pl-4">
												   <label for="inputStatusName">{{ __('Status') }}</label>
												   <input type="text" name="status" class="form-control" id="inputStatusName">
												</div>
											</div>
											<div class="form-group">
											   <label for="inputDescriptionName">{{ __('Description') }}</label>
												<textarea id="inputDescriptionName" name="description" class="form-control">					
												</textarea>
											</div>											
										</div>
									</div>
								</div>
							</div>
							<div class="white-content pt-0">
								<h3>{{ __('Request Details') }}</h3>
								<div class="inner-content form-all-input">
									<div class="row m-0">
										<div class="approve milstoneGrid col-md-4 pl-2 pr-4">
											<div class="form-group">
											   <label for="inputJourneyName">{{ __('Learning Journey Name') }}</label>
												<input type="text" class="form-control" id="inputJourneyName">
											</div>
											<div class="form-group">
											   <label for="inputRequestedForName">{{ __('Requested For') }}</label>
												<input type="text" class="form-control" id="inputRequestedForName">
											</div>
										</div>
										<div class=" approve milstoneGrid col-md-8 pl-4 pr-2">
											<div class="row m-0">
												<div class="form-group col-md-6 p-0 pr-4">
													<label for="inputRequestedByName">{{ __('Requested By') }}</label>
													<input type="text" class="form-control" id="inputRequestedByName">
												</div>
												<div class="form-group col-md-6  p-0 pl-4">
													<label for="inputRequestedDateName">{{ __('Requested Date') }}</label>
													<input type="text" class="form-control" id="inputRequestedDateName">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="btn-footer pb-5">
							<button type="button" class="btn-green btn" data-dismiss="modal">Back</button>
							<a href="#" id="redirectToViewBtn" class="btn btn-blue"></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
