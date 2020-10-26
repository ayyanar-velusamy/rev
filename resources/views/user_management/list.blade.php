@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb"> 
			<li class="active"><a>User Management List</a></li>
		</ul>
		<div class="top_search_box">
			<form>
				<input id="dataTableSearch" type="input" name="serching" placeholder="Search" />
			</form>	
		</div>
	</div>
	<div class="page-content">
		<div class="top_right_btn">
			@can('add_users')
			<button title="Import User" data-toggle="modal" data-target="#bulkImp" class="import-user btn btn-lightblue pull-right">Import User</button>
			@endcan
			@can('add_users')
			<a title="Add User" href="/users/create" class="new-user btn btn-green pull-right"><i class="icon-plus"></i> Add User</a> 
			@endcan
		</div>
		<div class="comn_dataTable"> 
			<div class="table-responsive">
				<table id="userList" class="table dataTable" style="width:100%"> 
					<thead> 
						<tr>
							<th>User Name</th>
							<th>Email ID</th>
							<th>Phone Number</th>
							<th>Role Name</th>
							<th>Status</th>
							<th class="actions">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

@can('add_users')
<!-- bulk import -->
<div id="bulkImp" class="modal fade" role="dialog" aria-modal="true"  data-backdrop="static">
   <div class="modal-dialog modal-dialog-centered"> 
	<!-- Modal content-->
		<div class="modal-content text-left">
			{!! Form::open([ 'route' => 'bulk_upload', 'enctype' => 'multipart/form-data', 'class' => 'clearfix ajax-form', 'id' => 'hrBulk' ]) !!}
			<div class="modal-header">
				<h2>Import User</h2>
				<button type="reset" onclick="resetBlukUpload()" title="Close" class="btn-close">x</button>
			</div>
			<div class="modal-body">
				<div id="uploadSection">
					<div class="row">
						<div class="form-group col-sm-6">
							<label for="bulkimphrcsv" class="import_label">Import CSV <span>*</span></label>
							<div class="import_userdet import_file"> 
								<span class="inport_file_con csv_span" tabindex="0">Import CSV</span>
								<input type="file" tabindex="-1" class="form-control bulk-imp" name="bulkimphrcsv" id="bulkimphrcsv"  accept=".csv,text/csv,application/vnd.ms-excel"/> 
							</div>							
							<p>File Format Accepted: <span class="fw600 text-green">.csv</span></p>
							<p class="sample">Sample Data for CSV: <a href="{{ asset('public/sample_data/Employee-Sampledata.csv') }}" target="_blank">Download</a><p>
						</div>
						<div class="form-group col-sm-6 pr-0">
							<label for="bulkimphrcsv" class="import_label">Import ZIP for Profile Image</label>
							<div class="import_userimg import_file"> 
								<span class="inport_file_con zip_span" tabindex=0>Import ZIP for Profile Image</span>
								<input type="file" class="form-control bulk-imp" tabindex="-1" name="bulkimphrzip" id="bulkimphrzip"  accept=".zip,application/zip"/> 
							</div>	
							<p>File Format Accepted: <span class="fw600 text-green">zip</span></p>
							<p class="sample">Sample Data for Profile Image: <a href="{{ asset('public/sample_data/Sample_image.zip') }}" target="_blank">Download</a><p>
						</div>
					</div>
					<div class="btn-footer">
						<button type="reset" onclick="resetBlukUpload()" class="btn-grey btn" >Cancel</button>
						<button type="submit" class="btn-green btn " id="importehrsub">Save</button>
					</div>
				</div>
				<div id="uploadErrorSection">
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@endcan

<div class="modal modal-danger fade" id="userDelete">
		<div class="modal-dialog modal-dialog-centered">
		  <div class="modal-content">
			<div class="modal-header">	
				<h2>Delete User</h2>
				<button type="button" class="btn-close" title="Close" data-dismiss="modal">x</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="userDeleteId">
				<h4 id="statusActive">Deleting a User from the system permanently removes User data from the application. Instead, we recommend deactivating the User. This will retain User Data or analytics purposes so please review the following options and decide </h4>
				
				<h4 id="statusInactive">Are you sure <span>you want to delete <span id="userDeleteName"></span>?</span></h4>
				
				<div class="btn-footer">
				  <button type="button" id="deleteUserInactive" class="btn btn-green modal-Inactive-yes">Inactive</button>
				  <button type="button" id="deleteUserYes" class="btn btn-red modal-submit-yes">Delete</button>
				  <button type="button" id="deleteUserCancel" class="btn btn-grey" data-dismiss="modal">Cancel</button>
				</div>
		  </div>
		  <!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</div>


@endsection
