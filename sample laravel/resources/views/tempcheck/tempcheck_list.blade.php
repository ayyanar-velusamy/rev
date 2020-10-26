@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb"> 
			<li class="active"><a>Tempcheck List</a></li>
		</ul>
		<div class="top_search_box">
			<form>
				<input id="dataTableSearch" type="input" name="serching" placeholder="Search" />
			</form>	
		</div>
	</div>
	<div class="page-content tempCheck_list ">
		<div class="pageTabTop">
			<ul class="nav nav-tabs" id="joureyTab">
				<li class="nav-item">
				  <a class="nav-link active" data-toggle="tab" href="#tempcheck" data-tabName="Tempcheck">Tempcheck</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="{{route('tempchecks.trend_index')}}" data-tabName="Latest Tempcheck">Latest Tempcheck</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link" href="{{route('tempchecks.assigned_index')}}" data-tabName="My Trends">My Trends</a>
				</li>
			 </ul>
			<div class="tab-content">
				<div id="tempcheck" class="tab-pane active">
					<div class="top_fileter">
						<div class="top_left_form">
							<div class="row m-0">
								<div class="form-group freQuency col-md-5 p-0">
									<select class="form-control filterFrequency select2">
										<option value="">Frequency</option>						
										<option value="weekly">Weekly</option>					
										<option value="bi-weekly">Bi-weekly</option>			
										<option value="monthly">Monthly</option>				
									</select>
								</div>
								<div class="form-group createdDate date-rangePicker col-md-7 p-0 pl-2">
									<input type="text" class="filterByDueDate form-control daterangepicker" name="due_date" placeholder="Due Date" />
								</div>
							</div>
						</div>
						<div class="top_right_btn">
							  @can('add_tempchecks')
							  <a title="Add Tempcheck" href="/tempchecks/create" class="new-user btn btn-green pull-right"><i class="icon-plus"></i> Add Tempcheck</a> 
							  @endcan
						</div>
					</div>
					<div class="comn_dataTable"> 
						<div class="table-responsive">
							<table id="tempcheckList" class="table dataTable table-striped"> 
								<thead> 
									<tr>
										<th>Tempcheck Question </th>
										<th>Frequency</th>
										<th>Due Date</th>
										<th class="actions">Action</th>
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
