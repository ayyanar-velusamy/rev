@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb"> 
			<li class="active"><a>User Roles Management List</a></li>
		</ul>
		<div class="top_search_box">
			<form>
				<input type="input" id="dataTableSearch" name="serching" placeholder="Search" />
			</form>	
		</div>
	</div>
	<div class="page-content">
		<div class="top_right_btn">
			@can('add_roles')<a title="Add Role" href="/roles/create" class="new-roles btn btn-green pull-right"><i class="icon-plus"></i> Add Role</a> @endcan
		</div>
		<div class="comn_dataTable">
			<div class="table-responsive">
				<table id="roleList" class="table dataTable" style="width:100%">
					<thead>
						<tr>
							<th>Role Name</th>
							<th>Created Date & Time</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
				    </thead>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
