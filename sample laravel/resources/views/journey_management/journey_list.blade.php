@extends('layouts.app')
@section('content')

<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb journey"> 
			<li class="active"><a>My Learning Journey List</a></li> 
		</ul>
		<div class="top_search_box">
			<form>
				<input id="dataTableSearch" type="input" name="serching" placeholder="Search" />
			</form>	
		</div>
	</div>
	<div class="page-content journey_list">
			  <!-- general form elements -->
			<div class="box box-primary">
				<ul class="nav nav-tabs" id="joureyTab">
					<li class="nav-item">
					  <a class="nav-link active" onclick="journeyMainTapChange('my_journey')" data-toggle="tab" href="#mylearning" data-tabName="My Learning Journey List" >My Learning Journey</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" onclick="journeyMainTapChange('predefined_journey')" data-toggle="tab" href="#predefinedlearning" data-tabName="Predefined Learning Journey List">Predefined Learning Journey</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" onclick="journeyMainTapChange('assigned_journey')" data-toggle="tab" href="#assignedlearning " data-tabName="Assigned Learning Journey List"> Assigned Learning Journey</a>
					</li>
				  </ul>
				<div class="tab-content">
					<div id="mylearning" class="tab-pane active"><br>
						<div class="comn_dataTable learning_journey">
							<div id="my_journey" class="top_left_form">
								<!--<div class="row m-0">
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
								</div>-->
							</div>
							<div class="top_right_btn">
							  @can('add_journeys')
							  <a title="{{ __('Add Journey')}}" href="{{route('journeys.create')}}" class="new-user btn btn-green pull-right"><i class="icon-plus"></i> {{ __('Add Journey')}}</a> 
							  @endcan
							</div>
							<div class="table-responsive">
								<table id="myLearningJourneyList" class="table table-hover" style="width:100%">
								  <thead>
								  <tr>
									<th>Learning <span>Journey Name</span> </th>
									<th>Milestone <span>Count</span></th>
									<th class="assigned_by">Assigned By</th>
									<th>Created Date</th>
									<th>Tar.Completion <span>Date</span></th>
									<!--<th>Visibility</th>-->
									<th>Compulsory or <span>Optional</span></th>
									<th class="text-center">Progress</th>
									<th>Tags</th>
									<th>Action</th>
								  </tr>
								  </thead>
								</table>
							</div>
						</div>
					</div>
					<div id="predefinedlearning" class="tab-pane fade"><br>
					<div class="comn_dataTable pdj_list">
							<div id="predefined_journey" class="top_left_form">
								<!--<div class="row m-0">
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
								</div>-->
							</div>
							<div class="top_right_btn">
							  @can('add_journeys')
							  <a title="{{ __('Add Journey')}}" href="{{route('journeys.create')}}" class="new-user btn btn-green pull-right"><i class="icon-plus"></i> {{ __('Add Journey')}}</a> 
							  @endcan
							</div>
							<div class="table-responsive">
								<table id="predefinedLearningJourneyList" class="table table-hover" style="width:100%">
								  <thead>
								  <tr>
									<th>Learning <span>Journey Name</span> </th>
									<th>Milestone <span>Count</span></th>
									<th class="created_by">Created By</th>
									<th class="created_date">Created Date</th>
									<!--<th>visibility</th>-->
									<th>Total Number of<span>Assignees</span></th>
									<th>Total Number of<span>Active Assignees</span></th>
									<th>Tags</th>
									<th>Action</th>
									<th></th>
								  </tr>
								  </thead>
								</table>
							</div>
						</div>
					</div>
					
					<div id="assignedlearning" class="tab-pane fade"><br>
						<div class="comn_dataTable">
						<div id="assigned_journey" class="top_left_form">
								<!--<div class="row m-0">
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
								</div>-->
							</div>
							<div class="table-responsive">
								<table id="assignedLearningJourneyList" class="table table-hover"  style="width:100%">
								  <thead>
								  <tr>
									<th class="text-center">Learning <span>Journey Name</span> </th>
									<th>Assigned Date</th>
									<th>Assignment Type</th>
									<th class="assigned_by">Assigned By</th>
									<th>Assigned To</th>
									<th>Compulsory <span>or Optional</span></th>
									<th class="text-center">Progress</th>
									<th>Tags</th>
									<th>Action</th>
								  </tr>
								  </thead>
									
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="loadAddMyLearningJourneyModal"></div>	
		</div>
	</div>
</div>
@endsection