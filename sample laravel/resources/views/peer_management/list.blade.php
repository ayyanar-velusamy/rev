@extends('layouts.app')
@section('content')

<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb">
			<li class="active"><a>Peers</a></li>
		</ul>
		<div class="top_search_box">
			<form>
				<input id="dataTableSearch" type="input" name="serching" placeholder="Search" />
			</form>	
		</div>
	</div>
	<div class="page-content passport">
		<div class="comn_dataTable peersFilter">
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
						<div class="form-group pointEarned col-md-2 p-0  pr-2">
							<select class="filterByPoint form-control select2">
								<option value="">Points Earned</option>
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
							<select class="filterByCount form-control select2">
								<option value="">Total of all Milestones Completed</option>
								@if($point_filter)
									@foreach($point_filter as $point)
									@if($point->points_earned != "")
									<option value="{{$point->completed_milestone_count}}">{{$point->completed_milestone_count}}</option>
									@endif
									@endforeach
								@endif
							</select>
						</div>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table id="peersList" class="table table-hover" style="width:100%">
				  <thead>
				  <tr>
					<th class="profile_picture text-center">Profile Picture </th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Designation</th>
					<th class="text-center">Points Earned</th>
					<th class="text-center">Total of all <span>Milestones Completed</span></th>
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
