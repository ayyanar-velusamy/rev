@extends('layouts.app')
@section('content')
<div class="page-innerwrap">
	<div class="page-head">
		<ul class="list-inline breadcrumb"> 
			<li class="active"><a>Page Management List</a></li>  
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
			<a title="Add User" href="pages/create" class="new-user btn btn-green pull-right"><i class="icon-plus"></i> Add Page</a> 
			@endcan
		</div>
		<div class="comn_dataTable"> 
			<div class="table-responsive">
				<table id="pageList" class="table dataTable" style="width:100%"> 
					<thead> 
						<tr>
							<th>Title</th>
							<th>Meta Description</th>
							<th>Meta Keyword</th> 
							<th>Status</th>
							<th class="actions">Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div> 
 
<div class="modal modal-danger fade" id="pageDelete">
		<div class="modal-dialog modal-dialog-centered">
		  <div class="modal-content">
			<div class="modal-header">	
				<h2>Delete Page</h2>
				<button type="button" class="btn-close" title="Close" data-dismiss="modal">x</button>
			</div>
			<div class="modal-body">
				<input type="hidden" id="pageDeleteId">
				<h4 id="statusActive">Deleting a Page from the system permanently removes Page data from the application. Instead, we recommend deactivating the Page. This will retain Page Data or analytics purposes so please review the following options and decide </h4>
				
				<h4 id="statusInactive">Are you sure <span>you want to delete <span id="pageDeleteName"></span>?</span></h4>
				
				<div class="btn-footer">
				  <button type="button" id="deletePageInactive" class="btn btn-green modal-Inactive-yes">Inactive</button>
				  <button type="button" id="deletePageYes" class="btn btn-red modal-submit-yes">Delete</button>
				  <button type="button" id="deletePageCancel" class="btn btn-grey" data-dismiss="modal">Cancel</button>
				</div>
		  </div>
		  <!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</div>


@endsection
