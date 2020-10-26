@extends('layouts.app')
@section('content')

<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li class="active"><a>Passport</a></li>
		</ul>
		<div class="top_search_box">
			<form>
				<input id="dataTableSearch" type="input" name="serching" placeholder="Search" />
			</form>	
		</div>
	</div>
	<div class="page-content passport">
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
		<div class="green-box-big">
			<div class="inner-text">
				<p>Total Points for Individual Type of Milestones</p>
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
						<img src="{{ asset('images/article_box.png')}}">
						<div class="milestoneNameCount">
							<p>Assessment</p>
							<h4 id="typeId_7">0</h4>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="comn_dataTable passportFilter">
			<div class="row m-0">
				<div class="col-md-10">
					<div class="row m-0">
						<div class="listTitle col-md-2 p-0">
							<h3>Learning Journey List</h3>
						</div>
						<div class="top_left_form col-md-9 pr-0">
							<div class="row">
								<div class="form-group journeyName col-md-3 p-0 pr-2">
									<select class="form-control filterByJourneyId select2">
										<option value="">Journey Name</option>
										@if($joureny_filter)
											@foreach($joureny_filter as $filter)
											<option value="{{$filter->journey_name}}">{{$filter->journey_name}}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group assignedBy col-md-2 p-0 pr-2">
									<select class="filterByAssignedBy form-control select2">
										<option value="">Assigned By</option>
										@if($assigned_filter)
											@foreach($assigned_filter as $filter)
											@if($filter->assigned_by == user_id())
												@php($filter->assigned_name = __('lang.my_self'))
											@endif
											<option value="{{$filter->assigned_by}}">{{$filter->assigned_name}}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group completedDate date-rangePicker col-md-3 p-0 pr-2">
									<input type="text" class="filterByCompletedDate form-control daterangepicker" name="completed_date" placeholder="Completed Date" /> 
								</div>
								<div class="form-group pointEarned col-md-2 p-0  pr-2">
									<select class="filterByPointEarned form-control select2">
										<option value="">Points Earned</option>
										@if($points_filter)
											@foreach($points_filter as $filter)
											<option value="{{$filter->points}}">{{$filter->points}}</option>
											@endforeach
										@endif
									</select>
								</div>
								<div class="form-group rating col-md-2 p-0 pr-2">
									<select class="filterByRating form-control select2">
										<option value="">Rating</option>
										@if($rating_filter)
											@foreach($rating_filter as $filter)
											<option value="{{($filter->ratings == "") ? 0 : $filter->ratings}}">{{round($filter->ratings,2)}}</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="top_right_btn col-md-2">
				  <a title="{{ __('Backfill Milestones')}}" href="{{route('journeys.backfill_milesotne')}}" class="new-user btn btn-green pull-right"><i class="icon-plus"></i> {{ __('Backfill Milestones')}}</a>
				</div>
			</div>
			<div class="table-responsive">
				<table id="myLearningJourneyList" class="table table-hover" style="width:100%">
				  <thead>
				  <tr>
					<th>Journey Name </th>
					<th class="assigned_by">Assigned By</th>
					<th>Completed Date</th>
					<th>Points Earned</th>
					<th>Rating</th>
					<th>Progress</th>
					<th>Action</th>
				  </tr>
				  </thead>
				  <tbody>
				  </tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
