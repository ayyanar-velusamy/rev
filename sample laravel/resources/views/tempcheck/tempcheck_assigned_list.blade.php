@extends('layouts.app')

@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb"> 
			<li class="active"><a>My Trends</a></li>
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
				  <a class="nav-link" href="{{route('tempchecks.trend_index')}}"  data-tabName="Latest Tempcheck">Latest Tempcheck</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link active" data-toggle="tab" href="#myTrend"  data-tabName="My Trends">My Trends</a>
				</li>
			 </ul>
			<div class="tab-content">
				<div id="myTrend" class="tab-pane active"><br>
					<div class="comn_dataTable"> 
						<div class="top_fileter tempcheckAssigned">
							<div class="top_left_form  ">
								<div class="row m-0">
									<div class="form-group AssignedBy col-md-4 pr-1 pl-0 ">
										<select class="form-control filterAssignedBy select2">
											<option value="">Assigned By</option>@if($assigned_filter)
												@foreach($assigned_filter as $assigned)
														<option value="{{$assigned->user_id}}">{{$assigned->first_name}} {{$assigned->last_name}}</option>
												@endforeach
											@endif									
										</select>
									</div>
									<div class="form-group freQuency col-md-4 px-1">
										<select class="form-control filterFrequency select2">
										<option value="">Frequency</option>						
										<option value="weekly">Weekly</option>					
										<option value="bi-weekly">Bi-weekly</option>			
										<option value="monthly">Monthly</option>				
										</select>
									</div>
									<div class="form-group createdDate date-rangePicker col-md-4 pl-1 pr-0 ">
										<input type="text" class="filterByDueDate form-control daterangepicker" name="due_date" placeholder="Due Date" />
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive">
							<table id="tempcheckAssignedList" class="table table-striped">
								<thead>
								  <tr>
									<th>Assigned By</th>
									<th>Frequency</th>
									<th>Due Date</th>
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