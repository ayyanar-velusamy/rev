@extends('layouts.app')
@section('content')

<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li><a href="{{route('peers.index')}}">{{ __('Peers') }}</a></li>
			<li class="active"><a href="javascript:">View Passport</a></li>
		</ul>
	</div>
	<div class="page-content peer">
		<div class="white-box">	
			<div class="white-box-head">	
				<h2>Profile Details</h2>
			</div>
			<div class="white-content">
				<h3>Personal Information</h3>
				<div class="inner-content form-all-input">
					<div class="row">
						<div class="col-md-4">
							<div class="account-bg ">
								<div class="add-user text-center">
										@if($user->image != "")
											<img width=150 height=150 src="{{asset('storage/user-uploads/avatar/'.$user->image) }}" class="img-circle" alt="User Image">
										@else
											<img width=150 height=150 src="{{asset('images/user_profile.png') }}" class="img-circle" alt="User Image">
										@endif
								</div>
							</div>
						</div>
						 <div class="col-md-8 pad-zero">
							<div class="row">
								<div class="col-md-6 left-pad pdr-45">
									<div class="form-group">
										<label for="inputFirstName">{{ __('First Name') }} </label>
										<input name="first_name" disabled class="form-control" maxlength="40" type="text" value="{{$user->first_name}}" placeholder="Enter First Name"  />
									</div>
								</div>
								<div class="col-md-6 right-pad pdl-45">
									<div class="form-group">
										<label for="inputLastName">{{ __('Last Name') }}</label>
										<input name="last_name" disabled class="form-control" maxlength="40" type="text"  value="{{$user->last_name}}" placeholder="Enter Last Name" />
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 left-pad pdr-45">
									<div class="form-group">
										<label for="inputDesignation">{{ __('Designation') }}</label>
										<input type="text" disabled name="designation" class="form-control" value="{{$user->designation}}" maxlength="64" id="designation"  placeholder="Enter Designation " />
									</div>
								</div>
								<div class="col-md-6 right-pad pdl-45">
									<div class="form-group">
										<label for="inputEmail">{{ __('Email address') }}</label>
										<input name="email" value="{{$user->email}}" disabled class="form-control" maxlength="64" type="email" placeholder="Enter Email Address"  />
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
			@if(count($user_grade) > 0)
			<div class="white-content"> 
				<h3>User Grade</h3>
				<div class="inner-content form-all-input">
					<div class="row" id="renderGrade">
						<?php $i = 0;?>
						@foreach($org_data as $data)
							@foreach($data->orgchart as $row)
							@if(@ $user_grade[$i]->chart_value_id == $row->node_id)
							<div class="form-group col-sm-4 select-unit">
								<label class="label_data_{{$data->set_id}}" data-text="{{ $data->set_name }}" for="unit">{{ $data->set_name }}</label>
								<select disabled name="gradeId[{{$data->set_id}}]" class="form-control select_level level_id_{{$data->set_id}}" data-set-id="{{ $data->set_id}}">
									<option value="">Select {{$data->set_name}}</option>
									<option selected value="{{ $row->node_id }}" data-node_id ="{{$row->node_id}}" data-node_parent="{{$row->node_parent}}">{{$row->node_name}}</option>
										
								</select>
							</div>
							@endif						
							@endforeach
							<?php $i++; ?>
						@endforeach
					</div>
				</div>
			</div>
			@endif
			<div class="white-content"> 
				<div class="inner-content form-all-input ">
					<div class="row green-box">
						<div class="col-md-4 green-box-grid text-center"> 	
							<div class="inner-text">
								<p>Total Points of all <span>journeys and milestones</span></p>
								<h4 id="total_points">0</h4>
							</div>
						</div>
						<div class="col-md-4 green-box-grid text-center">
							<div class="inner-text">
								<p>Totals for each type of <span>milestone in the all Journeys </span></p>
								<h4 id="total_milestone_count">0</h4>
							</div>
						</div>
						<div class="col-md-4 green-box-grid text-center">
							<div class="inner-text">
								<p>Totals of each type of <span>milestone completed in all journeys</span> </p>
								<h4 id="completed_milestone_count">0</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
				<div class="white-content"> 
				<h3>Total Points for Individual Type of Milestones</h3>
				<div class="inner-content form-all-input">
					<div class="green-box-big">
						<div class="inner-text">
							<div class="milestoneType-box">
								<div class="milestoneTypGrid">
									<img src="{{ asset('images/article_box.png')}}">
									<div class="milestoneNameCount">
										<p>Article</p>
										<h4 id="typeId_1">0</h4>
									</div>
								</div>
								<div class="milestoneTypGrid">
									<img src="{{ asset('images/video_box.png')}}">
									<div class="milestoneNameCount">
										<p>Video</p>
										<h4 id="typeId_2">0</h4>
									</div>
								</div>
								<div class="milestoneTypGrid">
									<img src="{{ asset('images/podcast_box.png')}}">
									<div class="milestoneNameCount">
										<p>Podcast</p>
										<h4 id="typeId_3">0</h4>
									</div>
								</div>
								<div class="milestoneTypGrid">
									<img src="{{ asset('images/book_box.png')}}">
									<div class="milestoneNameCount">
										<p>Book</p>
										<h4 id="typeId_4">0</h4>
									</div>
								</div>
								<div class="milestoneTypGrid">
									<img src="{{ asset('images/course_box.png')}}">
									<div class="milestoneNameCount">
										<p>Course</p>
										<h4 id="typeId_5">0</h4>
									</div>
								</div>
								<div class="milestoneTypGrid">
									<img src="{{ asset('images/event_box.png')}}">
									<div class="milestoneNameCount">
										<p>Event</p>
										<h4 id="typeId_6">0</h4>
									</div>
								</div>
								<div class="milestoneTypGrid">
									<img src="{{ asset('images/assessment_box.png')}}">
									<div class="milestoneNameCount">
										<p>Assessment</p>
										<h4 id="typeId_7">0</h4>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="btn-footer">
			<a href="{{ back_url(route('peers.index'))}}" class="btn btn-green">{{ __('Back') }}</a>
		</div>
		<div class="comn_dataTable peerDataTable">
			<div class="listTitle mb-3">
				<h3>Learning Journey List</h3>
			</div>
			<div class="table-responsive">
				<table id="peerLearningJourneyList" class="table table-hover" style="width:100%">
				  <thead>
				  <tr>
					<th>Learning Journey Name </th>
					<th class="assigned_by">Assigned By</th>
					<th class="text-center">Points Earned</th>
					<th class="text-center">Progress</th>
					<th class="text-center">Action</th>
				  </tr>
				  </thead>
				  <tbody>
				  </tbody>
				</table>
			</div>
			<div class="row">
				<div class="col-md-5 px-0">
					<div class="listTitle mb-3">
						<h3>Group List</h3>
					</div>
					<div class="table-responsive">
						<table id="peerLearningGroupList" class="table table-hover" style="width:100%"> 
						  <thead>
						  <tr>
							<th>Group Name </th>
							<th class="text-center">Action</th>
						  </tr>
						  </thead>
						  <tbody>
						  </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
