@extends('layouts.app')
@section('content')

<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb journey"> 
			<li class="active"><a>Reports</a></li> 
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
				<ul class="nav nav-tabs" id="reportTab">
					<li class="nav-item">
					  <a class="nav-link active" onclick="reportMainTapChange('userActivity')" data-toggle="tab" href="#userActivity">User Activity</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" onclick="reportMainTapChange('journeyReport')" data-toggle="tab" href="#journeyReport">Journey Report</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" onclick="reportMainTapChange('tempcheckReport')" data-toggle="tab" href="#tempcheckReport">Tempcheck</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" onclick="reportMainTapChange('currentUserReport')" data-toggle="tab" href="#currentUserReport">Current User List</a>
					</li>					
					<li class="nav-item">
					  <a class="nav-link" onclick="reportMainTapChange('groupReport')" data-toggle="tab" href="#groupReport">Groups</a>
					</li>
					<li class="nav-item">
					  <a class="nav-link" onclick="reportMainTapChange('approvalReport')" data-toggle="tab" href="#approvalReport">Approvals</a>
					</li>
				  </ul>
				<div class="tab-content">
					<div id="userActivity" class="tab-pane active"><br>
						<div class="comn_dataTable learning_journey">
							<div class="row m-0">
								<div class="top_left_form col-md-9 pr-0">
									<div class="row">
										<div class="form-group firstName col-md-3 p-0 pr-2">
											<select class="form-control filterByFirstName select2">
												<option value="">First Name</option>
												@if($user_filter)
													@foreach($user_filter as $user)
													<option value="{{$user->first_name}}">{{$user->first_name}}</option>
													@endforeach
												@endif
											</select>
										</div>
										<div class="form-group lastName col-md-2 p-0 pr-2">
											<select class="filterByLastName form-control select2">
												<option value="">Last Name</option>
												@if($user_filter)
													@foreach($user_filter as $user)
													<option value="{{$user->last_name}}">{{$user->last_name}}</option>
													@endforeach
												@endif
											</select>
										</div>
										<div class="form-group lastLoginDate date-rangePicker col-md-2 p-0 pl-2">
											<input type="text" class="filterByLastLoginDate form-control daterangepicker" name="last_lagin_date" placeholder="Last Login" />
										</div>
										<div class="form-group pointEarned col-md-2 p-0  pr-2">
											<select class="filterByPoint form-control select2">
												<option value="">Points Earned</option>
												<option value="0">0</option>
												@if($point_filter)
													@foreach($point_filter as $point)
													@if($point->points_earned != "")
													<option value="{{$point->points_earned}}">{{$point->points_earned}}</option>
													@endif
													@endforeach
												@endif
											</select>
										</div>
										<div class="form-group totalMilestoneCompleted col-md-2 p-0 pr-2">
											<select class="filterByMilestoneCompletedCount form-control select2">
												<option value="">Milestones Completed</option>
												<option value="0">0</option>
												@if($point_filter)
													@foreach($point_filter as $point)
													@if($point->points_earned != "")
													<option value="{{$point->completed_milestone_count}}">{{$point->completed_milestone_count}}</option>
													@endif
													@endforeach
												@endif
											</select>
										</div>
										<div class="form-group totalJourneys col-md-2 p-0 pr-2">
											<select class="filterByTotalJourneyCount form-control select2">
												<option value="">Total Journeys</option>
												<option value="0">0</option>
												@if($journey_count_filter)
													@foreach($journey_count_filter as $journey)
													@if($journey->total_journey_count != "")
													<option value="{{$journey->total_journey_count}}">{{$journey->total_journey_count}}</option>
													@endif
													@endforeach
												@endif
											</select>
										</div>
										<div class="form-group completedJourneys col-md-2 p-0 pr-2">
											<select class="filterByJourneyCompletedCount form-control select2">
												<option value="">Journeys Completed</option>
												@if($journey_count_filter)
													@foreach($journey_count_filter as $journey)
													@if($journey->completed_journey_count != "")
													<option value="{{$journey->completed_journey_count}}">{{$journey->completed_journey_count}}</option>
													@endif
													@endforeach
												@endif
											</select>
										</div>
									</div>
								</div>
							</div>
							<div class="table-responsive">
								<table id="userActivityList" class="table table-hover" style="width:100%">
								  <thead>
								  <tr>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Last Login</th>
									<th class="text-center">Points Earned</th>
									<th class="text-center">Milestones Completed</th>
									<th class="text-center">Total  Journeys</th>
									<th class="text-center">Journeys Completed</th>
								  </tr>
								  </thead>
								</table>
							</div>
						</div>
					</div>
					<div id="journeyReport" class="tab-pane fade"><br>
						<div class="comn_dataTable pdj_list">
							<div class="table-responsive">
								<table id="journeyReportList" class="table table-hover" style="width:100%">
								  <thead>
								  <tr>
									<th>Learning <span>Journey Name</span> </th>
									<th>Tags</th>
									<th>Action</th>
								  </tr>
								  </thead>
								</table>
							</div>
						</div>
					</div>					
					<div id="tempcheckReport" class="tab-pane fade"><br>
						<div class="comn_dataTable">
							<div class="top_fileter tempcheckAssigned">
								<div class="top_left_form  ">
									<div class="row m-0">
										<div class="form-group AssignedBy col-md-2 pr-1 pl-0 ">
											<select class="form-control filterAssignedBy select2">
												<option value="">Assigned By</option>@if($tempcheck_assigned_filter)
													@foreach($tempcheck_assigned_filter as $assigned)
															<option value="{{$assigned->user_id}}">{{$assigned->first_name}} {{$assigned->last_name}}</option>
													@endforeach
												@endif									
											</select>
										</div>
										<div class="form-group freQuency col-md-2 p-0">
											<select class="form-control filterByAssignee select2">
											<option value="">Assignee</option>		
											@if($tempcheck_assignee_filter)
												@foreach($tempcheck_assignee_filter as $assignee)
														<option value="{{$assignee->user_id}}">{{$assignee->first_name}} {{$assignee->last_name}}</option>
												@endforeach
											@endif				
											</select>
										</div>
										<div class="form-group freQuency col-md-2 p-0">
											<select class="form-control filterByRating select2">
											<option value="">Rating</option>		
											@if($temp_rating_filter)
												@foreach($temp_rating_filter as $rating)
													<option value="{{$rating->rating}}">{{round($rating->rating,2)}}</option>
												@endforeach
											@endif				
											</select>
										</div>
										<div class="form-group freQuency col-md-2 p-0">
										<select class="form-control filterByQuestion select2">
										<option value="">Question</option>		
										@if($temp_question_filter)
											@foreach($temp_question_filter as $question)
												<option value="{{$question->question}}">{{$question->question}}</option>
											@endforeach
										@endif				
										</select>
										</div>									
									</div>									
								</div>
							</div>
							<div class="table-responsive">
								<table id="tempcheckReportList" class="table table-hover"  style="width:100%">
								  <thead>
								  <tr>
									<th>Assigned by</th>
									<th>Rated by</th>
									<th>Rating</th>
									<th>Question</th>
								  </tr>
								  </thead>									
								</table>
							</div>
						</div>
					</div>
					<div id="currentUserReport" class="tab-pane fade"><br>
							<div class="row m-0">
								<div class="top_left_form col-md-11 pr-0">
									<div class="row">
										<div class="form-group firstName col-md-2 p-0 pr-2">
											<select class="form-control filterByFirstName select2">
												<option value="">First Name</option>
												@if($user_filter)
													@foreach($user_filter as $user)
													<option value="{{$user->first_name}}">{{$user->first_name}}</option>
													@endforeach
												@endif
											</select>
										</div>
										<div class="form-group lastName col-md-2 p-0 pr-2">
											<select class="filterByLastName form-control select2">
												<option value="">Last Name</option>
												@if($user_filter)
													@foreach($user_filter as $user)
													<option value="{{$user->last_name}}">{{$user->last_name}}</option>
													@endforeach
												@endif
											</select>
										</div>
										<div class="form-group phoneNumber col-md-2 p-0 pr-2">
											<select class="filterByPhoneNumber form-control select2">
												<option value="">Phone Number</option>
												@if($user_filter)
													@foreach($user_filter as $user)
														@if($user->mobile != "")
															<option value="{{$user->mobile}}">{{$user->mobile}}</option>
														@endif
													@endforeach
												@endif
											</select>
										</div>
										<div class="form-group emailId col-md-2 p-0 pr-2">
											<select class="filterByEmailId form-control select2">
												<option value="">Email ID</option>
												@if($user_filter)
													@foreach($user_filter as $user)
														@if($user->email != "")
															<option value="{{$user->email}}">{{$user->email}}</option>
														@endif
													@endforeach
												@endif
											</select>
										</div>
										<div class="form-group Role col-md-2 p-0 pr-2">
											<select class="filterByRole form-control select2">
												<option value="">Role</option>
												@if($role_filter)
													@foreach($role_filter as $role)
														@if($role->name != "")
															<option value="{{$role->name}}">{{$role->name}}</option>
														@endif
													@endforeach
												@endif
											</select>
										</div>
										<div class="form-group userGrade col-md-2 p-0 pr-2">
											<select class="filterByUserGrade form-control select2">
												<option value="">Grade</option>
												@if($grade_filter)
													@foreach($grade_filter as $grade)
														@if($grade->node_name != "")
															<option value="{{$grade->id}}">{{$grade->node_name}}</option>
														@endif
													@endforeach
												@endif
											</select>
										</div>									
										<div class="form-group designation col-md-2 p-0 pr-2">
											<select class="filterByDesignation form-control select2">
												<option value="">Designation</option>
												@if($user_filter)
													@foreach($user_filter as $user)
														@if($user->designation != "")
															<option value="{{$user->designation}}">{{$user->designation}}</option>
														@endif
													@endforeach
												@endif
											</select>
										</div>
									</div>
								</div>
							</div>
						<div class="comn_dataTable">
							<div class="table-responsive">
								<table id="currentUserReportList" class="table table-hover"  style="width:100%">
								  <thead>
								  <tr>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Phone Number</th>
									<th>Email</th>
									<th>Designation</th>
									<th>Role</</th>
									<th>Grade</th>
								  </tr>
								  </thead>
									
								</table>
							</div>
						</div>
					</div>
					<div id="groupReport" class="tab-pane fade"><br>
						<div class="comn_dataTable">
							<div class="top_left_form">
								<div class="row m-0">
									<div class="form-group groupName col-md-2 p-0">
										<select class="form-control filterByGroupId select2">
											<option value="">Group Name</option>
											@if($groups)
												@foreach($groups as $id => $group)
													<option value="{{ $group->id }}" > 
													{{ $group->group_name }}</option>
												@endforeach
											@endif										
										</select>
									</div>
									<div class="form-group memberCount col-md-2 p-0 pl-2">
										<select class="filterByMemberCount form-control select2">
											<option value="">Total Members</option>
											@if($group_member_count)
												@foreach($group_member_count as $m_count)
													<option value="{{ $m_count }}" > 
													{{ $m_count }}</option>
												@endforeach
											@endif											
										</select>
									</div>
									<div class="form-group adminCount col-md-2 p-0 pl-2">
										<select class="filterByAdminCount form-control select2">
											<option value="">Total Admin</option>
											@if($group_admin_count)
												@foreach($group_admin_count as $a_count)
													<option value="{{ $a_count }}" > 
													{{ $a_count }}</option>
												@endforeach
											@endif							
										</select>
									</div>
									<div class="form-group createdBy col-md-2 p-0 pl-2 ">
										<select class="filterByCreatedBy form-control select2">
											<option value="">Created By</option>
											@if($group_created_by)
												@foreach($group_created_by as $created)
													<option value="{{ $created->user_id }}" > 
													{{ $created->created_name }}</option>
												@endforeach
											@endif
										</select>
									</div>
									<div class="form-group createdDate date-rangePicker col-md-2 p-0 pl-2">
										<input type="text" class="filterByCreatedDate form-control daterangepicker" name="created_date" placeholder="Created Date" />
									</div>									
									<div class="form-group journeyCount col-md-2 p-0 pl-2">
										<select class="filterByJourneyCount form-control select2">
											<option value="">No. of Journeys</option>
											<option value="0" >0</option>
											@if($group_journey_count)
												@foreach($group_journey_count as $j_count)
													<option value="{{ $j_count }}" > 
													{{ $j_count }}</option>
												@endforeach
											@endif												
										</select>
									</div>
									<div class="form-group milestoneCount col-md-2 p-0 pl-2">
										<select class="filterByMilestoneCount form-control select2">
											<option value="">No. of Milestones</option>
											<option value="0" >0</option>
											@if($group_milestone_count)
												@foreach($group_milestone_count as $m_count)
													<option value="{{ $m_count }}" > 
													{{ $m_count }}</option>
												@endforeach
											@endif	
										</select>
									</div>
								</div>
							</div>
							<div class="top_right_btn">
							  @can('add_groups')
							  <a title="{{ __('Add Group')}}" href="{{route('groups.create')}}" class="new-user btn btn-green pull-right"><i class="icon-plus"></i> {{ __('Add Group')}}</a> 
							  @endcan
							</div>
							<div class="table-responsive">
								<table id="groupReportList" class="table table-hover"  style="width:100%">
								  <thead>
								  <tr>
									<th class="group_name">Group Name</th>
									<th>Total Members</th>
									<th>Total Admin</th>
									<th>Created By</th>
									<th>Created Date</th>
									<th class="total_leaning_joutney">Number of <span>Learning Journeys</span></th>
									<th class="total_leaning_joutney">Number of <span>Milestones</span></th>
								  </tr>
								  </thead>
									
								</table>
							</div>
						</div>
					</div>
					<div id="approvalReport" class="tab-pane fade"><br>
						<div class="comn_dataTable">
							<div class="clearfix">
								<div class="top_left_form">
									<div class="row m-0">
										<div class="form-group approverName col-md-2 p-0 pl-2">
											<select class="filterByApproverName form-control select2">
												<option value="">Approver Name</option>
												@if($approval_approvers)}
													@foreach($approval_approvers as $approver)
														<option value="{{ $approver->user_id }}" > {{ $approver->first_name." ".$approver->last_name }}</option>
													@endforeach
												@endif	
											</select>
										</div>
										<div class="form-group journeyName col-md-2 p-0">
											<select class="form-control filterByJourneyId select2">
												<option value="">Learning Journey Name</option>
												@if($approval_journeys)
													@foreach($approval_journeys as $journey)
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
												@if($approval_milestones)
													@foreach($approval_milestones as $milestone)
													<option value="{{ $milestone->title }}">{{$milestone->title}}</option>
													@endforeach
												@endif											
											</select>
										</div>			
										<div class="form-group requestFor col-md-2 p-0 pl-2">
											<select class="filterByRequestFor form-control select2">
												<option value="">Requested For</option> 
												@if($approval_requested_for)
													@foreach($approval_requested_for as $key=>$req_for)
														 <optgroup label="{{ucfirst(str_plural($key))}}">
														@foreach($req_for as $req)
														<option value="{{ $req->select_id }}" > {{ $req->name }}</option>
														@endforeach
													@endforeach
												@endif
											</select>
										</div>
										<div class="form-group requestBy col-md-2 p-0 pl-2">
											<select class="filterByRequestBy form-control select2">
												<option value="">Requested By</option>
												@if($approval_requested_by)}
													@foreach($approval_requested_by as $req)
														<option value="{{ $req->user_id }}" > {{ $req->first_name." ".$req->last_name }}</option>
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
										<!--<div class="form-group milestonePrice col-md-2 p-0 pl-2">
											<select class="form-control filterByPrice select2">
												<option value="">Price</option>
												@if($approval_by_price)
													@foreach($approval_by_price as $price)
													<option value="{{ $price->price }}">{{$price->price}}</option>
													@endforeach
												@endif											
											</select>
										</div>-->
									</div>
								</div>
							</div>
							<div class="table-responsive">
								<table id="approvalReportList" class="table table-hover"  style="width:100%">
								  <thead>
								  <tr>
									<th class="approver_name text-center">Approver Name</th>
									<th class="journey_name text-center">Learning Journey Name</th>
									<th>Milestone Name</th>
									<th class="milestone_type">Milestone <span>Type</span></th>
									<th>Requested for</th>
									<th>Requested By</th>
									<th>Price</th>
									<th>Status</th>
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