@extends('layouts.app')

@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb"> 
			<li class="active"><a>Latest Tempcheck List</a></li>
		</ul>
		<div class="top_search_box">
			<form>
				<input id="dataTableSearch" type="input" name="serching" placeholder="Search" />
			</form>	
		</div>
	</div>
	<div class="page-content tempCheck_list">
		<div class="pageTabTop">
			<ul class="nav nav-tabs" id="joureyTab">
				<li class="nav-item">
				  <a class="nav-link" href="{{route('tempchecks.index')}}" data-tabName="Tempcheck">Tempcheck</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link active"  data-toggle="tab" href="#myTrend" data-tabName="Latest Tempcheck">Latest Tempcheck</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="{{route('tempchecks.assigned_index')}}" data-tabName="My Trends">My Trends</a>
				</li>
			 </ul>
			<div class="tab-content">
				<div id="myTrend" class="tab-pane active">
					<div class="comn_dataTable"> 
						<div class="top_fileter">
							<div class="top_left_form">
								<div class="row m-0">
									<div class="form-group freQuency col-md-5 p-0">
										<select class="form-control filterByAssignee select2">
										<option value="">Assignee</option>						
										@if($assignee_filter)
											@foreach($assignee_filter as $assignee)
													<option value="{{$assignee->user_id}}">{{$assignee->first_name}} {{$assignee->last_name}}</option>
											@endforeach
										@endif				
										</select>
									</div>
									<div class="form-group freQuency col-md-7 p-0 pl-2">
										<select class="form-control filterByDesignation select2">
										<option value="">Designation</option>
										@if($user_filter)
											@foreach($user_filter as $user)
												@if($user->designation != "")
													<option value="{{$user->designation}}">{{$user->designation}}</option>
												@endif
											@endforeach
										@endif										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table id="tempcheckTrendList" class="table table-striped">
								<thead>
								  <tr>
									<th>Assignee</th>
									<th>Employee Email ID </th>
									<th>Designation</th>
									<th class="text-center">Average Ratings </th>
									<th>Action</th>
								  </tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection