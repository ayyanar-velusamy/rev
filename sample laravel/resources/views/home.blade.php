@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li class="active"><a>Dashboard</a></li>
		</ul>
	</div>
	<div class="page-content Dashboard">
		<div class="pageTabTop">
			<ul class="nav nav-tabs mb-4" id="dashTab">
				<li class="nav-item">
				  <a class="nav-link " data-toggle="tab" href="#journeyOverview" data-tabName="Journey Overview">Journey Overview</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link active" href="#applicationStatistics" data-tabName="Application Statistics">Application Statistics</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="#reports" data-tabName="Reports">Reports</a>
				</li>
			 </ul>
			<div class="tab-content">
				<div id="journeyOverview" class="tab-pane">
					<div class="top_fileter">
						<div class="top_left_form">
							<div class="form-group createdDate date-rangePicker">
								<input type="text" class="filterByDueDate form-control daterangepicker" name="due_date" placeholder="Journeys by date" />
							</div>
						</div>
						<div class="top_right_btn">
							  @can('add_tempchecks')
							  <a title="Add Tempcheck" href="" class="new-user btn btn-green pull-right">View points</a> 
							  @endcan
						</div>
					</div>
					<div class="white-box blu-strip-top">	
						<div class="white-box-head">	
							<h2>Journey Overivew</h2>
						</div>
						<div class="white-content mb-2">
							<div class="inner-content">
								<div class='jyTimeline px-5 pb-4'>
									<ul id='journeyTimeline'>
										<li class='journeytype completed blueLine'>
											<span class="circle"></span>
											<div class='content'>
											  <div class="journeyTitle toolipTarget aDiv" title="<h4>On-Boarding</h4><p>Lorem Ipsum is simply dummy text of the printing and typesetting </p>">On-Boarding </div>
											</div> 
										</li>
										<li class='journeytype completed blueLine'>
											<span class="circle"></span>
											<div class='content'>
											   <div class="journeyTitle toolipTarget aDiv" title="<h4>On-Boarding</h4><p>Lorem Ipsum is simply dummy text of the printing and typesetting </p>">Sales</div>
											</div> 
										</li>
										<li class='journeytype completed blueLine'>
											<span class="circle"></span>
											<div class='content'>
											   <div class="journeyTitle toolipTarget aDiv" title="<h4>On-Boarding</h4><p>Lorem Ipsum is simply dummy text of the printing and typesetting </p>">Personal</div>
											</div> 
										</li>
										<li class='journeytype completed blueLine last'>
											<span class="circle"></span>
											<div class='content'>
											   <div class="journeyTitle toolipTarget aDiv" title="<h4>On-Boarding</h4><p>Lorem Ipsum is simply dummy text of the printing and typesetting </p>">Business</div>
											</div> 
										</li>
										<li class='journeytype'>
											<span class="circle"></span>
											<div class='content'>
											   <div class="journeyTitle toolipTarget aDiv" title="<h4>On-Boarding</h4><p>Lorem Ipsum is simply dummy text of the printing and typesetting </p>">Marketing</div>
											</div> 
										</li>
										<li class='journeytype'>
											<span class="circle"></span>
											<div class='content'>
											   <div class="journeyTitle toolipTarget aDiv" title="<h4>On-Boarding</h4><p>Lorem Ipsum is simply dummy text of the printing and typesetting </p>">Services</div>
											</div> 
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="white-box blu-strip-top">	
						<div class="white-box-head">	
							<h2>Journey Breakdown</h2>
						</div>
						<div class="white-content mb-2">
							<div class="dashTopProgress">
								<h3>On-Boarding <span>(my Learning Journey)</span></h3>
								<div class="form-group proGress">
									<label>Journey Progress</label>
									<div id="inputProgressName" class="progress">				
										<div class="progress-bar" style="width:70%"><span>70%</span></div>
									</div>
								</div>
							</div>
							<div class="inner-content">
								<div class='msTimeline onBoarding pb-4' >
									<ul id='milestone_timeline'>
										<li class='mileStone completed'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a class='btn-lightblue' data-toggle='modal' data-target='#milstoneRatingAdd' >Mark as Complete</a> <a data-toggle='modal' data-target='#milstoneNotesEdit'class='btn-blue' >Notes</a>">Milestone 1</div>
												<div class="mileStoneIcon article"></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 2</div>
												<div class="mileStoneIcon video" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 3</div>
												<div class="mileStoneIcon podcast" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 4</div>
												<div class="mileStoneIcon book" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 5</div>
												<div class="mileStoneIcon event" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 6</div>
												<div class="mileStoneIcon course" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 7</div>
												<div class="mileStoneIcon assessment" ></div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="white-content mb-2">
							<div class="dashTopProgress">
								<h3>Sales <span>(My Learning Journey)</span></h3> 
								<div class="form-group proGress">
									<label>Journey Progress</label>
									<div id="inputProgressName" class="progress">				
										<div class="progress-bar" style="width:70%"><span>70%</span></div>
									</div>
								</div>
							</div>
							<div class="inner-content">
								<div class='msTimeline sales pb-4' >
									<ul id='milestone_timeline'>
										<li class='mileStone completed'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 1</div>
												<div class="mileStoneIcon article" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 2</div>
												<div class="mileStoneIcon video" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 3</div>
												<div class="mileStoneIcon podcast" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 4</div>
												<div class="mileStoneIcon book" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 5</div>
												<div class="mileStoneIcon event" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 6</div>
												<div class="mileStoneIcon course" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 7</div>
												<div class="mileStoneIcon assessment" ></div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="white-content mb-2  pb-5">
							<div class="dashTopProgress">
								<h3>Personal <span>(Group Journey)</span></h3> 
								<div class="form-group proGress">
									<label>Journey Progress</label>
									<div id="inputProgressName" class="progress">				
										<div class="progress-bar" style="width:70%"><span>70%</span></div>
									</div>
								</div>
							</div>
							<div class="inner-content">
								<div class='msTimeline personalGroup pb-4' >
									<ul id='milestone_timeline'>
										<li class='mileStone completed'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 1</div>
												<div class="mileStoneIcon article" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 2</div>
												<div class="mileStoneIcon video" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 3</div>
												<div class="mileStoneIcon podcast" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 4</div>
												<div class="mileStoneIcon book" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 5</div>
												<div class="mileStoneIcon event" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 6</div>
												<div class="mileStoneIcon course" ></div>
											</div>
										</li>
										<li class='mileStone'>
											<div class='content'>
											  <div class="mileStoneTitle mstoolipTarget" title="<a href='' class='btn-lightblue' >Mark as Complete</a><a href='' class='btn-blue' >Notes</a>">Milestone 7</div>
												<div class="mileStoneIcon assessment" ></div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="applicationStatistics" class="tab-pane active">
					<div class="white-box blu-strip-top">	
						<div class="white-box-head">	
							<h2>Application Statistics</h2>
						</div>
						<div class="white-content mb-2">
							<h3>Users</h3> 
							<div class="inner-content">
								<div class="appsStatsTop">
									<div class="countBarGrid">
										<div class="countBar blue">
											<span class="iconImage"><img src="{{asset('images/countUserIcon.png') }}" /></span>
											<h4>{{$count['user']}} <span>Users</span> </h4>
										</div>
									</div>
									<div class="countBarGrid">
										<div class="countBar green">
											<span class="iconImage"><img src="{{asset('images/countGroupIcon.png') }}" /></span>
											<h4>{{$count['group']}} <span>Groups</span> </h4>
										</div>
									</div>
									<div class="countBarGrid">
										<div class="countBar blue">
											<span class="iconImage"><img src="{{asset('images/countUserIcon.png') }}" /></span>
											<h4>500 <span>Logged in Users</span> </h4>
										</div>
									</div>
									<div class="countBarGrid">
										<div class="countBar green">
											<span class="iconImage"><img src="{{asset('images/countTempcheckIcon.png') }}" /></span>
											<h4>{{$count['tempcheck']}} <span>Tempchecks</span> </h4>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="white-content mb-2">
							<h3>Journeys</h3> 
							<div class="inner-content">
								<div class="row appsStatsMid">
									<div class="col-md-2 countJoueneyGrid pl-0">
										<img src="{{asset('images/countJourneyIcon1.png') }}" />
										<h4>125<span>Created by Users</span></h4>
									</div>
									<div class="col-md-2 countJoueneyGrid">
										<img src="{{asset('images/countJourneyIcon2.png') }}" />
										<h4>50<span>Predefined Journeys</span></h4>
									</div>
									<div class="col-md-2 countJoueneyGrid">
										<img src="{{asset('images/countJourneyIcon1.png') }}" />
										<h4>10<span>Assigned Journeys</span></h4>
									</div>
									<div class="col-md-2 countJoueneyGrid">
										<img src="{{asset('images/countJourneyIcon2.png') }}" />
										<h4>05<span> Ongoing Journeys</span></h4>
									</div>
									<div class="col-md-2 countJoueneyGrid">
										<img src="{{asset('images/countJourneyIcon1.png') }}" />
										<h4>10<span>Completed Journeys</span></h4>
									</div>
								</div>
							</div>
						</div>
						<div class="white-content mb-2">
							<h3>Milestones</h3> 
							<div class="inner-content">
								<div class="row appsStatsMid">
									<div class="col-md-2 countJoueneyGrid pl-0">
										<img src="{{asset('images/countMilestoneIcon1.png') }}" />
										<h4>125<span>Total Milestones</span></h4>
									</div>
									<div class="col-md-2 countJoueneyGrid">
										<img src="{{asset('images/countMilestoneIcon2.png') }}" />
										<h4>50<span>Ongoing Milestone</span></h4>
									</div>
									<div class="col-md-2 countJoueneyGrid">
										<img src="{{asset('images/countMilestoneIcon3.png') }}" />
										<h4>10<span>Milestones in Library</span></h4>
									</div>
									<div class="col-md-2 countJoueneyGrid">
										<img src="{{asset('images/countMilestoneIcon4.png') }}" />
										<h4>05<span> Completed Milestones</span></h4>
									</div>
								</div>
							</div>
						</div>	
					</div>	
					<div class="row chartGrid">
						<div class="col-md-4 pieChartWidth two pl-0 pr-4">
							<div class="white-box blu-strip-top">	
								<div class="white-box-head">	
									<h2>Approvals</h2>
								</div>
								<div class="white-content">
									<div class="inner-content px-0">
										<div id="graphApproaval"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 pieChartWidth pl-0 pr-4">
							<div class="white-box blu-strip-top">	
								<div class="white-box-head">	
									<h2>Library</h2>
								</div>
								<div class="white-content">
									<div class="inner-content px-0">
										<div id="graphLibrary"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 topPoints px-0">
							<div class="white-box blu-strip-top">	
								<div class="white-box-head">	
									<h2>Top five users with respect to points</h2>
								</div>
								<div class="white-content pt-0" id="topFiveUser">
									<div class="row inner-content px-0">
										<div class="col-md-3 topUserImg pl-4 pr-0">
											<img src="{{asset('images/dash_user.png') }}" />		
										</div>
										<div class="col-md-9 topUserInfo pl-3">
											<h4>David Ayers</h4>
											<h5>80 <span>Points</span></h5>
										</div>
									</div>
									<div class="row inner-content px-0">
										<div class="col-md-3 topUserImg pl-4 pr-0">
											<img src="{{asset('images/dash_user.png') }}" />		
										</div>
										<div class="col-md-9 topUserInfo pl-3">
											<h4>David Ayers</h4>
											<h5>80 <span>Points</span></h5>
										</div>
									</div>
									<div class="row inner-content px-0">
										<div class="col-md-3 topUserImg pl-4 pr-0">
											<img src="{{asset('images/dash_user.png') }}" />		
										</div>
										<div class="col-md-9 topUserInfo pl-3">
											<h4>David Ayers</h4>
											<h5>80 <span>Points</span></h5>
										</div>
									</div>
									<div class="row inner-content px-0">
										<div class="col-md-3 topUserImg pl-4 pr-0">
											<img src="{{asset('images/dash_user.png') }}" />		
										</div>
										<div class="col-md-9 topUserInfo pl-3">
											<h4>David Ayers</h4>
											<h5>80 <span>Points</span></h5>
										</div>
									</div>
									<div class="row inner-content px-0">
										<div class="col-md-3 topUserImg pl-4 pr-0">
											<img src="{{asset('images/dash_user.png') }}" />		
										</div>
										<div class="col-md-9 topUserInfo pl-3">
											<h4>David Ayers</h4>
											<h5>80 <span>Points</span></h5>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
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

@endsection
