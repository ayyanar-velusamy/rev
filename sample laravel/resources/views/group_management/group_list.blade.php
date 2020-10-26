@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb journey"> 
			<li class="active"><a>Group Management List</a></li> 
		</ul>
		<div class="top_search_box">
			<form>
				<input id="dataTableSearch" type="input" name="serching" placeholder="Search" />
			</form>	
		</div>
	</div>
	<div class="page-content group_list"> 
		<!-- general form elements -->
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
					<div class="form-group adminId col-md-2 p-0 pl-2">
						<select class="filterByAdminId form-control select2">
							<option value="">Group Admin Name</option>
							@if($admins)
								@foreach($admins as $admin)
									@if($admin->user_id == user_id())
										@php($admin->admin_name = "Me")
									@endif
									<option value="{{ $admin->user_id }}" > 
									{{ $admin->admin_name }}</option>
								@endforeach
							@endif											
						</select>
					</div>
					<div class="form-group createdBy col-md-2 p-0 pl-2 ">
						<select class="filterByCreatedBy form-control select2">
							<option value="">Created By</option>
							@if($created_by)
								@foreach($created_by as $created)
									@if($created->user_id == user_id())
										@php($created->created_name = "Me")
									@endif
									<option value="{{ $created->user_id }}" > 
									{{ $created->created_name }}</option>
								@endforeach
							@endif
						</select>
					</div>
					<div class="form-group createdDate date-rangePicker col-md-2 p-0 pl-2">
						<input type="text" class="filterByCreatedDate form-control daterangepicker" name="created_date" placeholder="Created Date" />
					</div>
					<div class="form-group memberCount col-md-2 p-0 pl-2">
						<select class="filterByMemberCount form-control select2">
							<option value="">Total Group Members</option>
							@if($member_count)
								@foreach($member_count as $m_count)
									<option value="{{ $m_count }}" > 
									{{ $m_count }}</option>
								@endforeach
							@endif											
						</select>
					</div>
					<div class="form-group journeyCount col-md-2 p-0 pl-2">
						<select class="filterByJourneyCount form-control select2">
							<option value="">Total Learning Journeys</option>
							<option value="0" >0</option>
							@if($journey_count)
								@foreach($journey_count as $j_count)
									<option value="{{ $j_count }}" > 
									{{ $j_count }}</option>
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
				<table id="groups-list-table" class="table table-hover" style="width:100%">
					<thead>
						<tr>
							<th class="group_name">Group Name</th>
							<th class="group_admin">Group <span>Admin Name</span></th>
							<th>Created By</th>
							<th>Created Date</th>
							<th class="total_group_members">Total <span>Group Members</span></th>
							<th class="total_leaning_joutney">Total <span>Learning Journeys</span></th>
							<th class="action">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
